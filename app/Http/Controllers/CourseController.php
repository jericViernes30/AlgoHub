<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lessons;
use App\Models\SchedulesList;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function add_class(Request $request)
{
    $selectedOption = $request->input('teacher');
    [$teacherId, $firstName] = explode('|', $selectedOption);

    // Extract initials of the course name
    $courseName = $request->input('course_name');
    if ($courseName === 'Unity Game Development') {
        $courseInitials = 'UD'; // Special case
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
    ];

    // Save the course to the database
    Course::create($data);

    return redirect()->route('admin.schedule');
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
