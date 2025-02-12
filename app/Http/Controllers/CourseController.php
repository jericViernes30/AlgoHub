<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
    $courseInitials = collect(explode(' ', $courseName))
        ->map(fn($word) => strtoupper($word[0]))
        ->join('');

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


}
