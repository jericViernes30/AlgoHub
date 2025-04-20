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

public function generateMonthlyReportPDF($month)
{
    $carbonMonth = Carbon::parse($month);
    $startOfMonth = $carbonMonth->copy()->startOfMonth();
    $endOfMonth = $carbonMonth->copy()->endOfMonth();

    Log::info("Fetching records from: $startOfMonth to $endOfMonth");

    // Get scheduling records for the selected month
    $scheduling = SchedulesList::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

    $scheduledCount = $scheduling->count();
    $inquiredCourses = $scheduling->pluck('inquired_courses')->toArray();

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

    // If no records found, set empty values
    if ($scheduling->isEmpty()) {
        Log::info("No records found for $month. Generating a blank report.");
        $scheduledCount = 0;
        $courseCounts = [];
    }

    // Debugging Log
    Log::info("Total Walk-ins: $scheduledCount");
    Log::info("Course Inquiries: " . json_encode($courseCounts));

    // Generate the PDF
    $pdf = Pdf::loadView('reports.monthly', compact('scheduling', 'scheduledCount', 'courseCounts'));

    return $pdf->download("Monthly_Report_{$month}.pdf");
}










}
