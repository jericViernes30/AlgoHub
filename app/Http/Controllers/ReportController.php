<?php

namespace App\Http\Controllers;

use App\Models\AvailableCourse;
use App\Models\EnrolledStudent;
use App\Models\ILStudents;
use App\Models\SchedulesList;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function generateDailyReportPDF(Request $request)
{
    $today = Carbon::today();

    // Get only today's scheduling records (walk-in clients)
    $scheduling = SchedulesList::whereDate('created_at', $today)->get();

    // Count only today's walk-in clients
    $scheduledCount = $scheduling->count();

    // Count course inquiries only for today
    $inquiredCourses = SchedulesList::whereDate('created_at', $today)
        ->pluck('inquired_courses')
        ->toArray();

    $courses = [];
    foreach ($inquiredCourses as $courseList) {
        if ($courseList) {
            $separatedCourses = array_map('trim', explode(',', $courseList));
            foreach ($separatedCourses as $course) {
                $courses[] = $course;
            }
        }
    }
    $courseCounts = array_count_values($courses);

    // Get base64 image data from request (sent via AJAX)
    $chartImage = $request->input('chart_image');

    // Pass data to the view
    $pdf = Pdf::loadView('reports.daily', compact('scheduling', 'scheduledCount', 'courseCounts', 'chartImage'));

    return $pdf->download('Daily report |' . now()->format('F d, Y') . '.pdf');
}

public function generateMonthlyReportPDF(Request $request)
{
    $month = Carbon::now();
    $startOfMonth = $month->copy()->startOfMonth();
    $endOfMonth = $month->copy()->endOfMonth();

    // Debugging Log
    Log::info("Fetching records from: $startOfMonth to $endOfMonth");

    // Get only this month's scheduling records (walk-in clients)
    $scheduling = SchedulesList::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

    // Count total walk-ins for the month
    $scheduledCount = $scheduling->count();

    // Count course inquiries only for this month
    $inquiredCourses = SchedulesList::whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->pluck('inquired_courses')
        ->toArray();

    $courses = [];
    foreach ($inquiredCourses as $courseList) {
        if ($courseList) {
            $separatedCourses = array_map('trim', explode(',', $courseList));
            foreach ($separatedCourses as $course) {
                $courses[] = $course;
            }
        }
    }
    $courseCounts = array_count_values($courses);

    // Debugging Log
    Log::info("Total Walk-ins: $scheduledCount");
    Log::info("Course Inquiries: " . json_encode($courseCounts));

    // Get base64 image data from request (sent via AJAX)
    $chartImage = $request->input('chart_image');

    // Pass data to the view
    $pdf = Pdf::loadView('reports.monthly', compact('scheduling', 'scheduledCount', 'courseCounts', 'chartImage'));

    return $pdf->download('Monthly report | ' . $month->format('F Y') . '.pdf');
}






}
