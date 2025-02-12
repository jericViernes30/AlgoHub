<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ILStudents;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function createTeacher(Request $request){
        $password = 'Jj_101820';
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
            'first_name' => 'Jeric James',
            'last_name' => 'Viernes',
            'email_address' => 'jericviernes06@gmail.com',
            'contact_number' => '+63 997 658 9181',
            'username' => 'viernesm',
            'password' => $hashedPassword,
        ];

        $create = Teacher::create($data);

        if($create){
            return view('Teacher.dashboard');
        }
    }

    public function classDetail($code)
{
    // Retrieve the class details based on the course ID
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


    public function teacherDashboard(){
        $teacherID = session('teacher_id');
        $teacher = Teacher::where('id', $teacherID)->first();
        $subjects = Course::where('teacher_id', $teacher->id)->get();
        return view('Teacher.dashboard', ['teacher' => $teacher, 'subjects' => $subjects]);
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
            return view('Teacher.dashboard', ['teacher' => $teacher, 'subjects' => $subjects]);

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

    public function logoutTeacher(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return view('welcome');
    }
}
