  <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\OrderOfWorshipController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SmsReplyController;
use App\Http\Controllers\SMSWebhookController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MemberAttendanceController;
use App\Http\Controllers\InspirationalMessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SermonController;
use App\Http\Controllers\FollowupController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;


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

// Hero Section management routes for admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/hero-section', [HeroSectionController::class, 'index'])->name('admin.hero-section.index');
    Route::post('/hero-section', [HeroSectionController::class, 'update'])->name('admin.hero-section.update');
});

// Home route
// Route::get('/', function () {
//     return view('home');
// })->middleware('auth');
Route::get('/', [WelcomeController::class, 'index'])->middleware('auth');
Route::get('/donate', [DonationController::class, 'create'])->name('donate');



use App\Http\Controllers\ContactController;

// Contact page routes

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');




 // Admin Contacts Routes

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function() {

    Route::resource('contacts', AdminContactController::class)->names([

        'index' => 'contacts.index',

        'create' => 'contacts.create',

        'store' => 'contacts.store',

        'show' => 'contacts.show',

        'edit' => 'contacts.edit',

        'update' => 'contacts.update',

        'destroy' => 'contacts.destroy'

    ]);

});

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);

// use App\Http\Controllers\SermonController;

// Admin routes with auth and admin middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/sermons', [SermonController::class, 'index'])->name('admin.sermons.index');
    Route::get('/followup', [FollowupController::class, 'index'])->name('admin.followup.index');
    Route::get('/admin/inspirational-messages', [InspirationalMessageController::class, 'index'])->name('admin.inspirational_messages.index');

    // Correct route for sending SMS/WhatsApp messages via AdminController
    Route::post('/admin/attendance/send-sms', [AdminController::class, 'sendSms'])->name('admin.attendance.sms');

    Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials');


    // Reporting & Analytics routes
    Route::get('/admin/reports/attendance-trends', [AdminController::class, 'attendanceTrends'])->name('admin.reports.attendance-trends');
    Route::get('/admin/reports/demographics', [AdminController::class, 'demographicReports'])->name('admin.reports.demographics');
    Route::get('/admin/reports/growth-metrics', [AdminController::class, 'growthMetrics'])->name('admin.reports.growth-metrics');
    Route::get('/admin/reports/export', [AdminController::class, 'exportReport'])->name('admin.reports.export');

    // Order of Worship management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('order_of_worship', OrderOfWorshipController::class);
        Route::resource('sermons', SermonController::class);

        // Follow-up management routes
        Route::resource('followup', App\Http\Controllers\FollowupController::class);
        Route::post('followup/send/{id}', [App\Http\Controllers\FollowupController::class, 'send'])->name('followup.send');
    });
    Route::resource('admin/order_of_worship', OrderOfWorshipController::class)->names('admin.order_of_worship');

    // Event management routes
    Route::prefix('admin/events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('admin.events.index');
        Route::get('/create', [EventController::class, 'create'])->name('admin.events.create');
        Route::post('/', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

        Route::put('/{event}', [EventController::class, 'update'])->name('admin.events.update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    });

    // Donation routes
    Route::resource('donations', DonationController::class)->except(['show']);
    Route::get('/donations/{donation}', [DonationController::class, 'show'])
        ->name('donations.show')
        ->middleware(['auth', 'admin']);
    Route::get('donations/weekly-report', [DonationController::class, 'weeklyReport'])->name('admin.donations.weekly-report');
    Route::get('donations/monthly-report', [DonationController::class, 'monthlyReport'])->name('admin.donations.monthly-report');

    // Member management routes
    Route::get('members', [AdminController::class, 'members'])->name('admin.members');
    Route::get('members/create', [AdminController::class, 'createMember'])->name('admin.members.create');
    Route::post('members', [AdminController::class, 'storeMember'])->name('admin.members.store');
    Route::get('members/{member}/edit', [AdminController::class, 'editMember'])->name('admin.members.edit');
    Route::put('members/{member}', [AdminController::class, 'updateMember'])->name('admin.members.update');
    Route::delete('members/{member}', [AdminController::class, 'deleteMember'])->name('admin.members.delete');
    Route::get('admin/members', [AdminController::class, 'index'])->name('admin.members.index');
    Route::get('/admin/send-welcome-message/{id}', [AdminController::class, 'sendWelcomeMessage'])->name('admin.send-welcome-message');
    Route::get('/admin/new-members', [AdminController::class, 'newMembers'])->name('admin.new-members');

    // Attendance routes

    Route::get('attendance', [AdminController::class, 'recordAttendance'])->name('admin.attendance.list');
    Route::post('save-attendance', [AdminController::class, 'saveAttendance'])->name('admin.save.attendance');
    Route::post('send-sms-to-absent', [AdminController::class, 'sendSMStoAbsentMembers'])->name('admin.send.sms.to.absent');
    Route::post('send-custom-follow-up', [AdminController::class, 'sendCustomFollowUpMessage'])->name('admin.send.custom.follow.up');
    Route::post('attendance/{serviceId}', [AdminController::class, 'saveAttendanceForService'])->name('admin.save.attendance.for.service');
    Route::get('/admin/absent-members/{serviceId}', [AdminController::class, 'getAbsentMembersForService'])->name('admin.absent.members.for.service');
    Route::post('/admin/attendance', [AdminController::class, 'storeAttendance'])->name('admin.attendance.store');
    Route::get('/admin/attendance', [AdminController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/absent', [AdminController::class, 'absentMembers'])->name('admin.attendance.absent');
    Route::post('/admin/attendance/send-absent-sms', [AdminController::class, 'sendAbsentSMS'])->name('admin.attendance.sendAbsentSMS');
    Route::post('/admin/attendance/absent/sms', [AttendanceController::class, 'sendSms'])->name('admin.attendance.absent.sms');
    Route::get('/admin/attendance/absent/{serviceId}', [AttendanceController::class, 'showAbsentMembers'])->name('admin.absent.members.for.service');
    Route::get('/admin/absent-members/weekly-report', [AttendanceController::class, 'generateWeeklyReport'])->name('admin.absent-members.weekly-report');
    Route::get('/admin/absent-members/monthly-report', [AttendanceController::class, 'generateMonthlyReport'])->name('admin.absent-members.monthly-report');
    Route::get('/admin/attendance/report', [AttendanceController::class, 'generateReport'])->name('admin.attendance.report');
    Route::post('/admin/record-attendance', [AdminController::class, 'recordAttendance']);

    // Inquiry routes
    Route::get('/admin/inquiries', [AdminController::class, 'showInquiries'])->name('admin.inquiries');
    Route::post('/admin/reply-inquiry/{id}', [AdminController::class, 'replyInquiry'])->name('admin.replyInquiry');
    Route::post('/admin/inquiries/{inquiry}/reply', [InquiryController::class, 'storeReply'])->name('admin.replyInquiry');
    Route::delete('/admin/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('admin.deleteInquiry');

    // Inspirational messages
    Route::post('/send-inspiration', [InspirationalMessageController::class, 'send'])->name('admin.send-inspiration');
    Route::get('/admin/inspirational-messages', [InspirationalMessageController::class, 'index'])->name('admin.inspirational_messages');
});

// Usher routes protected by usher middleware
Route::middleware(['auth', 'usher'])->group(function () {
    Route::get('/usher/dashboard', [App\Http\Controllers\UsherCollectionController::class, 'dashboard'])->name('usher.dashboard');
});

use App\Http\Controllers\SuperadminDashboardController;

// Superadmin routes protected by superadmin middleware
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // Money report route accessible only to superadmin
    Route::get('/superadmin/money-report', [App\Http\Controllers\AdminController::class, 'moneyReport'])->name('superadmin.money-report');

    // Usher collections Excel export
    Route::get('/superadmin/usher-collections/export', [App\Http\Controllers\SuperadminDashboardController::class, 'exportExcel'])->name('superadmin.usher-collections.export');
});

// Upcoming events JSON endpoint
Route::get('events/upcoming', [EventController::class, 'upcoming'])->name('admin.events.upcoming');



Route::middleware(['auth'])->group(function () {
    Route::get('/dboard', [MemberDashboardController::class, 'memberDashboard'])->name('memberArea.dboard');
    Route::get('/video/{id}', [MemberDashboardController::class, 'watchVideo'])->name('memberArea.video.watch');
    Route::get('/memberArea/video', [MemberDashboardController::class, 'index'])->name('memberArea.video.index');
    Route::post('/memberArea/inquiry', [InquiryController::class, 'submit'])->name('memberArea.inquiry.submit');

    // New route for member attendance marking
    Route::post('/member/attendance', [MemberAttendanceController::class, 'markAttendance'])->name('member.attendance.mark');
});

Route::get('/sermons/{id}', [SermonController::class, 'publicShow'])->name('sermons.show');

// Authentication routes
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

// Other routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/collections', function () {
    return view('collections');
});

// SMS webhook
Route::post('/webhook/twilio', [AdminController::class, 'storeReply']);
Route::middleware('web')->post('/webhook/twilio', [AdminController::class, 'storeReply']);
Route::post('/sms-receive', [SMSWebhookController::class, 'receiveSMS']);

// Notification route
Route::get('/send-sms/{phone}/{message}', [NotificationController::class, 'sendSMS']);

// Donation report routes (accessible without admin middleware)
Route::get('/donations/weekly-report', [DonationController::class, 'weeklyReport'])->name('donations.weekly-report');
Route::get('/donations/monthly-report', [DonationController::class, 'monthlyReport'])->name('donations.monthly-report');



// Public blog routes
// Route::get('/blog', [App\Http\Controllers\PostController::class, 'index'])->name('blog.index');
// Route::get('/blog/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('blog.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

Route::resource('posts', App\Http\Controllers\PostController::class);

Route::middleware(['auth', 'admin'])->prefix('admin/blog')->name('admin.blog.')->group(function () {
    Route::get('/', [AdminBlogController::class, 'index'])->name('index');
    Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
    Route::post('/', [AdminBlogController::class, 'store'])->name('store');
    Route::get('/{blog}/edit', [AdminBlogController::class, 'edit'])->name('edit');
    Route::put('/{blog}', [AdminBlogController::class, 'update'])->name('update');
    Route::delete('/{blog}', [AdminBlogController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin/about')->name('admin.about.')->group(function () {
    Route::get('/edit', [App\Http\Controllers\Admin\AboutUsController::class, 'edit'])->name('edit');
    Route::put('/update', [App\Http\Controllers\Admin\AboutUsController::class, 'update'])->name('update');
});

Route::get('/about', [App\Http\Controllers\Admin\AboutUsController::class, 'show'])->name('about.show');
