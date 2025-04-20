<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
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

Route::get('/', [ActivityController::class, 'loginPage'])->name('welcome');

Route::get('/admin-create', [ActivityController::class, 'createAdmin'])->name('admin.create');
Route::get('/admin_login', [ActivityController::class, 'admin_login'])->name('admin.login');
Route::post('/admin/login-post', [ActivityController::class, 'adminLoginPost'])->name('admin.login.post');
Route::get('/admin/logout', [ActivityController::class, 'logoutAdmin'])->name('admin.logout');
Route::get('/admin_dashboard', [ActivityController::class, 'admin_dashboard'])->name('admin.dashboard');
Route::get('/admin_schedule', [ActivityController::class, 'admin_schedule'])->name('admin.schedule');
Route::get('/admin_schedule/il_schedule', [ActivityController::class, 'il_schedule'])->name('admin.il_schedule');
Route::get('/admin_schedule/il_schedule_all', [ActivityController::class, 'showIlSchedule'])->name('admin.show_il_schedule');
Route::get('/admin_schedule/all-il-sched', [ActivityController::class, 'getAllILSchedules'])->name('admin.allILSched');
Route::post('admin_schedule/add_class_schedule', [CourseController::class, 'add_class'])->name('admin.add_class_post');
Route::get('/teachers_login', [ActivityController::class, 'teacher_login'])->name('teacher.login');
Route::get('/admin/schedules/for_scheduling', [ActivityController::class, 'for_scheduling'])->name('admin.schedule.for_scheduling');
Route::post('/admin/schedules/add_new_client', [ActivityController::class, 'add_client'])->name('admin.add_client');
Route::post('/admin/schedules/update_client', [ActivityController::class, 'update_client'])->name('admin.update_client');
Route::get('/admin/schedules/delete_client/{parent_name}', [ActivityController::class, 'delete_client'])->name('admin.delete_client');
Route::get('admin/get-schedules/{course}', [ActivityController::class, 'getSchedules'])->name('admin.get_schedules');
Route::post('/admin/proceed-to-il', [ActivityController::class, 'proceedToIl'])->name('admin.proceed');
Route::get('/admin/courses', [ActivityController::class, 'courses'])->name('admin.courses');

Route::get('/course/{course}', [CourseController::class, 'courseDetails'])->name('admin.course_details');
Route::get('/delete-course/{course}', [CourseController::class, 'deleteCourse'])->name('admin.course_delete');

Route::get('/course/Visual-Programming', [CourseController::class, 'visualProgramming'])->name('admin.visual_programming');
Route::get('/course/Python-Start-1', [CourseController::class, 'pythonStart1'])->name('admin.python_start1');
Route::get('/course/Python-Start-2', [CourseController::class, 'pythonStart2'])->name('admin.python_start2');
Route::get('/course/Python-Pro-1', [CourseController::class, 'pythonPro1'])->name('admin.python_pro1');
Route::get('/course/Python-Pro-2', [CourseController::class, 'pythonPro2'])->name('admin.python_pro2');
Route::get('/course/Building-Websites', [CourseController::class, 'buildingWebsites'])->name('admin.building_websites');
Route::get('/course/Game-Design', [CourseController::class, 'gameDesign'])->name('admin.game_design');
Route::get('/course/Digital-Literacy', [CourseController::class, 'digitalLiteracy'])->name('admin.digital_literacy');

Route::get('/admin/open_il/{code}', [ActivityController::class, 'openIl'])->name('admin.open_il');

Route::get('/admin_sample', [
    ActivityController::class, 'sample',
])->name('admin.sample');

Route::get('/admin/auth/reset', [
    ActivityController::class, 'resetPassword',
])->name('admin.reset_password');

Route::get('admin/fetch-data', [ActivityController::class, 'fetchData'])->name('admin.fetch_data');

Route::post('admin/add_il_schedule', [ActivityController::class, 'addIlSchedule'])->name('admin.add_il_schedule');

Route::get('admin/get_course_sched/{course}', [ActivityController::class, 'showClassSched'])->name('admin.get_course_sched');

Route::GET('admin/add_to_schedule', [ActivityController::class, 'addToSched'])->name('admin.add_to_sched');
Route::GET('admin/add_to_new_schedule', [ActivityController::class, 'addToNewSched'])->name('admin.add_to_new_sched');

Route::get('admin/schedules/class_enrollees/{courseID}', [ActivityController::class, 'viewClassEnrollees'])->name('admin.view_class_enrollees');

Route::POST('admin/edit-start-date/{courseID}', [ActivityController::class, 'editStartDate'])->name('admin.edit_start_date');

Route::get('admin/students', [ActivityController::class, 'studentsList'])->name('admin.students');
Route::get('/admin/students-per-course', [ActivityController::class, 'studentsPerCourse'])->name('admin.students_per_course');

Route::get('/admin/students-per-course/fetch', [ActivityController::class, 'studentsPerCourseFetch'])->name('admin.students_per_course_fetch');

Route::get('/admin/teachers-list', [ActivityController::class, 'teachersList'])->name('admin.teachers_list');

Route::get('/admin/students/paginate/{page}', [ActivityController::class, 'paginate'])->name('admin.paginate_students');

Route::get('/admin/expelled/paginate/{page}', [ActivityController::class, 'paginateExpelled'])->name('admin.paginate_expelled');

Route::get('/admin/students/paginate-walkin/{page}', [ActivityController::class, 'paginateWalkIn'])->name('admin.paginate_walkin');

Route::get('/admin/students/expel/{id}/{student}/{course}', [ActivityController::class, 'expelStudent'])->name('admin.expel_student');
Route::get('/admin/expelled', [ActivityController::class, 'expelledList'])->name('admin.expelled');

Route::get('/admin/archived', [ActivityController::class, 'archivedList'])->name('admin.archived');

Route::post('/admin/delete-il', [ActivityController::class, 'deleteILSchedule'])->name('admin.delete_il');

Route::post('/admin/delete-schedule', [CourseController::class, 'deleteClassSchedule'])->name('admin.delete_sched');

Route::delete('/admin/delete-teacher/{id}', [TeacherController::class, 'deleteTeacher'])->name('admin.deleteTeacher');

Route::put('/admin/student/{name}', [ActivityController::class, 'updateToArchive'])->name('admin.archivedStudent');

Route::post('/upload-course', [ActivityController::class, 'uploadCSV'])->name('upload.course');

Route::get('/password-reset', [ActivityController::class, 'passwordReset'])->name('password.reset');

Route::post('/admin/auth/v3/reset', [ActivityController::class, 'resetAdminPassword'])->name('admin.reset_password_auth');

Route::post('/check-username', [ActivityController::class, 'checkUsername']);

Route::post('/check-admin-username', [ActivityController::class, 'checkAdminUsername']);

Route::get('/reset-password/{email}', [ActivityController::class, 'reset']);
Route::post('/send-reset-email', [ActivityController::class, 'sendResetEmail']);
Route::post('/password-update', [ActivityController::class, 'passwordUpdate'])->name('password.update');
Route::post('/get-schedule-by-inquired', [ActivityController::class, 'getInquiredSched'])->name('inquired.sched');
Route::get('/set-password/{email}', [ActivityController::class, 'passwordSetup'])->name('password.setup');
Route::post('/set-password', [ActivityController::class, 'setPassword'])->name('password.set');



Route::get('/staff/dashboard', [StaffController::class, 'staff_dashboard'])->name('staff.dashboard');
Route::get('/staff/courses', [StaffController::class, 'courses'])->name('staff.courses');
Route::get('/staff/students', [StaffController::class, 'studentsList'])->name('staff.students');
Route::get('/staff/expelled', [StaffController::class, 'expelledList'])->name('staff.expelled');
Route::get('/staff/schedule', [StaffController::class, 'staff_schedule'])->name('staff.schedule');
Route::get('staff/schedules/class_enrollees/{courseID}', [StaffController::class, 'viewClassEnrollees'])->name('staff.view_class_enrollees');
Route::get('/staff/il_schedule', [StaffController::class, 'il_schedule'])->name('staff.il_schedule');
Route::get('/staff/walk-ins', [StaffController::class, 'walkInClients'])->name('staff.walk_in');
Route::post('/staff/proceed-to-il', [StaffController::class, 'proceedToIl'])->name('staff.proceed');
Route::get('/staff/il-details/{code}', [StaffController::class, 'openIl'])->name('staff.open_il');
Route::get('/staff/schedules/delete_client/{parent_name}', [StaffController::class, 'delete_client'])->name('staff.delete_client');


Route::get('teacher/dashboard', [TeacherController::class, 'teacherDashboard'])->name('teacher.dashboard');
Route::get('/teacher/class/{code}', [TeacherController::class, 'classDetail'])->name('teacher.classDetail');
Route::get('/teacher/il/{code}', [TeacherController::class, 'ILDetails'])->name('teacher.ILDetails');
Route::POST('/teacher/create', [TeacherController::class, 'createTeacher'])->name('teacher.create');
Route::POST('/teacher/edit', [TeacherController::class, 'editTeacher'])->name('teacher.edit');
Route::post('/teacher/login', [TeacherController::class, 'loginTeacher'])->name('teacher.login.post');
Route::get('/teacher/logout', [TeacherController::class, 'logoutTeacher'])->name('teacher.logout');
Route::get('/teacher/il_schedule', [TeacherController::class, 'ILSchedule'])->name('teacher.il_schedule');
Route::get('/teacher/il_details/update', [TeacherController::class, 'updateIlDetails'])->name('teacher.update_il_details');
Route::post('/teacher/update-profile', [TeacherController::class, 'updateProfile'])->name('teacher.updateProfile');

Route::get('teacher/course/{name}', [TeacherController::class, 'getCourse'])->name('teacher.get_course');

Route::get('teacher/profile', [TeacherController::class, 'profile'])->name('teacher.profile');

Route::post('teacher/update-password', [TeacherController::class, 'updatePassword'])->name('teacher.update_password');

Route::get('teacher/seen-notif/{teacher}', [TeacherController::class, 'seenNotif'])->name('teacher.seenNotif');

Route::get('teacher/notifications', [TeacherController::class, 'notifications'])->name('teacher.notifications');



Route::get('/reports/daily', [ReportController::class, 'generateDailyReportPDF'])->name('report.daily');
Route::get('/reports/monthly/{month}', [ReportController::class, 'generateMonthlyReportPDF'])->name('report.monthly');
