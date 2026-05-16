<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\AppearanceController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\LabelController;
//file xử lý auth
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

//pub
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/activate/{token}', [RegisterController::class, 'activate'])->name('auth.activate');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.store');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

//cần auth
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    //note
    Route::get('/dashboard', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{id}', [NoteController::class, 'show'])->name('notes.show');
    Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');

    //label
    Route::post('/labels', [LabelController::class, 'store'])->name('labels.store');
    Route::put('/labels/{id}', [LabelController::class, 'update'])->name('labels.update');
    Route::delete('/labels/{id}', [LabelController::class, 'destroy'])->name('labels.destroy');

    //profile
    Route::get('/profile', function () {
        return view('profile.index'); 
    })->name('profile.index');

    Route::put('/profile/appearance', [AppearanceController::class, 'update'])->name('appearance.update');
    Route::put('/profile/security', [SecurityController::class, 'update'])->name('security.update');
    Route::put('/profile/info', [UserInfoController::class, 'update'])->name('profile.info.update');
});