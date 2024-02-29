<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\SchedulesList;
use Illuminate\Console\Scheduling\Schedule;

;

class ActivityController extends Controller
{
    public function admin_login(){
        return view('Admin/admin_login');
    }

    public function admin_dashboard(){
        $schedule = Course::all();
        return view('Admin/admin_dashboard', ['schedule' => $schedule]);
    }

    public function admin_schedule(){
        $schedule = Course::all();
        $courses = AvailableCourse::all();
        return view('Admin/admin_schedule', ['schedule' => $schedule, 'courses' => $courses]);
    }

    public function il_schedule(){
        $scheduling = SchedulesList::all();
        return view('Admin/il_schedule', ['scheduling' => $scheduling]);
    }  

    public function teacher_login(){
        return view('welcome');
    }

    public function for_scheduling(){
        $scheduling = SchedulesList::all();
        return view('Admin/for_scheduling', ['scheduling' => $scheduling]);
    }

    public function add_client(Request $request){
        $data = $request->validate([
            'parents_name' => 'required',
            'childs_name' => 'required',
            'age' => 'required',
            'contact_number' => 'required',
            'email_address' => 'required',
            'status' => 'nullable'
        ]);

        $data['status'] = $request->input('status', 'Pending');

        SchedulesList::create($data);

        return redirect()->route('admin.schedule.for_scheduling');
    }

    public function update_client(Request $request){
        $client = SchedulesList::where('parents_name', $request->input('parents_name'))->first();
        if ($client) {
            $client->update([
                'childs_name' => $request->input('childs_name'),
                'age' => $request->input('age'),
                'contact_number' => $request->input('contact_number'),
                'email_address' => $request->input('email_address'),
                'status' => $request->input('status')
            ]);
            
            // Optionally, you can return a response indicating success
            return redirect()->back()->with('success', 'Client updated successfully');
        } else {
            // Optionally, handle the case where the client is not found
            return redirect()->back()->with('error', 'Client not found');
        }
    }
    
    public function delete_client($parent_name){
        // Delete the data
        SchedulesList::where('parents_name', $parent_name)->delete();
        
        // Redirect back to the current page
        return redirect()->route('admin.schedule.for_scheduling');
    }
}
