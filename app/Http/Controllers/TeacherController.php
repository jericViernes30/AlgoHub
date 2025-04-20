<?php

namespace App\Http\Controllers;

use App\Models\AvailableCourse;
use App\Models\Course;
use App\Models\EnrolledStudent;
use App\Models\ILSchedule;
use App\Models\ILStudents;
use App\Models\Lessons;
use App\Models\Notification;
use App\Models\SchedulesList;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Services\MailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
    public function createTeacher(Request $request)
    {
        $defaultPassword = $request->input('last_name').'m';
        $email = $request->input('email_address');
        try {
            Log::info('Teacher creation started', ['request_data' => $request->except('password')]);
    
            // Validate the request data
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:11',
                'email_address' => 'required|email|unique:teachers,email_address',
                'username' => 'required|string|unique:teachers,username|max:255',
                'password' => 'nullable',
                'certified_courses' => 'required|array',
                'certificates' => 'nullable|array', // Allow multiple certificates
                'certificates.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB limit
            ]);
    
            Log::info('Validation successful');
    
            // Convert courses array into a comma-separated string
            $validatedData['certified_courses'] = implode(',', $validatedData['certified_courses']);
    
            // Hash the password
            $validatedData['password'] = Hash::make($defaultPassword);
            Log::info('Password hashed');
    
            // Handle profile picture upload
            $profileDefault = 'user-default.png';
            $validatedData['profile'] = $profileDefault;

            if ($request->hasFile('certificates')) {
                $certificatePaths = [];
                $lastName = $request->input('last_name');
                $dateToday = now()->format('Y-m-d');
                
                foreach ($request->file('certificates') as $certificate) {
                    // Generate the new file name
                    $randomDigits = rand(10000, 99999); // 5 random digits
                    $fileName = "{$lastName}-{$dateToday}-{$randomDigits}.{$certificate->getClientOriginalExtension()}";
            
                    // Define the path where the file will be stored
                    $destinationPath = public_path('images'); // Public directory
                    
                    // Move the file to the public/images folder
                    $certificate->move($destinationPath, $fileName);  // Use move to move the file
            
                    // Store only the file name in the database (no 'public/' prefix)
                    $certificatePaths[] = $fileName;
                }
            
                // Store the comma-separated file names in the database
                $validatedData['certificates'] = implode(',', $certificatePaths); 
            }
            
            
    
            // Create the teacher record in the database
            $teacher = Teacher::create($validatedData);
            Log::info('Teacher created successfully', ['teacher_id' => $teacher->id]);

            $mailService = new MailService();
            $resetLink = url("/set-password/" . urlencode($email)); // Generates a proper URL
            
            $emailBody = "
                <html>
                    <head>
                        <title>Set up a password</title>
                    </head>
                    <body>
                        <div style='width: 400px; padding: 10px;'>
                            <div style='width: 100%; padding-top: 2rem; display: flex; justify-content: center; align-items: center; gap: 1.25rem; margin-bottom: 2.5rem;'>
                                <p style='font-size: 1.125rem; color: #632c7d'>Algorithmics Nuvali</p>
                            </div>
                            <h1 style='color: #333333;'>Setting up a password</h1>
                            <p>Open this link to proceed with setting up your password:</p>
                            <a href='{$resetLink}' style='color: #007bff; text-decoration: none;'>{$resetLink}</a>
                            <p>Thank you!</p>
                        </div>
                    </body>
                </html>";
    
            $mailService->sendMail($email, "Account completion", $emailBody);
    
            return redirect()->route('admin.dashboard')->with('success', 'Teacher created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating teacher', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An error occurred while creating the teacher.');
        }
    }

    public function updateProfile(Request $request)
{
    Log::info('Profile update request received', ['request_data' => $request->all()]);

    $request->validate([
        'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's an image
        'id' => 'required|exists:teachers,id' // Ensure the teacher exists
    ]);

    $teacher = Teacher::findOrFail($request->id);
    Log::info('Teacher found', ['teacher_id' => $teacher->id, 'current_profile' => $teacher->profile]);

    if ($request->hasFile('profile')) {
        $lastName = $teacher->last_name;
        $dateToday = now()->format('Y-m-d');
        $randomDigits = rand(10000, 99999);
        $fileName = "{$lastName}-{$dateToday}-{$randomDigits}.{$request->file('profile')->getClientOriginalExtension()}";

        Log::info('Generated file name', ['file_name' => $fileName]);

        // Move the file to the public/images folder
        try {
            $request->file('profile')->move(public_path('images'), $fileName);
            Log::info('File moved successfully', ['path' => public_path('images') . '/' . $fileName]);

            // Update teacher profile in the database
            $teacher->profile = $fileName;
            $teacher->save();

            Log::info('Teacher profile updated in the database', ['teacher_id' => $teacher->id, 'new_profile' => $fileName]);

            return response()->json(['message' => 'Profile updated successfully!', 'profile' => $fileName]);
        } catch (\Exception $e) {
            Log::error('Error moving file', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to upload file'], 500);
        }
    }

    Log::warning('No file uploaded in request');
    return response()->json(['error' => 'No file uploaded'], 400);
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

        $notifs = Notification::where('teacher', $teacherID)
            ->orderBy('created_at', 'desc') // Order by the latest notifications first
            ->get();

        $notSeen = Notification::where('teacher', $teacherID)
            ->where('status', '!=', 'seen')
            ->exists();

        $students = EnrolledStudent::where('classID', $code)->get();

        return view('Teacher/group_details', [
            'class' => $class,
            'teacher' => $teacherDetails,
            'students' => $students,
            'notifs' => $notifs,
            'notSeen' => $notSeen
        ]);
    }

    public function notifications()
{
    $teacherId = session('teacher_id');
    $notifs = Notification::where('teacher', $teacherId)->where('status', 'sent')
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => !$notifs->isEmpty(), // true if notifications exist, false otherwise
            'message' => $notifs->isEmpty() ? 'false' : 'true',
            'notifications' => $notifs
        ]);
        
}


    public function ILDetails($code){
        $il = ILSchedule::where('code', $code)->first();
        $teacher = Teacher::where('id', $il->teacher)->first();
        $students = ILStudents::where('code', $code)->where('status', 'Pending')->get();
        $teacherID = session('teacher_id');
        $notifs = Notification::where('teacher', $teacherID)
            ->orderBy('created_at', 'desc') // Order by the latest notifications first
            ->get();

        $notSeen = Notification::where('teacher', $teacherID)
            ->where('status', '!=', 'seen')
            ->exists();
        return view('Teacher.il_details', ['il' => $il, 'students' => $students, 'teacher' => $teacher,
        'notifs' => $notifs,
        'notSeen' => $notSeen]);
    }

public function updateIlDetails(Request $request)
{
    $student = ILStudents::where('student_name', $request->input('student'))->first();
    $studentName = SchedulesList::where('childs_name', $request->input('student'))->first();

    Log::info('Updating student status:', [
        'ILStudents' => $student ? $student->toArray() : 'Not found',
        'SchedulesList' => $studentName ? $studentName->toArray() : 'Not found',
        'Action' => $request->input('action')
    ]);

    if (!$student) {
        return response()->json([
            'message' => 'Student not found',
        ], 404);
    }

    if ($request->input('action') == 'completed') {
        $student->status = 'Completed';
        if ($studentName) {
            $studentName->status = 'Completed';
            $studentName->save();
        }
    } else {
        $student->status = 'Did not attend';
        if ($studentName) {
            $studentName->status = 'Did not attend';
            $studentName->save();
        }
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
        $subjects = Course::where('teacher_id', $teacher->id)->where('status', 'Started')->get();
        $notifs = Notification::where('teacher', $teacherID)
            ->orderBy('created_at', 'desc') // Order by the latest notifications first
            ->get();

        $subjects->each(function ($subject) {
            $subject->formatted_time = $this->getTime($subject->time_slot);
        });

        $notSeen = Notification::where('teacher', $teacherID)
            ->where('status', '!=', 'seen')
            ->exists();

        $courseIDs = $subjects->pluck('course_ID'); // Extract course IDs into an array
        Log::info($courseIDs);

        // Get the student count per course
        $studentCounts = EnrolledStudent::whereIn('classID', $courseIDs)
            ->selectRaw('classID, COUNT(*) as count')
            ->groupBy('classID')
            ->pluck('count', 'classID')
            ->toArray();

        // Initialize all courseIDs with 0 count
        $finalCounts = [];
        foreach ($courseIDs as $courseID) {
            $finalCounts[$courseID] = $studentCounts[$courseID] ?? 0;
        }

        return view('Teacher.dashboard', [
            'teacher' => $teacher,
            'subjects' => $subjects,
            'students' => $finalCounts,
            'notifs' => $notifs,
            'notSeen' => $notSeen
        ]);
    }

    public function seenNotif($teacher)
    {
        Notification::where('teacher', $teacher)
            ->where('status', '!=', 'seen') // Only update unseen notifications
            ->update(['status' => 'seen']);

        return response()->json(['message' => 'Notifications marked as seen']);
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
    try {
        // Validate the request data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if a teacher is already logged in
        if (session('teacher_logged_in')) {
            return response()->json([
                'message' => 'You are already logged in on another tab.',
            ], 403);
        }

        // Find teacher by username
        $teacher = Teacher::where('username', $request->username)->first();

        // Check if the teacher exists and password is correct
        if ($teacher && Hash::check($request->password, $teacher->password)) {
            // Store teacher session
            session([
                'teacher_id' => $teacher->id,
                'teacher_logged_in' => true
            ]);

            // Retrieve subjects assigned to the teacher
            $subjects = Course::where('teacher_id', $teacher->id)->get();

            return response()->json([
                'message' => 'Login successful',
                'teacher' => $teacher,
                'subjects' => $subjects, // Include subjects in response
                'redirect' => route('teacher.dashboard', ['teacher' => $teacher->id])
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid username or password',
            ], 401);
        }
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'An unexpected error occurred. Please try again.',
            'error' => $e->getMessage(), // Debugging (Remove in production)
        ], 500);
    }
}



    public function ILSchedule()
{
    $teacherID = session('teacher_id');
    $teacher = Teacher::where('id', $teacherID)->first();
    $subjects = ILSchedule::where('teacher', $teacher->id)
        ->where('status', 'Ongoing')
        ->get();

    // Initialize array to store student counts per course code
    $studentCounts = [];

    foreach ($subjects as $subject) {
        $studentCounts[$subject->code] = ILStudents::where('code', $subject->code)->where('status', 'Pending')->count();
    }

    // Get notifications
    $notifs = Notification::where('teacher', $teacherID)
        ->orderBy('created_at', 'desc')
        ->get();

    $notSeen = Notification::where('teacher', $teacherID)
        ->where('status', '!=', 'seen')
        ->exists();

    return view('Teacher.il_schedules', [
        'teacher' => $teacher,
        'subjects' => $subjects,
        'studentCounts' => $studentCounts, // Pass the student count per course code
        'notifs' => $notifs,
        'notSeen' => $notSeen
    ]);
}


    public function logoutTeacher(Request $request)
    {
        // Clear session data
        $request->session()->forget('teacher_logged_in');
        $request->session()->forget('teacher_id');

        // Optionally destroy the session entirely
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('message', 'Logged out successfully.');
    }


    public function getCourse($name)
    {
        $course = Lessons::where('course', $name)->get();

        return response()->json($course);
    }

    public function profile(){
        $teacherID = session('teacher_id');
        $teacher = Teacher::where('id', $teacherID)->first();

        $notifs = Notification::where('teacher', $teacherID)
            ->orderBy('created_at', 'desc') // Order by the latest notifications first
            ->get();

        $notSeen = Notification::where('teacher', $teacherID)
            ->where('status', '!=', 'seen')
            ->exists();

        return view('Teacher.profile', ['teacher' => $teacher,
        'notifs' => $notifs,
        'notSeen' => $notSeen]);
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

    public function deleteTeacher($id)
{
    $teacher = Teacher::find($id);

    if (!$teacher) {
        return response()->json(['error' => 'Teacher not found'], 404);
    }

    $teacher->delete();

    return response()->json(['success' => 'Teacher deleted successfully']);
}



    
}
