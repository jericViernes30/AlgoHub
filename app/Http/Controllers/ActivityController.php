<?php

namespace App\Http\Controllers;

use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use App\Models\SchedulesList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    public function admin_login()
    {
        return view('Admin/admin_login');
    }

    public function admin_dashboard()
    {
        $schedule = Course::all();
        return view('Admin/admin_dashboard', ['schedule' => $schedule]);
    }

    public function admin_schedule()
    {
        $schedule = Course::all();
        $courses = AvailableCourse::all();
        return view('Admin/admin_schedule', ['schedule' => $schedule, 'courses' => $courses]);
    }

    public function il_schedule()
    {
        $sched = ILSchedule::all();

        $courses = AvailableCourse::all();
        $sched->transform(function ($time) {
            $time_slot = "{$time->from} to {$time->to}";
            $time->time_slot = $time_slot;

            return $time;
        });

        return view('Admin/il_schedule', ['schedule' => $sched], ['courses' => $courses]);
    }

    // public function il_schedule(){
    //     $sched = ILSchedule::all();
    //     $il_schedule = ILSchedule::where('code', 'IL-4305')->with('il_students')->first();

    //     // Access the related students
    //     $students = $il_schedule->il_students;

    //     return view('Admin/il_schedule', ['classes' => $students, 'schedule' => $sched]);
    // }

    public function teacher_login()
    {
        return view('welcome');
    }

    public function for_scheduling()
    {
        $course = AvailableCourse::all();
        $scheduling = SchedulesList::all();
        return view('Admin/for_scheduling', ['scheduling' => $scheduling, 'course' => $course]);
    }

    public function add_client(Request $request)
    {
        $data = $request->validate([
            'parents_name' => 'required',
            'childs_name' => 'required',
            'age' => 'required',
            'contact_number' => 'required',
            'email_address' => 'required',
            'status' => 'nullable',
        ]);

        $data['status'] = $request->input('status', 'Pending');

        SchedulesList::create($data);

        return redirect()->route('admin.schedule.for_scheduling');
    }

    public function update_client(Request $request)
    {
        $client = SchedulesList::where('parents_name', $request->input('parents_name'))->first();
        if ($client) {
            $client->update([
                'childs_name' => $request->input('childs_name'),
                'age' => $request->input('age'),
                'contact_number' => $request->input('contact_number'),
                'email_address' => $request->input('email_address'),
                'status' => $request->input('status'),
            ]);

            // Optionally, you can return a response indicating success
            return redirect()->back()->with('success', 'Client updated successfully');
        } else {
            // Optionally, handle the case where the client is not found
            return redirect()->back()->with('error', 'Client not found');
        }
    }

    public function delete_client($parent_name)
    {
        // Delete the data
        SchedulesList::where('parents_name', $parent_name)->delete();

        // Redirect back to the current page
        return redirect()->route('admin.schedule.for_scheduling');
    }

    public function getSchedules($course)
    {
        $schedules = ILSchedule::where('course', $course)->get(['code', 'to', 'from', 'day', 'mm', 'dd']);

        // Create a new variable $time_slot to store formatted 'from' and 'to' times
        $schedules->transform(function ($schedule) {
            // Format 'from' and 'to' times as "12:30 PM" and "1:30 PM" (assuming they are already in the correct format)
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

        return redirect()->route('admin.schedule.for_scheduling');
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
            'mm' => 'required',
            'dd' => 'required',
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
        $courses = Course::where('course_name', $course)->get(['day', 'time_slot']);

        $plucked_schedules = $courses->pluck('day', 'time_slot');

        return response()->json($plucked_schedules);
    }

    public function addToSched(Request $request)
    {

        $time_slot = Course::where('course_name', $request->input('course_name'))
            ->where('day', $request->input('day'))
            ->value('time_slot');
        // dd($time_slot);
        $data = $request->validate([
            'student_name' => 'required',
            'course_name' => 'required',
            'day' => 'required',
            'time_slot' => 'nullable',
            'enrollment_date' => 'nullable'
        ]);

        $data['time_slot'] = $time_slot;

        EnrolledStudent::create($data);

        return Redirect::back();
    }

    public function viewClassEnrollees($day, $time_slot, $course) {
        // get the course details
        $course_details = Course::where('day', $day)
            ->where('time_slot', $time_slot)
            ->where('course_name', $course)
            ->first();

        // get the enrolled students name from a specific course
        $enrolled_students = EnrolledStudent::where('day', $day)
            ->where('time_slot', $time_slot)
            ->where('course_name', $course)
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

    public function teacherDashboard(){
        return view('Teacher/dashboard');
    }

    public function classDetail(){
        return view('Teacher/il_details');
    }


}
