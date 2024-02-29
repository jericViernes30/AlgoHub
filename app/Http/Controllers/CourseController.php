<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SchedulesList;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function add_class(Request $request){
        $data = $request->validate([
            'course_name' => 'required',
            'teacher' => 'required|string',
            'month' => 'required',
            'day' => 'required',
            'time_slot' => 'required'
        ]);

        Course::create($data);

        return redirect()->route('admin.schedule');
    }

}
