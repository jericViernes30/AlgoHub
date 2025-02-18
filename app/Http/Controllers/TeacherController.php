<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
    public function createTeacher(Request $request){
        $password = 'mira01';
        $hashedPassword = Hash::make($password);
        
        // $data = [
        //     'first_name' => $request->input('first_name'),
        //     'last_name' => $request->input('last_name'),
        //     'email_address' => $request->input('email_address'),
        //     'contact_number' => $request->input('contact_number'),
        //     'username' => $request->input('username'),
        //     'password' => $request->input('password'),
        // ];

        $data = [
            'first_name' => 'Ma Almira',
            'last_name' => 'Ticar',
            'email_address' => 'maalmiraticar01@gmail.com',
            'contact_number' => '+63 992 131 7519',
            'username' => 'ticarm',
            'password' => $hashedPassword,
        ];

        $create = Teacher::create($data);

        if($create){
            return view('Teacher.dashboard');
        }
    }

    public function classDetail($code)
    {
        $class = Course::where('course_ID', $code)->first();


        $teacherID = $class->teacher_id;
        $teacherDetails = Teacher::where('id', $teacherID)->first();

        $students = EnrolledStudent::where('classID', $code)->get();

        return view('Teacher/group_details', [
            'class' => $class,
            'teacher' => $teacherDetails,
            'students' => $students,
        ]);
    }

    public function ILDetails($code){
        $il = ILSchedule::where('code', $code)->first();
        $teacher = Teacher::where('id', $il->teacher)->first();
        $students = ILStudents::where('code', $code)->get();
        return view('Teacher.il_details', ['il' => $il, 'students' => $students, 'teacher' => $teacher]);
    }

    public function updateIlDetails(Request $request)
    {
        // Log::info('IL Details Update Request', [
        //     'code' => $request->input('il'),
        //     'student' => $request->input('student'),
        //     'teacher' => $request->input('teacher'),
        //     'action' => $request->input('action'),
        // ]);
        $student = ILStudents::where('student_name', $request->input('student'))->first();

        if (!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        if ($request->input('action') == 'completed') {
            $student->status = 'Completed';
        } else {
            $student->status = 'Did not attend';
        }
        $student->save();
        return response()->json([
            'message' => 'Request has been logged and student status updated successfully',
        ], 200);
    }

    


    public function teacherDashboard()
    {
        $teacherID = session('teacher_id');
        $teacher = Teacher::where('id', $teacherID)->first();
        $subjects = Course::where('teacher_id', $teacher->id)->get();

        $subjects->each(function ($subject) {
            $subject->formatted_time = $this->getTime($subject->time_slot);
        });
        $courseIDs = $subjects->pluck('course_ID'); // Extract course IDs into an array
        $students = EnrolledStudent::whereIn('classID', $courseIDs)->get();
        return view('Teacher.dashboard', [
            'teacher' => $teacher,
            'subjects' => $subjects,
            'students' => $students,
        ]);
    }

    private function getTime($time)
    {
        switch ($time) {
            case 'first':
                return '11:00 AM to 12:30 PM';
            case 'second':
                return '1:00 PM to 2:30 PM';
            case 'third':
                return '3:00 PM to 4:30 PM';
            case 'fourth':
                return '5:00 PM to 6:30 PM';
            case 'fifth':
                return '7:00 PM to 8:30 PM';
            default:
                return 'Unknown time slot';
        }
    }



    public function loginTeacher(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to find the teacher by username
        $teacher = Teacher::where('username', $request->username)->first();

        // Check if the teacher exists and the password matches
        if ($teacher && Hash::check($request->password, $teacher->password)) {
            // Store teacher info in the session or generate a token
            session(['teacher_id' => $teacher->id]);
            $subjects = Course::where('teacher_id', $teacher->id)->get();
            return redirect()->route('teacher.dashboard', ['teacher' => $teacher, 'subjects' => $subjects]);

            return response()->json([
                'message' => 'Login successful',
                'teacher' => $teacher,
            ], 200);
        }

        // If authentication fails, return an error response
        return response()->json([
            'message' => 'Invalid username or password',
        ], 401);
    }

    public function ILSchedule(){
        $teacherID = session('teacher_id');
        $teacher = Teacher::where('id', $teacherID)->first();
        $subjects = ILSchedule::where('teacher', $teacher->id)->get();
        $students = collect();
        foreach ($subjects as $subject){
            $studentsForSubject = ILStudents::where('code', $subject->code)->get();
            $students = $students->merge($studentsForSubject);
        }
        // dd($students);

        return view('Teacher.il_schedules', [
            'teacher' => $teacher,
            'subjects' => $subjects,
            'students' => $students,
        ]);
    }

    public function logoutTeacher(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('welcome');
    }
}
