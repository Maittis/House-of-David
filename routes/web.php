<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; // Make sure to import the controller
use App\Http\Controllers\AttendanceController;
use App\Services\TwilioSMSService;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SmsReplyController;
use App\Http\Controllers\SMSWebhookController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\InspirationalMessageController;


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


    // routes/web.php
    Route::get('/', function () {
        return view('welcome');
    })->middleware('auth');


    // routes/web.php
    Route::get('/', [WelcomeController::class, 'index']);

    Route::middleware(['auth'])->group(function () {
        Route::get('/memberArea/video/{id}', [MemberDashboardController::class, 'watchVideo'])->name('memberArea.video.watch');
    });



    // routes/web.php
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');



    // Password Reset Routes
    Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');




    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::get('/', function (){

    //     return view ('welcome');
    // })->middleware('auth');

    Route::group(['prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('members', [AdminController::class, 'members'])->name('admin.members');
    Route::get('members/create', [AdminController::class, 'createMember'])->name('admin.members.create');
    Route::post('members', [AdminController::class, 'storeMember'])->name('admin.members.store');
    Route::get('members/{member}/edit', [AdminController::class, 'editMember'])->name('admin.members.edit');
    Route::put('members/{member}', [AdminController::class, 'updateMember'])->name('admin.members.update');
    Route::delete('members/{member}', [AdminController::class, 'deleteMember'])->name('admin.members.delete');
    Route::get('admin/members', [AdminController::class, 'index'])->name('admin.members.index');




    Route::get('attendance', [AdminController::class, 'recordAttendance'])->name('admin.attendance.list');

    // Route to save general attendance
    Route::post('save-attendance', [AdminController::class, 'saveAttendance'])->name('admin.save.attendance');

    // Route to send SMS to all absent members
    Route::post('send-sms-to-absent', [AdminController::class, 'sendSMStoAbsentMembers'])->name('admin.send.sms.to.absent');

    // Route to send custom follow-up message
    Route::post('send-custom-follow-up', [AdminController::class, 'sendCustomFollowUpMessage'])->name('admin.send.custom.follow.up');

    // Service-specific routes
    // Route::get('attendance/{serviceId}', [AdminController::class, 'showAttendanceForm'])->name('admin.attendance.for.service');

    // Route to save attendance for a specific service
    Route::post('attendance/{serviceId}', [AdminController::class, 'saveAttendanceForService'])->name('admin.save.attendance.for.service');

    // Route to view absent members for a specific service
    // Route::get('absent-members/{serviceId}', [AdminController::class, 'viewAbsentMembersForService'])->name('admin.absent.members.for.service');

    // Route to send SMS to absent members for a specific service
    // Route::post('send-sms-to-absent/{serviceId}', [AdminController::class, 'sendSMStoAbsentMembersForService'])->name('admin.send.sms.to.absent.for.service');

    Route::get('/admin/absent-members/{serviceId}', [AdminController::class, 'getAbsentMembersForService'])->name('admin.absent.members.for.service');
    Route::get('/attendance', [AdminController::class, 'index'])->name('admin.attendance.index');
    Route::post('/attendance', [AdminController::class, 'store'])->name('admin.attendance.store');
    // Route::post('/attendance/sms', [AdminController::class, 'sendSms'])->name('admin.attendance.sms');
    Route::get('/admin/attendance/absent', [AdminController::class, 'absentMembers'])->name('admin.attendance.absent');
    // Route::post('/admin/attendance/absent/sms', [AdminController::class, 'sendAbsentSMS'])->name('admin.attendance.absent.sms');
    Route::post('/admin/attendance/send-absent-sms', [AdminController::class, 'sendAbsentSMS'])->name('admin.attendance.sendAbsentSMS');
    // Route::post('/admin/attendance/absent/sms', [AttendanceController::class, 'sendSms'])->name('admin.attendance.absent.sms');
    // Route::get('/test', [AttendanceController::class, 'testMethod']);
    Route::get('/admin/followup', [AdminController::class, 'followupReplies'])->name('admin.followup.index');
    Route::post('/admin/followup/{id}/send', [AdminController::class, 'sendFollowUp'])->name('admin.followup.send');
    Route::middleware('web')->post('/webhook/twilio', [AdminController::class, 'storeReply']);

    Route::post('/webhook/twilio', [AdminController::class, 'storeReply']);


    Route::post('/admin/attendance/sms', [AttendanceController::class, 'sendSms'])->name('attendance.sms');

    Route::post('/admin/attendance/sms', [AdminController::class, 'sendSms'])->name('admin.attendance.sms');

    Route::post('/admin/attendance/absent/sms', [AttendanceController::class, 'sendSms'])->name('admin.attendance.absent.sms');

    Route::get('/admin/attendance/absent/{serviceId}', [AttendanceController::class, 'showAbsentMembers'])->name('admin.absent.members.for.service');


    // routes/web.php


    Route::post('/sms-receive', [SMSWebhookController::class, 'receiveSMS']);

    Route::get('/admin/send-welcome-message/{id}', [AdminController::class, 'sendWelcomeMessage'])->name('admin.send-welcome-message');
    Route::get('/admin/new-members', [AdminController::class, 'newMembers'])->name('admin.new-members');


    Route::get('/dboard', [MemberDashboardController::class, 'index'])->name('memberArea.dboard');
    Route::get('/video/{id}', [MemberDashboardController::class, 'watchVideo'])->name('memberArea.video.watch');

    Route::get('/memberArea/video', [MemberDashboardController::class, 'index'])->name('memberArea.video.index');
    Route::post('/memberArea/inquiry', [InquiryController::class, 'submit'])->name('memberArea.inquiry.submit');

    Route::get('/memberArea/dboard', [MemberDashboardController::class, 'memberAreadboard'])->name('memberArea.dboard');

    // Route::post('/admin/send-inspiration', [InspirationalMessageController::class, 'send'])->name('admin.send-inspiration');

    Route::get('/admin/inquiries', [AdminController::class, 'showInquiries'])->name('admin.inquiries');
    Route::post('/admin/reply-inquiry/{id}', [AdminController::class, 'replyInquiry'])->name('admin.replyInquiry');
    // Route::post('/admin/inquiries/reply/{id}', [AdminController::class, 'replyInquiry'])->name('admin.reply-inquiry');
    // Route::get('/memberArea/dboard', [MemberDashboardController::class, 'memberAreadboard'])->middleware('auth');
    Route::get('/memberArea/dboard', [MemberDashboardController::class, 'memberDashboard'])->middleware('auth');
    // Route::post('/send-inspiration', [InspirationalMessageController::class, 'send'])->name('admin.send-inspiration');

    Route::get('/admin/get-latest-inspiration', [InspirationalMessageController::class, 'getLatestInspiration'])->name('admin.get-latest-inspiration');


    Route::post('/send-inspiration', [InspirationalMessageController::class, 'send'])->name('admin.send-inspiration');
    Route::get('/admin/inspirational-messages', [InspirationalMessageController::class, 'index'])->name('admin.inspirational_messages');



});





