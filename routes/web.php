<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/admin-create', [ActivityController::class, 'createAdmin'])->name('admin.create');
Route::get('/admin_login', [ActivityController::class, 'admin_login'])->name('admin.login');
Route::post('/admin/login-post', [ActivityController::class, 'adminLoginPost'])->name('admin.login.post');
Route::get('/admin/logout', [ActivityController::class, 'logoutAdmin'])->name('admin.logout');
Route::get('/admin_dashboard', [ActivityController::class, 'admin_dashboard'])->name('admin.dashboard');
Route::get('/admin_schedule', [ActivityController::class, 'admin_schedule'])->name('admin.schedule');
Route::get('/admin_schedule/il_schedule', [ActivityController::class, 'il_schedule'])->name('admin.il_schedule');
Route::get('/admin_schedule/il_schedule_all', [ActivityController::class, 'showIlSchedule'])->name('admin.show_il_schedule');
Route::post('admin_schedule/add_class_schedule', [CourseController::class, 'add_class'])->name('admin.add_class_post');
Route::get('/teachers_login', [ActivityController::class, 'teacher_login'])->name('teacher.login');
Route::get('/admin/schedules/for_scheduling', [ActivityController::class, 'for_scheduling'])->name('admin.schedule.for_scheduling');
Route::post('/admin/schedules/add_new_client', [ActivityController::class, 'add_client'])->name('admin.add_client');
Route::post('/admin/schedules/update_client', [ActivityController::class, 'update_client'])->name('admin.update_client');
Route::get('/admin/schedules/delete_client/{parent_name}', [ActivityController::class, 'delete_client'])->name('admin.delete_client');
Route::get('admin/get-schedules/{course}', [ActivityController::class, 'getSchedules'])->name('admin.get_schedules');
Route::post('/admin/proceed-to-il', [ActivityController::class, 'proceedToIl'])->name('admin.proceed');
Route::get('/admin/courses', [ActivityController::class, 'courses'])->name('admin.courses');

Route::get('admin/course/The-Coding-Knight', [CourseController::class, 'codingKnight'])->name('admin.coding_knight');
Route::get('admin/course/Visual-Programming', [CourseController::class, 'visualProgramming'])->name('admin.visual_programming');
Route::get('admin/course/Python-Start-1', [CourseController::class, 'pythonStart1'])->name('admin.python_start1');
Route::get('admin/course/Python-Start-2', [CourseController::class, 'pythonStart2'])->name('admin.python_start2');
Route::get('admin/course/Python-Pro-1', [CourseController::class, 'pythonPro1'])->name('admin.python_pro1');
Route::get('admin/course/Python-Pro-2', [CourseController::class, 'pythonPro2'])->name('admin.python_pro2');
Route::get('admin/course/Building-Websites', [CourseController::class, 'buildingWebsites'])->name('admin.building_websites');
Route::get('admin/course/Game-Design', [CourseController::class, 'gameDesign'])->name('admin.game_design');
Route::get('admin/course/Digital-Literacy', [CourseController::class, 'digitalLiteracy'])->name('admin.digital_literacy');

Route::get('/admin/open_il/{code}', [
    ActivityController::class, 'openIl',
])->name('admin.open_il');

Route::get('/admin_sample', [
    ActivityController::class, 'sample',
])->name('admin.sample');

Route::get('admin/fetch-data', [ActivityController::class, 'fetchData'])->name('admin.fetch_data');

Route::post('admin/add_il_schedule', [ActivityController::class, 'addIlSchedule'])->name('admin.add_il_schedule');

Route::get('admin/get_course_sched/{course}', [ActivityController::class, 'showClassSched'])->name('admin.get_course_sched');

Route::GET('admin/add_to_schedule', [ActivityController::class, 'addToSched'])->name('admin.add_to_sched');

Route::get('admin/schedules/class_enrollees/{courseID}', [ActivityController::class, 'viewClassEnrollees'])->name('admin.view_class_enrollees');

Route::POST('admin/edit-start-date/{courseID}', [ActivityController::class, 'editStartDate'])->name('admin.edit_start_date');

Route::get('admin/students', [ActivityController::class, 'studentsList'])->name('admin.students');
Route::get('/admin/students-per-course', [ActivityController::class, 'studentsPerCourse'])->name('admin.students_per_course');

Route::get('/admin/teachers-list', [ActivityController::class, 'teachersList'])->name('admin.teachers_list');

Route::get('/admin/students/paginate/{page}', [ActivityController::class, 'paginate'])->name('admin.paginate_students');
Route::get('/admin/students/paginate-walkin/{page}', [ActivityController::class, 'paginateWalkIn'])->name('admin.paginate_walkin');

Route::get('/admin/students/expel/{student}/{course}', [ActivityController::class, 'expelStudent'])->name('admin.expel_student');



Route::get('teacher/dashboard', [TeacherController::class, 'teacherDashboard'])->name('teacher.dashboard');
Route::get('/teacher/class/{code}', [TeacherController::class, 'classDetail'])->name('teacher.classDetail');
Route::get('/teacher/il/{code}', [TeacherController::class, 'ILDetails'])->name('teacher.ILDetails');
Route::POST('/teacher/create', [TeacherController::class, 'createTeacher'])->name('teacher.create');
Route::POST('/teacher/edit', [TeacherController::class, 'editTeacher'])->name('teacher.edit');
Route::post('/teacher/login', [TeacherController::class, 'loginTeacher'])->name('teacher.login.post');
Route::get('/teacher/logout', [TeacherController::class, 'logoutTeacher'])->name('teacher.logout');
Route::get('/teacher/il_schedule', [TeacherController::class, 'ILSchedule'])->name('teacher.il_schedule');
Route::get('/teacher/il_details/update', [TeacherController::class, 'updateIlDetails'])->name('teacher.update_il_details');

Route::get('teacher/course/{name}', [TeacherController::class, 'getCourse'])->name('teacher.get_course');

Route::get('teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');

Route::post('teacher/update-password', [TeacherController::class, 'updatePassword'])->name('teacher.update_password');





Route::get('/reports/daily', [ReportController::class, 'generateDailyReportPDF'])->name('report.daily');
Route::get('/reports/monthly', [ReportController::class, 'generateMonthlyReportPDF'])->name('report.monthly');
