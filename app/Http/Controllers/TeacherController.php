<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use App\Models\Lessons;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
    public function createTeacher(Request $request)
    {
        try {
            Log::info('Teacher creation started', ['request_data' => $request->except('password')]);
    
            // Validate the request data
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'email_address' => 'required|email|unique:teachers,email_address',
                'username' => 'required|string|unique:teachers,username|max:255',
                'password' => 'required|string|min:6',
                'certified_courses' => 'required|array',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB limit
            ]);
    
            Log::info('Validation successful');
    
            // Convert courses array into a comma-separated string
            $validatedData['certified_courses'] = implode(',', $validatedData['certified_courses']);
    
            // Hash the password
            $validatedData['password'] = Hash::make($validatedData['password']);
            Log::info('Password hashed');
    
            // Handle profile picture upload
            if ($request->hasFile('profile')) {
                $profile = $request->file('profile');
                $filename = time() . '.' . $profile->getClientOriginalExtension();
                $profile->move(public_path('images'), $filename);
                $validatedData['profile'] = $filename;
                Log::info('Profile picture uploaded', ['filename' => $filename]);
            }
    
            // Create the teacher record in the database
            $teacher = Teacher::create($validatedData);
            Log::info('Teacher created successfully', ['teacher_id' => $teacher->id]);
    
            return redirect()->route('admin.dashboard')->with('success', 'Teacher created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating teacher', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while creating the teacher.');
        }
    }

    public function editTeacher(Request $request)
{
    $teacher = Teacher::findOrFail($request->input('id'));

    $validatedData = $request->validate([
        'edit_first_name' => 'nullable|string|max:255',
        'edit_last_name' => 'nullable|string|max:255',
        'edit_email_address' => 'nullable|email|max:255',
        'edit_contact_number' => 'nullable|string|max:20',
        'edit_certified_courses' => 'nullable|array',
    ]);

    // Convert certified courses array to a comma-separated string
    $certifiedCourses = isset($validatedData['edit_certified_courses'])
        ? implode(', ', $validatedData['edit_certified_courses'])
        : $teacher->certified_courses;

    // Map request data to the model fields
    $teacher->update([
        'first_name' => $validatedData['edit_first_name'] ?? $teacher->first_name,
        'last_name' => $validatedData['edit_last_name'] ?? $teacher->last_name,
        'email_address' => $validatedData['edit_email_address'] ?? $teacher->email_address,
        'contact_number' => $validatedData['edit_contact_number'] ?? $teacher->contact_number,
        'certified_courses' => $certifiedCourses,
    ]);

    return redirect()->route('admin.teachers_list')->with('success', 'Teacher details updated successfully.');
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
        } else {
            return response()->json([
                'message' => 'Please check your password',
            ], 401);
        }

        // If authentication fails, return an error response
        return response()->json([
            'message' => 'Invalid username',
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

    public function getCourse($name)
    {
        $course = Lessons::where('course', $name)->get();

        return response()->json($course);
    }

    public function profile(){
        $teacherID = session('teacher_id');
        $teacher = Teacher::where('id', $teacherID)->first();

        return view('Teacher.profile', ['teacher' => $teacher]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:4',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $teacher = Teacher::findOrFail($request->id);

        // Update the password
        $teacher->password = Hash::make($request->new_password);
        $teacher->save();

        return back()->with('success', 'Password changed successfully!');
    }



    
}
