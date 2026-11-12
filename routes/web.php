<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MilestoneController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WorkProcessController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// 1. Public Portfolio Routes
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::post('/contact', [PortfolioController::class, 'submitContact'])->name('contact.submit');
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    if (request()->wantsJson()) {
        return response()->json(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

// 2. Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Admin Protected Dashboard Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile & Bio & Contact links
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Projects CRUD
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Experience CRUD
    Route::resource('experiences', ExperienceController::class)->except(['show']);

    // Education CRUD
    Route::resource('educations', EducationController::class)->except(['show']);

    // Skills
    Route::resource('skills', SkillController::class)->only(['index', 'store', 'update', 'destroy']);

    // Services (What I offer)
    Route::resource('services', ServiceController::class)->only(['index', 'store', 'update', 'destroy']);

    // Work Process (How I work)
    Route::resource('processes', WorkProcessController::class)->only(['index', 'store', 'update', 'destroy']);

    // Milestones (Proven Track Record)
    Route::resource('milestones', MilestoneController::class)->only(['index', 'store', 'update', 'destroy']);

    // Client Testimonials Management
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::patch('/testimonials/{testimonial}/toggle-approval', [TestimonialController::class, 'toggleApproval'])->name('testimonials.toggle-approval');
    Route::patch('/testimonials/{testimonial}/toggle-pin', [TestimonialController::class, 'togglePin'])->name('testimonials.toggle-pin');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Contact Messages Inbox
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::patch('/messages/{contactMessage}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');
    Route::delete('/messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
