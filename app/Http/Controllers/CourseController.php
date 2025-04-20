<?php

namespace App\Http\Controllers;

use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\Lessons;
use App\Models\Notification;
use App\Models\SchedulesList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function add_class(Request $request)
{
    // Check if the requested day and time_slot already exist
    $existingCourse = Course::where('day', $request->input('day'))
        ->where('time_slot', $request->input('time_slot'))
        ->where('status', 'Started')
        ->exists();

    if ($existingCourse) {
        return redirect()->route('admin.schedule')->with('error', 'A course is already scheduled for this day and time slot.');
    }

    $selectedOption = $request->input('teacher');
    [$teacherId, $firstName] = explode('|', $selectedOption);

    // Extract initials of the course name
    $courseName = $request->input('course_name');
    if ($courseName === 'Unity Game Development') {
        $courseInitials = 'UD'; // Special case
    } elseif ($courseName === 'Graphic Design') {
        $courseInitials = 'GR'; // Special case
    } else {
        // General logic for extracting initials
        $courseInitials = collect(explode(' ', $courseName))
            ->map(fn($word) => strtoupper($word[0]))
            ->join('');
    }
    

    // Count occurrences of the course name in the database and increment by 1
    $existingCount = Course::where('course_name', $courseName)->count() + 1;
    $courseCount = str_pad($existingCount, 3, '0', STR_PAD_LEFT);

    // Map time slot to the corresponding letter
    $timeSlotMap = [
        'first' => 'A',
        'second' => 'B',
        'third' => 'C',
        'fourth' => 'D',
        'fifth' => 'E',
    ];
    $timeSlot = $timeSlotMap[$request->input('time_slot')] ?? '';

    // Combine all parts to create the course ID
    $courseID = "{$courseInitials}-{$courseCount}{$timeSlot}";

    // Prepare the data for insertion
    $data = [
        'course_ID' => $courseID,
        'course_name' => $courseName,
        'teacher' => $firstName,
        'teacher_id' => $teacherId,
        'day' => $request->input('day'),
        'time_slot' => $request->input('time_slot'),
        'status' => 'Started'
    ];

    $notif = [
        'teacher' => $teacherId,
        'type' => 'New Class',
        'course' => $courseName,
        'code' => $courseID,
        'date_time' => $request->input('day'),
        'student_name' => 'N/A',
        'status' => 'sent'
    ];

    Notification::create($notif);

    // Save the course to the database
    Course::create($data);

    return redirect()->route('admin.schedule')->with('success', 'Course successfully added.');
}

public function deleteClassSchedule(Request $request)
{
    $courseID = $request->input('courseID');
    Log::info($courseID);
    // Find the course schedule
    $schedule = Course::where('course_ID', $courseID)->first();
    
    if ($schedule) {
        $schedule->update(['status' => 'Removed']); // Update status to 'Removed'

        return response()->json(['success' => true, 'message' => 'Schedule marked as Removed.']);
    }

    return response()->json(['success' => false, 'message' => 'Schedule not found.'], 404);
}

public function courseDetails($course)
{
    $lessons = Lessons::where('course', $course)->where('year', 1)->get();
    $lessonCount = $lessons->count();
    return view('Admin.subjects.course', ['lessons' => $lessons, 'course' => $course, 'lessonCount' => $lessonCount]);
}

public function deleteCourse($course){
    $lessons = Lessons::where('course', $course)->get();
    foreach($lessons as $lesson){
        $lesson->delete();
    }
    Course::where('course_name', $course)->delete();
    AvailableCourse::where('course_name', $course)->delete();
    return redirect()->route('admin.courses')->with('success', 'Course successfully deleted.');
}

public function codingKnight(){
    $lessons = Lessons::where('course', 'The Coding Knight')->get();
    return view('Admin.subjects.coding_knight', ['lessons' => $lessons]);
}
public function visualProgramming(){
    $lessons = Lessons::where('course', 'Visual Programming')->get();
    return view('Admin.subjects.visual_programming', ['lessons' => $lessons]);
}
public function pythonStart1(){
    $lessons = Lessons::where('course', 'Python Start')->where('year', 1)->get();
    return view('Admin.subjects.python_start1', ['lessons' => $lessons]);
}
public function pythonStart2(){
    $lessons = Lessons::where('course', 'Python Start')->where('year', 2)->get();
    return view('Admin.subjects.python_start2', ['lessons' => $lessons]);
}
public function pythonPro1(){
    $lessons = Lessons::where('course', 'Python Pro')->where('year', 1)->get();
    return view('Admin.subjects.python_pro1', ['lessons' => $lessons]);
}
public function pythonPro2(){
    $lessons = Lessons::where('course', 'Python Pro')->where('year', 2)->get();
    return view('Admin.subjects.python_pro2', ['lessons' => $lessons]);
}
public function buildingWebsites(){
    $lessons = Lessons::where('course', 'Building Websites')->get();
    return view('Admin.subjects.building_websites', ['lessons' => $lessons]);
}
public function gameDesign(){
    $lessons = Lessons::where('course', 'Game Design')->get();
    return view('Admin.subjects.game_design', ['lessons' => $lessons]);
}
public function digitalLiteracy(){
    $lessons = Lessons::where('course', 'Digital Literacy')->get();
    return view('Admin.subjects.digital_literacy', ['lessons' => $lessons]);
}



}
