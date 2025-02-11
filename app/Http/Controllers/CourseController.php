<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SchedulesList;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function add_class(Request $request){

        $selectedOption = $request->input('teacher');
        [$teacherId, $firstName] = explode('|', $selectedOption);

        // $data = $request->validate([
        //     'course_name' => 'required',
        //     'teacher' => 'required|string',
        //     'teacher_id' => 'required',
        //     'day' => 'required',
        //     'time_slot' => 'required'
        // ]);

        $data = [
            'course_name' => $request->input('course_name'),
            'teacher' => $firstName,
            'teacher_id' => $teacherId,
            'day' => $request->input('day'),
            'time_slot' => $request->input('time_slot'),
        ];

        Course::create($data);

        return redirect()->route('admin.schedule');
    }

}
