<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\RecoverAccountController;
use App\Http\Controllers\Web\Admin\HomeController;
use App\Http\Controllers\Web\Admin\ProfileController;
use App\Http\Controllers\Web\Admin\NewAdminController;
use App\Http\Controllers\Web\Admin\ConfigController;

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

Route::get('/', function() {
    return redirect()->route('sign-in');
});
Route::prefix('admin')->group(function () {
    Route::get('/sign-in', [AuthController::class, 'showViewSignIn'])->name('sign-in');
    Route::prefix('auth')->group(function () {
        Route::post('/sign-in', [AuthController::class, 'signIn'])->name('auth.sign-in');
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::get('/profile', [ProfileController::class, 'showViewProfile'])->name('profile');
        Route::get('/profile/activity', [ProfileController::class, 'showViewActivity'])->name('activity');
        Route::get('/profile/config', [ConfigController::class, 'showViewConfig'])->name('config');
        Route::post('/profile/config/update-profile-photo', [ConfigController::class, 'updateProfilePhoto'])->name('update.profile.photo');
        Route::post('/profile/config/update-personal-contact-data', [ConfigController::class, 'updatePersonalContactData'])->name('update.personal.contact.data');
        Route::post('/profile/config/update-password', [ConfigController::class, 'updatePassword'])->name('update.password');
        Route::get('/auth/sign-out', [AuthController::class, 'signOut'])->name('auth.sign-out');
        Route::get('/new-admin', [NewAdminController::class, 'showViewNewAdmin'])->name('new.admin');
        Route::post('/create-admin', [NewAdminController::class, 'createNewAdmin'])->name('create.admin');
    });
    Route::get('/forgot-password', [RecoverAccountController::class, 'showViewForgotPassword'])->name('for');
});
