<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\LeaveFormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonalDetailController;
use App\Http\Controllers\TravelFormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\Check2WayVerification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-submit', [LoginController::class, 'login'])->name('login-submit');



Route::middleware([Check2WayVerification::class])->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/account', [AccountController::class, 'index'])->name('account');
    
        Route::post('/personal-details-update-submit', [PersonalDetailController::class, 'updatePersonalDetails']);
    
        Route::get('/forms/travel-form-request', [TravelFormController::class, 'index'])->name('forms.travel-form');
        Route::get('/forms/leave-form-request', [LeaveFormController::class, 'index']);
    
        Route::post('/upload-cropped-profile-pic', [UserController::class, 'updateProfilePicture']);
    
    
        Route::get('/success-session-remove', function(){
            session()->forget('success');
            return redirect()->back();
        });
        Route::post('/authentication-check', [AuthController::class, 'auth']);
    
        Route::post('/user-account-setting-update', [UserController::class, 'update']);

        Route::post('/user-account-feature-update', [AccountController::class,'accountFeatureUpdate']);

        Route::post('/forms/travel-form-submit', [TravelFormController::class, 'submit']);

        Route::get('/forms/leave-form-preview', [LeaveFormController::class, 'preview']);

        Route::get('/forms/travel-form-preview', [TravelFormController::class, 'preview']);

        Route::get('/forms/tracking', [FormsController::class, 'index']);
        
    });
    }); 

Route::post('/authentication-check', [AuthController::class, 'auth']);

Route::post('/verification-submit', [VerificationController::class, 'verify']);


Route::get('/verification', [VerificationController::class, 'index'])->name('verification');

Route::get('/logout', function () {
    Auth::logout();
    Session::put('authenticate', false);
    Session::put('code', null);
    return redirect()->route('login');
});


Route::get('/forms/evaluation-form', function(){

    return inertia('Pages/Forms/Evaluation/Evaluation');
});

