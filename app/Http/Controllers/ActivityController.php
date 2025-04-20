<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ExpelledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use App\Models\Lessons;
use App\Models\Notification;
use App\Models\SchedulesList;
use App\Models\Teacher;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function admin_login()
    {
        return view('Admin/admin_login');
    }

    public function adminLoginPost(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if($request->username == 'Admin'){
            // Check if user is an admin
            $admin = Admin::where('name', $request->username)->first();
            
            if ($admin && Hash::check($request->password, $admin->password)) {
                // Save the admin ID in the session
                session(['admin_id' => $admin->id]);
                session(['role' => 'admin']);

                // Redirect to the admin dashboard
                return redirect()->route('admin.dashboard');
            }
        } else {
            // If not an admin, check if user is a staff
            $staff = Admin::where('name', $request->username)->first();

            if ($staff && Hash::check($request->password, $staff->password)) {
                // Save the staff ID in the session
                session(['staff_id' => $staff->id]);
                session(['role' => 'staff']);

                // Redirect to the staff dashboard
                return redirect()->route('staff.dashboard');
            }
        }
        // Return a response for invalid login
        return response()->json([
            'message' => 'Invalid username or password',
        ], 401);
    }

    public function resetPassword(){
        return view('Admin.reset_password');
    }


    public function logoutAdmin(Request $request){

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function admin_dashboard()
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $schedule = Course::all();
        $enrolled = EnrolledStudent::all()->count();
        $walkIn = SchedulesList::all()->count();
        $courses = [];

        // Get all the inquired_courses per row
        $inquiredCourses = SchedulesList::pluck('inquired_courses')->toArray();
        
        foreach ($inquiredCourses as $courseList) {
            if ($courseList) {
                // Separate comma-separated courses and trim spaces
                $separatedCourses = array_map('trim', explode(',', $courseList));
                
                // Push each course into the courses array
                foreach ($separatedCourses as $course) {
                    $courses[] = $course;
                }
            }
        }
        
        // Count occurrences of each course
        $courseCounts = array_count_values($courses);
        $il = ILStudents::where('status', '!=', 'Pending')->count();
        return view('Admin/admin_dashboard', [
            'schedule' => $schedule,
            'enrolled_count' => $enrolled,
            'walkin_count' => $walkIn,
            'il_count' => $il,
            'courseCounts' => $courseCounts,
        ]);
    }

    public function createAdmin(Request $request){
        $password = 'Staff01';
        $hashedPassword = Hash::make($password);

        $data = [
            'name' => 'Staff',
            'password' => $hashedPassword
        ];

        $create = Admin::create($data);
        if($create){
            return view('Admin.admin_login');
        }
    }

    public function admin_schedule()
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $schedule = Course::where('status', 'Started')->get();
        $courses = AvailableCourse::all();
        $teachers = Teacher::all();
        return view('Admin/admin_schedule', ['schedule' => $schedule, 'courses' => $courses, 'teachers' => $teachers]);
    }

    public function il_schedule()
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }
        

        $sched = ILSchedule::where('status', 'Ongoing')->with('teacher')->get();
        $teachers = Teacher::all();
        $courses = AvailableCourse::all();
        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        // dd($sched);

        return view('Admin/il_schedule', ['schedule' => $sched, 'courses' => $courses, 'teachers' => $teachers]);
    }

    public function for_scheduling()
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $course = AvailableCourse::all();
        $scheduling = SchedulesList::where('status', 'Pending')->take(8)->get();
        $scheduledCount = SchedulesList::where('status', 'Pending')->count();
        return view('Admin/for_scheduling', ['scheduling' => $scheduling, 'course' => $course, 'scheduled' => $scheduledCount]);
    }

    public function add_client(Request $request)
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }
        $childsName = $request->input('childs_name');
        $parentsLastName = $request->input('parents_last_name');
        $age = $request->input('age');
        if (SchedulesList::where('childs_name', $childsName)
            ->where('parents_last_name', $parentsLastName)
            ->where('age', $age)
            ->exists()) {
            
            // Redirect back with error message if duplicate is found
            return redirect()->back()->with('addClientError', 'Child data already exists.');
        }

        // Validate input
        $data = $request->validate([
            'parents_first_name' => 'required|string|max:255',
            'parents_last_name' => 'required|string|max:255',
            'childs_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'contact_number' => 'required|string|max:20',
            'email_address' => 'required|email|max:255',
            'inquired_courses' => 'nullable|array',
            'status' => 'nullable|string',
        ]);

        // Generate a unique transaction ID
        $initials = strtoupper(substr($data['parents_first_name'], 0, 1) . substr($data['parents_last_name'], 0, 1));
        $date = now()->format('mdY'); // e.g., 04042025
        $randomDigits = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        $transactionID = "{$initials}-{$date}-{$randomDigits}";

        $data['transaction_id'] = $transactionID;

        // Convert inquired courses to a comma-separated string
        $data['inquired_courses'] = isset($data['inquired_courses']) ? implode(', ', $data['inquired_courses']) : null;

        // Set default status
        $data['status'] = $request->input('status', 'Pending');

        try {
            $client = SchedulesList::create($data);
            session()->flash('succees', 'Client added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error adding client: ' . $e->getMessage()); // I-log ang error
            session()->flash('addError', 'Failed to add client. Please try again.');
            return redirect()->back();
        }
        
    }

    public function update_client(Request $request)
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $client = SchedulesList::where('id', $request->input('id'))->first();
        if ($client) {
            $client->update([
                'parents_first_name' => $request->input('parents_first_name'),
                'parents_last_name' => $request->input('parents_last_name'),
                'childs_name' => $request->input('childs_name'),
                'age' => $request->input('age'),
                'contact_number' => $request->input('contact_number'),
                'email_address' => $request->input('email_address'),
                'status' => 'Pending',
            ]);

            // Optionally, you can return a response indicating success
            return redirect()->back()->with('success', 'Client updated successfully');
        } else {
            // Optionally, handle the case where the client is not found
            return redirect()->back()->with('error', 'Client not found');
        }
    }

    public function delete_client($id)
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        // Delete the data
        SchedulesList::where('id', $id)->delete();

        // Redirect back to the current page
        return redirect()->route('admin.schedule.for_scheduling')->with('success', 'Client deleted succesfully.');
    }

    public function getSchedules($course)
{
    $schedules = ILSchedule::where('course', $course)->where('status', 'Ongoing')->get();

    $schedules->transform(function ($schedule) {
        $schedule->time_slot = "{$schedule->from} to {$schedule->to} | {$schedule->mm} {$schedule->dd} - {$schedule->day}";
        return $schedule;
    });

    // Map the transformed data to include both code and teacher
    $formatted_schedules = $schedules->mapWithKeys(function ($schedule) {
        return [$schedule->time_slot => ['code' => $schedule->code, 'teacher' => $schedule->teacher]];
    });

    return response()->json($formatted_schedules);
}


    public function proceedToIl(Request $request)
    {
if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        Log::info($request);

        $student = $request->validate([
            'code' => 'required',
            'course' => 'required',
            'student_name' => 'required',
            'parent_name' => 'required',
            'age' => 'required',
            'contact_number' => 'required',
            'email_address' => 'required',
            'status' => 'nullable',
        ]);


        // Generate student number
        $nameParts = explode(' ', $student['student_name']);
        $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : 'X'));
        $date = now()->format('mdY'); // e.g., 04042025
        $randomDigits = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        $student_number = "{$initials}-{$date}-{$randomDigits}";


        $student['status'] = $request->input('status', 'Pending');
        $student['student_number'] = $student_number;
        $childsName = $request->input('childs_name');

        $ILSched = ILSchedule::where('code', $request->input('code'))->first();
        $notification = [
            'teacher' => $request->input('teacher_id'),
            'type' => 'New Il student',
            'course' => $request->input('course'),
            'code' => $request->input('code'),
            'date_time' => "{$ILSched->day} {$ILSched->from} - {$ILSched->to}",
            'student_name' => $request->input('student_name'),
            'status' => 'sent'
        ];

        Notification::create($notification);

        // Find the schedule by childs_name
        $studentStatus = SchedulesList::where('id', $request->input('student_id'))->first();

        // Check if a record is found before attempting to update
        if ($studentStatus) {
            $studentStatus->update([
                'status' => 'Scheduled',
            ]);
        }

        ILStudents::create($student);

        return redirect()->route('admin.schedule.for_scheduling')->with('success', 'Status updated succesfully.');
    }

    public function openIl($code)
{
    if (session('role') !== 'admin') {
        return abort(403, 'Unauthorized access.');
    }

    $courses = AvailableCourse::all();
    $sched = ILSchedule::all();
    $il_schedule = ILSchedule::where('code', $code)->with('il_students')->first();

    // Check if $il_schedule exists to prevent errors
    if (!$il_schedule) {
        return abort(404, 'Schedule not found.');
    }

    $sched->transform(function ($time) {
        $time->time_slot = "{$time->from} to {$time->to}";
        return $time;
    });

    // Filter students where status is NOT 'Did not attend' and NOT 'Enrolled'
    $students = $il_schedule->il_students->reject(function ($student) {
        return in_array($student->status, ['Did not attend', 'Enrolled', 'Archived', 'Expelled']);
    });

    return view('Admin/admin_show_il_class', [
        'il_schedule' => $il_schedule,
        'students' => $students,
        'sched' => $sched,
        'courses' => $courses,
    ]);
}



    public function sample()
    {
        $course = AvailableCourse::all();
        return view('Admin/admin_sample', ['course' => $course]);
    }

    public function fetchData(Request $request)
    {
        $course = $request->input('selectedValue');

        // Fetch data based on the selected dropdown value
        $data = ILSchedule::where('course', $course)->where('status', 'Ongoing')->get();

        return response()->json($data);
    }

    public function addIlSchedule(Request $request)
{
    if (session('role') !== 'admin') {
        return abort(403, 'Unauthorized access.');
    }

    $course = $request->input('course');
    
    // Predefined course abbreviations
    $courseMappings = [
        'Unity Game Development' => 'UD',
    ];

    // Check if the course has a predefined abbreviation, otherwise generate dynamically
    if (isset($courseMappings[$course])) {
        $firstLetters = $courseMappings[$course];
    } else {
        $words = explode(' ', $course);
        $firstLetters = '';

        foreach ($words as $word) {
            $firstLetters .= strtoupper(substr($word, 0, 1));
        }
    }

    $ilCode = ILSchedule::where('course', $course)->latest('id')->first();

    if ($ilCode) {
        $code = $ilCode->code; // Assuming code is in the format "CK-001"
        $lastDigits = (int) substr($code, -3); // Extract last three digits
        $newLastDigits = str_pad($lastDigits + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        $newCode = $firstLetters . '-' . $newLastDigits;
    } else {
        $newCode = $firstLetters . '-001';
    }

    $from = $request->input('from_a') . ':' . $request->input('from_b') . ' ' . $request->input('from_tm');
    $to = $request->input('to_a') . ':' . $request->input('to_b') . ' ' . $request->input('to_tm');

    $newSchedule = $request->validate([
        'course' => 'required',
        'teacher' => 'required',
        'day' => 'required',
    ]);

    $newSchedule['code'] = $newCode;
    $newSchedule['from'] = $from;
    $newSchedule['to'] = $to;
    $newSchedule['status'] = 'Ongoing';

    ILSchedule::create($newSchedule);

    return redirect(route('admin.il_schedule'));
}


    public function showClassSched($course)
{
    if (session('role') !== 'admin') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // OR
        return abort(403, 'Unauthorized access.');
    }

    // Retrieve courses matching the given course name
    $courses = Course::where('course_name', $course)
        ->where('status', 'Started')
        ->get(['day', 'time_slot', 'course_ID', 'teacher_id', 'course_name']);

    // Transform the data to include all required fields
    $schedules = $courses->map(function ($course) {
        return [
            'day' => $course->day,
            'time_slot' => $course->time_slot,
            'course_ID' => $course->course_ID,
            'teacher' => $course->teacher_id,
            'course_name' => $course->course_name
        ];
    });

    return response()->json($schedules);
}


    public function addToSched(Request $request)
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        // dd($request->all());

        // dd($time_slot);
        $studentNumber = $request->input('student_number');

        $data = [
            'student_number' => $request->input('student_number'),
            'student_name' => $request->input('student_name'),
            'classID' => $request->input('course_ID'),
        ];

        $notification = [
            'teacher' => $request->input('teacher_id'),
            'type' => 'New class student',
            'course' => $request->input('course_name'),
            'code' => $request->input('course_ID'),
            'date_time' => "{$request->input('day')} {$request->input('time')}",
            'student_name' => $request->input('student_name'),
            'status' => 'sent'
        ];

        Notification::create($notification);

        $create = EnrolledStudent::create($data);

        if($create){
            ILStudents::where('student_number', $studentNumber)->update(['status' => 'Enrolled']);
        } else {
            session()->flash('error', 'Failed to add student.');
        }

        return Redirect::back();
    }

    public function addToNewSched(Request $request)
    {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        // dd($request->all());

        // dd($time_slot);
        $student_ID = $request->input('student_ID');

        $data = [
            'student_number' => $request->input('student_number'),
            'student_name' => $request->input('student_name'),
            'classID' => $request->input('course_ID'),
        ];

        ILStudents::where('id', $student_ID)->update(['status' => 'Enrolled']);

        EnrolledStudent::create($data);

        return Redirect::back();
    }

    public function viewClassEnrollees($courseID) {
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }


        // get the course details
        $course_details = Course::where('course_ID', $courseID)
            ->first();

        // get the enrolled students name from a specific course
        $enrolled_students = EnrolledStudent::where('classID', $courseID)
            ->get();

        $student_details = []; // array for storing students name of a class

        // loop through all the students on  line 304
        foreach ($enrolled_students as $student) {
            $student_detail = ILStudents::where('student_name', $student->student_name)->first(); // fetch students detail from ILStudents Model
            if ($student_detail) {
                $student_details[] = $student_detail; // append to student_details array
            }
        }

        // return to admin_class_details with students and courses database query
        return view('Admin/admin_class_details', ['students' => $student_details, 'courses' => $course_details]);
    }

    public function courses(){
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $courses = Lessons::select('course')->distinct()->get();
        Log::info($courses);

        return view('Admin/admin_courses', ['courses' => $courses]);
    }
    
    public function TheCodingKnight(){
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        return view('Admin.subjects.coding_knight');
    }

    public function VisualProgramming(){
        if (session('role') !== 'admin') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        return view('Admin.subjects.visual_programming');
    }

    public function editStartDate($courseID, Request $request)
{
    if (session('role') !== 'admin') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // OR
        return abort(403, 'Unauthorized access.');
    }

    $course = Course::where('course_ID', $courseID)->first();

    $start_date = $request->input('start_date');
    $course->update(['start_date' => $start_date]);

    // Redirect back to the previous page
    return redirect()->back()->with('success', 'Start date updated successfully!');
}

public function studentsList()
{
    if (session('role') !== 'admin') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // OR
        return abort(403, 'Unauthorized access.');
    }

    $enrolledCount = ILStudents::where('status', 'Enrolled')->count();
    $courses = AvailableCourse::all();
    $students = EnrolledStudent::all()->map(function ($student) {
        $classPrefix = substr($student->classID, 0, 2); // Get first 2 letters of classID
    
        // Determine the course based on classPrefix
        $courseMapping = [
            'PS' => 'Python Start',
            'PP' => 'Python Pro',
            'VP' => 'Visual Programming',
            'CK' => 'Coding Knight',
            'DL' => 'Digital Literacy',
            'GD' => 'Game Design',
            'UD' => 'Unity Game Development',
            'CW' => 'Creating Websites',
            'FD' => 'Frontend Development'
        ];
    
        $course = $courseMapping[$classPrefix] ?? 'Unknown Course'; // Default if no match
    
        // Find matching student in ILStudents
        $ilStudent = ILStudents::where('student_name', $student->student_name)->where('status', 'Enrolled')->first();
    
        return $ilStudent ? (object) [
            'id'              => $student->id, // Ensure 'id' is included
            'student_number'    => $ilStudent->student_number,
            'student_name'    => $ilStudent->student_name,
            'course'          => $course,
            'age'             => $ilStudent->age,
            'contact_number'  => $ilStudent->contact_number,
            'email_address'   => $ilStudent->email_address,
            'status'          => $ilStudent->status,
            'created_at'      => $ilStudent->created_at
        ] : null; // Return null if no match
    })->filter()->take(8); // Remove null values and limit to 10 results
    $buttons = ceil($enrolledCount / 8); // Ensure it's rounded up to the nearest whole number

    return view('Admin.students_list', ['students' => $students, 'enrolledCount' => $enrolledCount, 'courses' => $courses]);
}

public function studentsPerCourse()
{
    $courseMapping = [
        'CK' => 'Coding Knight',
        'DL' => 'Digital Literacy',
        'VP' => 'Visual Programming',
        'GD' => 'Game Design',
        'GR' => 'Graphic Design',
        'CW' => 'Creating Websites',
        'UD' => 'Unity Game Development',
        'PS' => 'Python Start',
        'PP' => 'Python Pro',
    ];

    // Initialize all courses with a count of 0
    $courseCounts = collect($courseMapping)->map(fn($name) => ['course' => $name, 'count' => 0]);

    // Fetch all enrolled students and group them by course
    $enrolledCourses = EnrolledStudent::all()->groupBy(function ($student) use ($courseMapping) {
        $classPrefix = substr($student->classID, 0, 2); // Extract course prefix
        return $courseMapping[$classPrefix] ?? 'Unknown Course';
    })->map(function ($students, $course) {
        return ['course' => $course, 'count' => $students->count()];
    });

    // Merge the counts
    $courses = $courseCounts->map(function ($course) use ($enrolledCourses) {
        return [
            'course' => $course['course'],
            'count' => $enrolledCourses[$course['course']]['count'] ?? 0
        ];
    })
    // Filter out those with count = 0
    ->filter(fn($course) => $course['count'] > 0)
    ->values();

    return response()->json($courses);
}

public function studentsPerCourseFetch(Request $request)
{
    $year = $request->input('year');
    $month = $request->input('month');

    $courseMapping = [
        'CK' => 'Coding Knight',
        'DL' => 'Digital Literacy',
        'VP' => 'Visual Programming',
        'GD' => 'Game Design',
        'GD' => 'Graphic Design',
        'CW' => 'Creating Websites',
        'UD' => 'Unity Development',
        'PS' => 'Python Start',
        'PP' => 'Python Pro',
    ];

    // Initialize all courses with a count of 0
    $courseCounts = collect($courseMapping)->map(fn($name) => ['course' => $name, 'count' => 0]);

    // Fetch students filtered by year and month
    $enrolledCourses = EnrolledStudent::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->get()
        ->groupBy(fn($student) => $courseMapping[substr($student->classID, 0, 2)] ?? 'Unknown Course')
        ->map(fn($students, $course) => ['course' => $course, 'count' => $students->count()]);

    // Merge counts
    $courses = $courseCounts->map(fn($course) => [
        'course' => $course['course'],
        'count' => $enrolledCourses[$course['course']]['count'] ?? 0
    ])->values();

    return response()->json($courses);
}


public function teachersList()
{
    if (session('role') === 'staff') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // OR
        return abort(403, 'Unauthorized access.');
    }

    $teachers = Teacher::all();
    return view('Admin.teachers', ['teachers' => $teachers]);
}



public function paginate($page)
{
    $perPage = 8;
    $fetch = $page * $perPage;
    $offset = ($fetch - $perPage); // Start from ($fetch - $perPage)

    $enrolledCount = ILStudents::where('status', 'Enrolled')->count();

    // Fetch only students that exist in ILStudents and are "Enrolled"
    $students = EnrolledStudent::join('il_students', 'enrolled_students.student_name', '=', 'il_students.student_name')
        ->where('il_students.status', 'Enrolled')
        ->offset($offset)
        ->limit($perPage)
        ->get()
        ->map(function ($student) {
            $classPrefix = substr($student->classID, 0, 2); // Get first 2 letters of classID

            // Determine the course based on classPrefix
            $courseMapping = [
                'PS' => 'Python Start',
                'PP' => 'Python Pro',
                'VP' => 'Visual Programming',
                'CK' => 'Coding Knight',
            ];

            $course = $courseMapping[$classPrefix] ?? 'Unknown Course'; // Default if no match

            return [
                'id'              => $student->id,
                'student_name'    => $student->student_name,
                'course'          => $course,
                'age'             => $student->age,
                'contact_number'  => $student->contact_number,
                'email_address'   => $student->email_address,
                'status'          => $student->status
            ];
        });

    return response()->json([
        'students' => $students,
        'total' => $enrolledCount,
        'page' => $page,
        'perPage' => $perPage,
        'fetch' => $fetch,
        'offset' => $offset
    ]);
}

public function paginateExpelled($page)
{
    $perPage = 8;
    $fetch = $page * $perPage;
    $offset = ($fetch - $perPage); // Start from ($fetch - $perPage)

    Log::info('Pagination Details:', [
        'page' => $page,
        'fetch' => $fetch,
        'offset' => $offset,
    ]);
    

    $expelledCount = ExpelledStudent::all()->count();

    // Fetch only students that exist in ILStudents and are "Enrolled"
    $students = ExpelledStudent::whereIn('student_name', ILStudents::pluck('student_name'))
    ->offset($offset)
    ->limit($perPage)
    ->get();

    $students->transform(function ($student) {
        $ilStudent = ILStudents::where('student_name', $student->student_name)->first(); 
        $student->il_data = $ilStudent ?? null; // Attach ILStudent data (or null if not found)
        return $student;
    });


    return response()->json([
        'students' => $students,
        'total' => $expelledCount,
        'page' => $page,
        'perPage' => $perPage,
        'fetch' => $fetch,
        'offset' => $offset
    ]);
}


public function paginateWalkIn($page)
{
    $perPage = 8;
    $fetch = $page * $perPage;
    $offset = ($fetch - $perPage); // Start from ($fetch - $perPage)

    $enrolledCount = SchedulesList::count();

    // Fetch only the required students for pagination
    $students = SchedulesList::where('status', 'Pending')
    ->skip($offset)
    ->take($perPage)
    ->get();


    return response()->json([
        'students' => $students->values(),
        'total' => $enrolledCount,
        'page' => $page,
        'perPage' => $perPage,
        'fetch' => $fetch,
        'offset' => $offset
    ]);
}

public function expelStudent($id, $studentName, $course)
{
    if (session('role') !== 'admin') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // OR
        return abort(403, 'Unauthorized access.');
    }

    try {
        Log::info("Expelling student: $studentName, Course: $course");


        // Find student and update status
        $student = EnrolledStudent::where('id', $id)->first();
        $studentIL = ILStudents::where('student_name', $studentName)->first();

        
        if ($student) {
            $studentIL->update(['status' => 'Expelled']);
            // Save expelled student data
            $data = [
                'student_number' => $student->student_number,
                'student_name' => $studentName,
                'course' => $course,
            ];
            ExpelledStudent::create($data);
            Log::info("Added student to ExpelledStudent table", $data);
            $studentIL->save();
            $student->delete();
            Log::info("Student delete succesfully for $studentName");
        } else {
            Log::warning("Student not found: $studentName");
            return redirect()->route('admin.students')->with('error', 'Student not found.');
        }

        Log::info("Student expelled successfully: $studentName");
        return redirect()->route('admin.students')->with('success', 'Student expelled successfully.');
    } catch (\Exception $e) {
        Log::error("Error expelling student: " . $e->getMessage());
        return redirect()->route('admin.students')->with('error', 'An error occurred while expelling the student.');
    }
}

public function expelledList()
{
    if (session('role') !== 'admin') {
        return abort(403, 'Unauthorized access.');
    }

    $expelledCount = ExpelledStudent::count();
    $courses = AvailableCourse::all();
    $students = ExpelledStudent::take(8)->get();

    Log::info('Expelled Students:', $students->toArray()); // Debug expelled students

    if ($students->isNotEmpty()) {
        $students->transform(function ($student) {
            $ilStudent = ILStudents::where('student_name', $student->student_name)->first();
        
            if (!$ilStudent) {
                Log::warning("No matching IL Student found for: {$student->student_name}");
            }
        
            $student->il_data = $ilStudent; // Attach ILStudent data (or null if not found)
            return $student;
        });
        
    }

    return view('Admin.admin_expelled', [
        'students' => $students,
        'enrolledCount' => $expelledCount,
        'courses' => $courses
    ]);
}

public function archivedList()
{
    if (session('role') !== 'admin') {
        return abort(403, 'Unauthorized access.');
    }

    $archived = ILStudents::whereIn('status', ['Did not attend', 'Archived', 'Expelled'])->get();
    $archivedCount = $archived->count();

    return view('Admin.admin_archived', [
        'students' => $archived,
        'archivedCount' => $archivedCount,
    ]);
}

public function deleteILSchedule(Request $request)
{
    $courseID = $request->input('courseID');

    if (!$courseID) {
        return response()->json(['error' => 'Invalid course ID'], 400);
    }

    // Find the IL schedule
    $schedule = ILSchedule::where('code', $courseID)->first();

    if ($schedule) {
        $schedule->update(['status' => 'Stopped']); // Update status to 'Stopped'

        return response()->json(['success' => 'Schedule status updated to Stopped']);
    }

    return response()->json(['error' => 'Schedule not found'], 404);
}

public function updateToArchive(Request $request, $name)
{
    $student = ILStudents::where('student_name', $name)->first();

    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    $student->update(['status' => 'Archived']); // Update status to 'Archived'

    return response()->json(['message' => 'Student status updated to Archived']);
}


public function uploadCSV(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:csv,txt|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'Invalid file format or size'], 422);
    }

    $file = $request->file('file');
    $handle = fopen($file, "r");

    $firstCourse = null; // Store the first course

    if ($handle !== FALSE) {
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (empty(array_filter($data))) { // Skip empty rows
                continue;
            }

            if ($firstCourse === null) {
                $firstCourse = $data[0] ?? null;
            }

            Lessons::create([
                'course' => $data[0] ?? '',
                'year' => $data[1] ?? '',
                'topic' => $data[2] ?? '',
                'code' => $data[3] ?? '',
                'lesson' => $data[4] ?? '',
                'description' => $data[5] ?? '',
            ]);
        }

        fclose($handle);
    }

    if ($firstCourse) {
        AvailableCourse::firstOrCreate(['course_name' => $firstCourse]);
    }

    return response()->json(['message' => 'CSV Uploaded Successfully']);
}

public function passwordReset(){
    return view('password_reset');
}

public function checkUsername(Request $request)
    {
        $username = $request->input('username');

        // Search for the username in the Teacher model
        $teacher = Teacher::where('username', $username)->first();

        if ($teacher) {
            // If the teacher is found, return the teacher's data
            return response()->json([
                'found' => true,
                'teacher' => $teacher
            ]);
        } else {
            // If no teacher is found, return an appropriate response
            return response()->json([
                'found' => false
            ]);
        }
    }

public function checkAdminUsername(Request $request)
    {
        $username = $request->input('username');

        // Search for the username in the Teacher model
        $admin = Admin::where('name', $username)->first();

        if ($admin) {
            // If the teacher is found, return the teacher's data
            return response()->json([
                'found' => true,
                'admin' => $admin
            ]);
        } else {
            // If no teacher is found, return an appropriate response
            return response()->json([
                'found' => false
            ]);
        }
    }

    public function sendResetEmail(Request $request)
    {
        $email = $request->input('email');
        try {
            $mailService = new MailService();
            $resetLink = url("/reset-password/" . urlencode($email)); // Generates a proper URL
            
            $emailBody = "
                <html>
                    <head>
                        <title>Password Reset</title>
                    </head>
                    <body>
                        <div style='width: 400px; padding: 10px;'>
                            <div style='width: 100%; padding-top: 2rem; display: flex; justify-content: center; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;'>
                                <p style='font-size: 1.125rem; color: #632c7d'>Algorithmics Nuvali</p>
                            </div>
                            <h1 style='color: #333333;'>Password Reset</h1>
                            <p>Open this link to proceed with updating your password:</p>
                            <a href='{$resetLink}' style='color: #007bff; text-decoration: none;'>{$resetLink}</a>
                            <p>If you did not request this update, please ignore this email.</p>
                            <p>Thank you!</p>
                        </div>
                    </body>
                </html>";
    
            $result = $mailService->sendMail($email, "Password Reset", $emailBody);
    
            if ($result) {
                Log::info(['password sent to' => $email]);
                return response()->json(['success' => 'Reset link sent successfully!']);
            } else {
                return response()->json(['error' => 'Failed to send email.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function reset($email){
        $decodedEmail = urldecode($email); // Decode the email
        return view('password_update', ['email' => $decodedEmail]);
    }

    public function passwordUpdate(Request $request)
{
    // Find teacher by email
    $teacher = Teacher::where('email_address', $request->input('email'))->first();

    if (!$teacher) {
        return back()->withErrors(['email' => 'Invalid email address.']);
    }

    // Update password
    $teacher->update([
        'password' => Hash::make($request->input('password')),
    ]);

    return redirect()->route('welcome')->with('success', 'Password updated successfully!');
}

public function loginPage(){
    if (session('teacher_logged_in')) {
        return redirect()->route('teacher.dashboard'); // Assuming teacher.dashboard is the route to the dashboard
    }
    return view('welcome');

}

public function resetAdminPassword(Request $request)
{
    // Find teacher by email
    $teacher = Admin::where('name', $request->input('name'))->first();

    if (!$teacher) {
        return back()->withErrors(['email' => 'Invalid email address.']);
    }

    // Update password
    $teacher->update([
        'password' => Hash::make($request->input('password')),
    ]);

    return redirect()->route('admin.login')->with('success', 'Password updated successfully!');
}

public function getInquiredSched(Request $request){
    Log::info($request);
}

public function passwordSetup($email){
    $decodedEmail = urldecode($email); // Decode the email
    $username = Teacher::where('email_address', $decodedEmail)->value('username');
    return view('password_setup', ['email' => $decodedEmail, 'username' => $username]);
}

public function setPassword(Request $request)
{
    // Validate the input
    $request->validate([
        'password' => 'required|min:6',  // Ensure password is at least 6 characters
        'email_address' => 'required|email|exists:teachers,email_address', // Ensure email exists in teachers table
    ]);

    // Update the password (hashed for security)
    $updated = Teacher::where('email_address', $request->input('email_address'))
        ->update(['password' => Hash::make($request->input('password'))]);

    // Check if update was successful
    if ($updated) {
        return redirect()->route('welcome')->with('success', 'Password updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update password.');
    }
}


}
