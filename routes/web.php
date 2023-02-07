<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SoundController;
use App\Http\Controllers\TalkController;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/welcome', 'welcome')->name('welcome');

Route::any('/', [TalkController::class, 'index'])->name('home');
Route::get('/talks/{talk}', [TalkController::class, 'show'])->name('talk.show');
Route::view('/introduction', [SectionController::class, 'introduction'])->name('introduction');
Route::view('/mode-demploi', [SectionController::class, 'mode-demploi'])->name('mode-demploi');
Route::view('/mode-demploifr', [SectionController::class, 'mode-demploifr'])->name('mode-demploifr');
Route::view('/contact', [SectionController::class, 'contact'])->name('contact');
Route::view('/about', [SectionController::class, 'about'])->name('about');

Route::get('login', function () {
    return redirect(route(
        auth()->user()
        ? 'filament.pages.dashboard'
        : 'filament.auth.login'
    ));
})->name('login');

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function (): void {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function (): void {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');

    Route::resource('sound', SoundController::class);
});
