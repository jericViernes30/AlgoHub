<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CourseController;
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
});

Route::get('/admin_login', [ActivityController::class, 'admin_login'])->name('admin.login');
Route::get('/admin_dashboard', [ActivityController::class, 'admin_dashboard'])->name('admin.dashboard');
Route::get('/admin_schedule', [ActivityController::class, 'admin_schedule'])->name('admin.schedule');
Route::get('/admin_schedule/il_schedule', [ActivityController::class, 'il_schedule'])->name('admin.il_schedule');
Route::post('admin_schedule/add_class_schedule', [CourseController::class, 'add_class'])->name('admin.add_class_post');
Route::get('/teachers_login', [ActivityController::class, 'teacher_login'])->name('teacher.login');
Route::get('/admin/schedules/for_scheduling', [ActivityController::class, 'for_scheduling'])->name('admin.schedule.for_scheduling');
Route::post('/admin/schedules/add_new_client', [ActivityController::class, 'add_client'])->name('admin.add_client');
Route::post('/admin/schedules/update_client', [ActivityController::class, 'update_client'])->name('admin.update_client');
Route::get('/admin/schedules/delete_client/{parent_name}', [ActivityController::class, 'delete_client'])->name('admin.delete_client');
