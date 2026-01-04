<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TranslationJobController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->name('verification.verify')
        ->middleware(['signed', 'throttle:6,1']);

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send')
        ->middleware('throttle:6,1');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', [TranslationJobController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::resource('clients', ClientController::class);
Route::resource('translation-jobs', TranslationJobController::class);

// Chart routes
Route::get('/charts', [ChartController::class, 'index'])->name('chart')->middleware('auth');
Route::get('/api/charts/monthly-invoices', [ChartController::class, 'monthlyInvoices'])->name('api.charts.monthly')->middleware('auth');
Route::get('/api/charts/yearly-total', [ChartController::class, 'yearlyTotal'])->name('api.charts.yearly')->middleware('auth');
Route::get('/api/charts/top-clients', [ChartController::class, 'topClients'])->name('api.charts.clients')->middleware('auth');

// Invoice routes with custom preview and PDF generation
Route::get('invoices/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
// Route::get('invoices/pdf-preview', [InvoiceController::class, 'pdfPreview'])->name('invoices.pdfPreview');
Route::get('/invoice-preview/{id}', function ($id) {
    $invoice = Invoice::with('translationJobs')->findOrFail($id);
    return view('invoices.preview', compact('invoice'));
});
Route::post('invoices/generate-pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.generatePdf');
Route::resource('invoices', InvoiceController::class);
