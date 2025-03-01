<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ExpelledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use App\Models\SchedulesList;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

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

        $admin = Admin::where('name', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Save the admin ID in the session
            session(['admin_id' => $admin->id]);

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }

        // Return a response for invalid login
        return response()->json([
            'message' => 'Invalid username or password',
        ], 401);
    }

    public function logoutAdmin(Request $request){
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function admin_dashboard()
    {
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
        $password = 'Admin001';
        $hashedPassword = Hash::make($password);

        $data = [
            'name' => 'Admin',
            'password' => $hashedPassword
        ];

        $create = Admin::create($data);
        if($create){
            return view('Admin.admin_login');
        }
    }

    public function admin_schedule()
    {
        $schedule = Course::all();
        $courses = AvailableCourse::all();
        $teachers = Teacher::all();
        return view('Admin/admin_schedule', ['schedule' => $schedule, 'courses' => $courses, 'teachers' => $teachers]);
    }

    public function il_schedule()
    {
        $sched = ILSchedule::all();
        $teachers = Teacher::all();
        $courses = AvailableCourse::all();
        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        return view('Admin/il_schedule', ['schedule' => $sched, 'courses' => $courses, 'teachers' => $teachers]);
    }

    // public function il_schedule(){
    //     $sched = ILSchedule::all();
    //     $il_schedule = ILSchedule::where('code', 'IL-4305')->with('il_students')->first();

    //     // Access the related students
    //     $students = $il_schedule->il_students;

    //     return view('Admin/il_schedule', ['classes' => $students, 'schedule' => $sched]);
    // }

    public function for_scheduling()
    {
        $course = AvailableCourse::all();
        $scheduling = SchedulesList::take(8)->get();
        $scheduledCount = SchedulesList::all()->count();
        return view('Admin/for_scheduling', ['scheduling' => $scheduling, 'course' => $course, 'scheduled' => $scheduledCount]);
    }

    public function add_client(Request $request)
    {
        // Check if child's name already exists
        if (SchedulesList::where('childs_name', $request->input('childs_name'))->exists()) {
            return redirect()->back()->with('addClientError', 'Child name already exists. Please enter a unique name.');
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
        // Delete the data
        SchedulesList::where('id', $id)->delete();

        // Redirect back to the current page
        return redirect()->route('admin.schedule.for_scheduling')->with('success', 'Client deleted succesfully.');
    }

    public function getSchedules($course)
    {
        $schedules = ILSchedule::where('course', $course)->get();

        $schedules->transform(function ($schedule) {
            $time_slot = "{$schedule->from} to {$schedule->to} | {$schedule->mm} {$schedule->dd} - {$schedule->day}";
            $schedule->time_slot = $time_slot;

            return $schedule;
        });

        // Pluck the transformed data to get the desired format
        $plucked_schedules = $schedules->pluck('code', 'time_slot');

        return response()->json($plucked_schedules);
    }

    public function proceedToIl(Request $request)
    {

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

        $student['status'] = $request->input('status', 'Pending');
        $childsName = $request->input('childs_name');

        // Find the schedule by childs_name
        $studentStatus = SchedulesList::where('childs_name', $request->input('student_name'))->first();

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
        $courses = AvailableCourse::all();
        $sched = ILSchedule::all();
        $il_schedule = ILSchedule::where('code', $code)->with('il_students')->first();

        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        // Access the related students
        $students = $il_schedule->il_students;

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
        $data = ILSchedule::where('course', $course)->get();

        return response()->json($data);
    }

    public function addIlSchedule(Request $request)
    {
        $ilCode = ILSchedule::where('course', $request->input('course'))->latest('id')->first();
        $course = $request->input('course');
        $words = explode(' ', $course); // Split the string into words
        $firstLetters = '';

        foreach ($words as $word) {
            $firstLetters .= strtoupper(substr($word, 0, 1)); // Get the first letter of each word and convert it to uppercase
        }

        echo $firstLetters; // Output the first letters of each word

        if ($ilCode) {
            $code = $ilCode->code; // Assuming code is in the format "CK-001"
            $lastDigit = (int) substr($code, -1); // Extract the last digit as an integer
            $newLastDigit = $lastDigit + 1; // Add 1 to the last digit
            $newCode = substr($code, 0, -1) . $newLastDigit; // Replace the last digit with the new one
            $newSchedule['code'] = $newCode;
        } else {
            // Handle case where no matching record is found
            echo "No matching record found for the given course.";
        }
        $from = $request->input('from_a') . ':' . $request->input('from_b') . ' ' . $request->input('from_tm');
        $to = $request->input('to_a') . ':' . $request->input('to_b') . ' ' . $request->input('to_tm');

        $newSchedule = $request->validate([
            'code' => 'nullable',
            'course' => 'required',
            'teacher' => 'required',
            'day' => 'required',
            'from' => 'nullable',
            'to' => 'nullable',
        ]);

        if ($ilCode) {
            $code = $ilCode->code; // Assuming code is in the format "CK-001"
            $lastDigit = (int) substr($code, -1); // Extract the last digit as an integer
            $newLastDigit = $lastDigit + 1; // Add 1 to the last digit
            $newCode = substr($code, 0, -1) . $newLastDigit; // Replace the last digit with the new one
            $newSchedule['code'] = $newCode;
        } else {
            // Handle case where no matching record is found
            echo "No matching record found for the given course.";
            $newSchedule['code'] = $firstLetters . '-001';
        }
        $newSchedule['from'] = $from;
        $newSchedule['to'] = $to;

        ILSchedule::create($newSchedule);

        return redirect(route('admin.il_schedule'));
    }

    public function showClassSched($course)
{
    // Retrieve courses matching the given course name
    $courses = Course::where('course_name', $course)->get(['day', 'time_slot', 'course_ID']);

    // Transform the data to include all required fields
    $schedules = $courses->map(function ($course) {
        return [
            'day' => $course->day,
            'time_slot' => $course->time_slot,
            'course_ID' => $course->course_ID,
        ];
    });

    return response()->json($schedules);
}


    public function addToSched(Request $request)
    {
        // dd($request->all());

        // dd($time_slot);
        $student_ID = $request->input('student_ID');

        $data = [
            'student_name' => $request->input('student_name'),
            'classID' => $request->input('course_ID'),
        ];

        ILStudents::where('id', $student_ID)->update(['status' => 'Enrolled']);

        EnrolledStudent::create($data);

        return Redirect::back();
    }

    public function viewClassEnrollees($courseID) {
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
        return view('Admin/admin_courses');
    }
    
    public function TheCodingKnight(){
        return view('Admin.subjects.coding_knight');
    }

    public function VisualProgramming(){
        return view('Admin.subjects.visual_programming');
    }

    public function editStartDate($courseID, Request $request)
{
    $course = Course::where('course_ID', $courseID)->first();

    $start_date = $request->input('start_date');
    $course->update(['start_date' => $start_date]);

    // Redirect back to the previous page
    return redirect()->back()->with('success', 'Start date updated successfully!');
}

public function studentsList()
{
    $enrolledCount = EnrolledStudent::all()->count();
    $students = EnrolledStudent::all()->map(function ($student) {
        $classPrefix = substr($student->classID, 0, 2); // Get first 2 letters of classID
    
        // Determine the course based on classPrefix
        $courseMapping = [
            'PS' => 'Python Start',
            'PP' => 'Python Pro',
            'VP' => 'Visual Programming',
            'CK' => 'Coding Knight',
        ];
    
        $course = $courseMapping[$classPrefix] ?? 'Unknown Course'; // Default if no match
    
        // Find matching student in ILStudents
        $ilStudent = ILStudents::where('student_name', $student->student_name)->first();
    
        return $ilStudent ? (object) [
            'id'              => $student->id, // Ensure 'id' is included
            'student_name'    => $ilStudent->student_name,
            'course'          => $course,
            'age'             => $ilStudent->age,
            'contact_number'  => $ilStudent->contact_number,
            'email_address'   => $ilStudent->email_address,
            'status'          => $ilStudent->status
        ] : null; // Return null if no match
    })->filter()->take(8); // Remove null values and limit to 10 results
    $buttons = ceil($enrolledCount / 8); // Ensure it's rounded up to the nearest whole number

    return view('Admin.students_list', ['students' => $students, 'enrolledCount' => $enrolledCount]);
}

public function studentsPerCourse()
{
    $courseMapping = [
        'PS' => 'Python Start',
        'PP' => 'Python Pro',
        'CK' => 'Coding Knight',
        'UD' => 'Unity Development',
        'VP' => 'Visual Programming',
        'DL' => 'Digital Literacy',
        'GD' => 'Game Design',
        'FD' => 'Frontend Development',
        'CW' => 'Creating Websites'
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

    // Merge the counts, keeping zeros where there are no students
    $courses = $courseCounts->map(function ($course) use ($enrolledCourses) {
        return [
            'course' => $course['course'],
            'count' => $enrolledCourses[$course['course']]['count'] ?? 0
        ];
    })->values();

    return response()->json($courses);
}

public function teachersList(){
    $teachers = Teacher::all();

    return view('Admin.teachers', ['teachers' => $teachers]);
}


public function paginate($page)
{
    $perPage = 8;
    $fetch = $page * $perPage;
    $offset = ($fetch - $perPage); // Start from ($fetch - $perPage)

    $enrolledCount = ILSchedule::count();

    // Fetch only the required students for pagination
    $students = EnrolledStudent::skip($offset)->take($perPage)->get()->map(function ($student) {
        $classPrefix = substr($student->classID, 0, 2); // Get first 2 letters of classID

        // Determine the course based on classPrefix
        $courseMapping = [
            'PS' => 'Python Start',
            'PP' => 'Python Pro',
            'VP' => 'Visual Programming',
            'CK' => 'Coding Knight',
        ];

        $course = $courseMapping[$classPrefix] ?? 'Unknown Course'; // Default if no match

        // Find matching student in ILStudents
        $ilStudent = ILStudents::where('student_name', $student->student_name)->first();

        return $ilStudent ? (object) [
            'id'              => $student->id,
            'student_name'    => $ilStudent->student_name,
            'course'          => $course,
            'age'             => $ilStudent->age,
            'contact_number'  => $ilStudent->contact_number,
            'email_address'   => $ilStudent->email_address,
            'status'          => $ilStudent->status
        ] : null;
    })->filter(); // Remove null values

    return response()->json([
        'students' => $students->values(),
        'total' => $enrolledCount,
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
    $students = SchedulesList::skip($offset)->take($perPage)->get();

    return response()->json([
        'students' => $students->values(),
        'total' => $enrolledCount,
        'page' => $page,
        'perPage' => $perPage,
        'fetch' => $fetch,
        'offset' => $offset
    ]);
}

public function expelStudent($studentName, $course){
    $data = [
        'student_name' => $studentName,
        'course' => $course,
    ];

    ExpelledStudent::create($data);
    $student = ILStudents::where('student_name', $studentName)->first();
    $student->status = 'Expelled';
    $student->save();

    return redirect()->route('admin.students')->with('success', 'Student expelled successfully.');
}






    


}
