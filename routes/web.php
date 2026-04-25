<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\MemberClubController;
use App\Http\Controllers\AdminClubMemberController;
use App\Http\Controllers\MemberEventController;
use App\Http\Controllers\MemberHomeController;
use App\Http\Controllers\MemberNotificationController;

Route::get('/', [\App\Http\Controllers\LandingPageController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'check.status'])->group(function () {
    Route::get('/member/home', [MemberHomeController::class, 'index'])->name('member.home');

    Route::get('/member/clubs', [MemberClubController::class, 'index'])->name('member.clubs.index');
    Route::post('/member/clubs/{id}/join', [MemberClubController::class, 'join'])->name('member.clubs.join');
    Route::post('/member/clubs/{id}/leave', [MemberClubController::class, 'leave'])->name('member.clubs.leave');

    Route::get('/member/my-clubs', [MemberClubController::class, 'myClubs'])->name('member.myclubs.index');

    Route::get('/member/events', [MemberEventController::class, 'index'])->name('member.events.index');
    Route::post('/member/events/{id}/register', [MemberEventController::class, 'register'])->name('member.events.register');

    Route::get('/member/notifications', [MemberNotificationController::class, 'index'])->name('member.notifications.index');
    Route::post('/member/notifications/mark-all-read', [MemberNotificationController::class, 'markAllAsRead'])->name('member.notifications.markAllRead');
    Route::get('/member/notifications/{id}/read', [MemberNotificationController::class, 'markAsRead'])->name('member.notifications.read');

    Route::get('/member/profile', [\App\Http\Controllers\MemberProfileController::class, 'index'])->name('member.profile.index');
    Route::post('/member/profile/update', [\App\Http\Controllers\MemberProfileController::class, 'update'])->name('member.profile.update');

    Route::middleware('check.leader')->group(function () {
        Route::get('/leader/dashboard', [\App\Http\Controllers\LeaderHomeController::class, 'index'])->name('leader.home');
        
        Route::get('/leader/clubs/create', [\App\Http\Controllers\LeaderClubController::class, 'create'])->name('leader.clubs.create');
        Route::post('/leader/clubs/store', [\App\Http\Controllers\LeaderClubController::class, 'store'])->name('leader.clubs.store');
        Route::get('/leader/clubs/{id}/manage', [\App\Http\Controllers\LeaderClubController::class, 'manage'])->name('leader.clubs.manage');
        
        // Events Management for Leader (New CRUD)
        Route::get('/leader/members', [\App\Http\Controllers\LeaderClubController::class, 'membersIndex'])->name('leader.members.index');
        Route::get('/leader/events', [\App\Http\Controllers\LeaderClubController::class, 'eventsIndex'])->name('leader.events.index');
        Route::get('/leader/events/{id}/participants', [\App\Http\Controllers\LeaderClubController::class, 'eventParticipants'])->name('leader.events.participants');
        Route::post('/leader/events/store', [\App\Http\Controllers\LeaderClubController::class, 'storeEvent'])->name('leader.events.store');
        Route::post('/leader/events/{id}/update', [\App\Http\Controllers\LeaderClubController::class, 'updateEvent'])->name('leader.events.update');
        Route::post('/leader/events/{id}/delete', [\App\Http\Controllers\LeaderClubController::class, 'deleteEvent'])->name('leader.events.delete');
        
        Route::get('/leader/club-info', [\App\Http\Controllers\LeaderClubController::class, 'infoIndex'])->name('leader.clubs.info');
        Route::post('/leader/club-info/{id}/update', [\App\Http\Controllers\LeaderClubController::class, 'update'])->name('leader.clubs.update');
        
        Route::post('/leader/club-members/{id}/approve', [\App\Http\Controllers\LeaderClubController::class, 'approveMember'])->name('leader.club.members.approve');
        Route::post('/leader/club-members/{id}/reject', [\App\Http\Controllers\LeaderClubController::class, 'rejectMember'])->name('leader.club.members.reject');
        Route::post('/leader/club-members/{id}/remove', [\App\Http\Controllers\LeaderClubController::class, 'removeMember'])->name('leader.club.members.remove');
        
        Route::get('/leader/profile', [\App\Http\Controllers\LeaderProfileController::class, 'index'])->name('leader.profile.index');
        Route::post('/leader/profile/update', [\App\Http\Controllers\LeaderProfileController::class, 'update'])->name('leader.profile.update');
    });

    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->middleware('check.admin')->name('admin.dashboard');

    Route::middleware('check.admin')->group(function () {
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::post('/admin/users/{id}/delete', [UserController::class, 'destroy'])->name('admin.users.delete');

        Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
        Route::post('/admin/events/store', [EventController::class, 'store'])->name('admin.events.store');
        Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
        Route::post('/admin/events/{id}/update', [EventController::class, 'update'])->name('admin.events.update');
        Route::post('/admin/events/{id}/delete', [EventController::class, 'destroy'])->name('admin.events.delete');

        Route::get('/admin/clubs', [ClubController::class, 'index'])->name('admin.clubs.index');
        Route::post('/admin/clubs/store', [ClubController::class, 'store'])->name('admin.clubs.store');
        Route::get('/admin/clubs/{id}/edit', [ClubController::class, 'edit'])->name('admin.clubs.edit');
        Route::post('/admin/clubs/{id}/update', [ClubController::class, 'update'])->name('admin.clubs.update');
        Route::post('/admin/clubs/{id}/delete', [ClubController::class, 'destroy'])->name('admin.clubs.delete');
        Route::get('/admin/clubs/{id}/show', [ClubController::class, 'show'])->name('admin.clubs.show');
        Route::post('/admin/clubs/{id}/approve', [ClubController::class, 'approve'])->name('admin.clubs.approve');
        Route::post('/admin/clubs/{id}/reject', [ClubController::class, 'reject'])->name('admin.clubs.reject');

        Route::get('/admin/club-members', [AdminClubMemberController::class, 'index'])->name('admin.club.members');

        // Admin Profile
        Route::get('/admin/profile', [\App\Http\Controllers\AdminProfileController::class, 'index'])->name('admin.profile.index');
        Route::post('/admin/profile/update', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profile.update');
    });
});