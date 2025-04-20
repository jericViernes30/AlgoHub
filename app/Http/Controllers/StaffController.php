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
use App\Models\SchedulesList;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function staff_dashboard()
    {
        if (session('role') !== 'staff') {
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
        return view('Staff/staff_dashboard', [
            'schedule' => $schedule,
            'enrolled_count' => $enrolled,
            'walkin_count' => $walkIn,
            'il_count' => $il,
            'courseCounts' => $courseCounts,
        ]);
    }

    public function courses(){
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }
        $courses = Lessons::select('course')->distinct()->get();
        return view('Staff/staff_courses', ['courses' => $courses]);
    }

    public function studentsList()
    {
        if (session('role') !== 'staff') {
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

        return view('Staff.students_list', ['students' => $students, 'enrolledCount' => $enrolledCount, 'courses' => $courses]);
    }

    public function expelledList()
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $enrolledCount = ILStudents::where('status', 'Expelled')->count();
        $courses = AvailableCourse::all();
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
            $ilStudent = ILStudents::where('student_name', $student->student_name)->where('status', 'Expelled')->first();
        
            return $ilStudent ? (object) [
                'id'              => $student->id, // Ensure 'id' is included
                'student_name'    => $ilStudent->student_name,
                'course'          => $course,
                'age'             => $ilStudent->age,
                'contact_number'  => $ilStudent->contact_number,
                'email_address'   => $ilStudent->email_address,
                'status'          => $ilStudent->status,
                'updated_at'      => $ilStudent->updated_at  
            ] : null; // Return null if no match
        })->filter()->take(8); // Remove null values and limit to 10 results
        $buttons = ceil($enrolledCount / 8); // Ensure it's rounded up to the nearest whole number

        return view('Staff.expelled', ['students' => $students, 'enrolledCount' => $enrolledCount, 'courses' => $courses]);
    }

    public function staff_schedule()
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $schedule = Course::where('status', 'Started')->get();
        $courses = AvailableCourse::all();
        $teachers = Teacher::all();
        return view('Staff/staff_schedule', ['schedule' => $schedule, 'courses' => $courses, 'teachers' => $teachers]);
    }

    public function viewClassEnrollees($courseID) {
        if (session('role') !== 'staff') {
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
        return view('Staff/class_details', ['students' => $student_details, 'courses' => $course_details]);
    }

    public function il_schedule()
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $sched = ILSchedule::where('status', 'Ongoing')->get();
        $teachers = Teacher::all();
        $courses = AvailableCourse::all();
        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        return view('Staff/il_schedule', ['schedule' => $sched, 'courses' => $courses, 'teachers' => $teachers]);
    }

    public function walkInClients()
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $course = AvailableCourse::all();
        $scheduling = SchedulesList::where('status', 'Pending')->take(8)->get();
        $scheduledCount = SchedulesList::where('status', 'Pending')->count();
        return view('Staff/walk_in', ['scheduling' => $scheduling, 'course' => $course, 'scheduled' => $scheduledCount]);
    }

    public function proceedToIl(Request $request)
    {
        Log::info($request);
if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

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

        return redirect()->route('staff.walk_in')->with('success', 'Status updated succesfully.');
    }

    public function openIl($code)
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        $courses = AvailableCourse::all();
        $sched = ILSchedule::all();
        $il_schedule = ILSchedule::where('code', $code)
    ->with('il_students')
    ->first();

if (!$il_schedule) {
    return abort(404, 'Schedule not found.');
}

// Access the related students
$students = $il_schedule->il_students;


        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        // Filter students where status is NOT 'Did not attend' and NOT 'Enrolled'
    $students = $il_schedule->il_students->reject(function ($student) {
        return in_array($student->status, ['Did not attend', 'Enrolled', 'Archived', 'Expelled']);
    });

        return view('Staff/il_details', [
            'il_schedule' => $il_schedule,
            'students' => $students,
            'sched' => $sched,
            'courses' => $courses,
        ]);
    }


    public function delete_client($id)
    {
        if (session('role') !== 'staff') {
            // return redirect()->back()->with('error', 'Unauthorized access.');
            // OR
            return abort(403, 'Unauthorized access.');
        }

        // Delete the data
        SchedulesList::where('id', $id)->delete();

        // Redirect back to the current page
        return redirect()->route('staff.walk_in')->with('success', 'Client deleted succesfully.');
    }
}
