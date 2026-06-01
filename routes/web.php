<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\BlogController as FrontBlogController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ReferenceController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Internal reference/training page (token-protected, not indexed)
Route::get('/ref/{token}', [ReferenceController::class, 'show'])->name('reference');

// Booking routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/validate-coupon', [BookingController::class, 'validateCoupon'])->name('booking.coupon');
Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter/subscribe', [\App\Http\Controllers\Frontend\ContactController::class, 'newsletter'])->name('newsletter.subscribe');

Route::get('/faq', function () {
    return view('frontend.pages.faq');
})->name('faq');

Route::get('/terms', function () {
    return view('frontend.pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('frontend.pages.privacy');
})->name('privacy');

Route::get('/blog-tool', [\App\Http\Controllers\Frontend\BlogController::class, 'designTool'])->name('blog.design-tool');
Route::post('/blog-tool/insert', [\App\Http\Controllers\Frontend\BlogController::class, 'insertFromTool'])->name('blog.insert-tool');
Route::get('/blog', [FrontBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category}', [FrontBlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'adminLogin']);
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'checkEmail'])->name('password.email');
Route::get('security-question', [AuthController::class, 'showSecurityQuestion'])->name('password.security-question');
Route::post('security-question', [AuthController::class, 'checkSecurityAnswer'])->name('password.check-answer');
Route::get('reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.redirect');
    Route::get('{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/account/security-question', [AuthController::class, 'showSecurityQuestionSetup'])->name('account.security-question');
    Route::post('/account/security-question', [AuthController::class, 'updateSecurityQuestion'])->name('account.security-question.update');
});

// Tracking endpoints (client-side analytics, no CSRF needed for sendBeacon)
Route::post('/api/track/fingerprint', [\App\Http\Controllers\Api\FingerprintController::class, 'store'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/api/track/behavior', [\App\Http\Controllers\Api\BehavioralController::class, 'store'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Optimized image endpoints
Route::get('/images/{path}', [\App\Http\Controllers\Frontend\OptimizedImageController::class, 'show'])->where('path', '.*')->name('image.optimized');
Route::get('/thumbnails/{path}', [\App\Http\Controllers\Frontend\OptimizedImageController::class, 'thumbnail'])->where('path', '.*');

// Serve storage files directly (avoid "storage" in URL - some hosts block it)
Route::get('/storage/{path}', [\App\Http\Controllers\Frontend\ServeStorageController::class, 'show'])->where('path', '.*');
Route::get('/files/{path}', [\App\Http\Controllers\Frontend\ServeStorageController::class, 'show'])->where('path', '.*');
