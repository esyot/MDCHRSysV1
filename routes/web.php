<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\LeaveFormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonalDetailController;
use App\Http\Controllers\TravelFormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDepartmentController;
use App\Http\Controllers\UserRoleController;
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
        Route::get('/forms/travel-form-preview', [TravelFormController::class, 'preview']);

        //userlist
        Route::get('/users/user-list/{id}/evaluation-form', [UserController::class, 'userEvaluation'])->name('user.evaluation');
        Route::get('/users/user-list/{id}', [UserController::class, 'userView'])->name('user.view');
        Route::get('/users/user-list', [UserController::class, 'users'])->name('user.list');

        Route::post('/users/user-add', [UserController::class, 'userAdd'])->name('user.add');


        // Leave Forms
        Route::post('/leave-form-submit', [LeaveFormController::class, 'submit'])->name('forms.leave-form-submit');

        Route::get('/forms/tracking', [FormsController::class, 'index'])->name('forms.tracking');

        Route::get('/leave-form-preview', [LeaveFormController::class, 'preview'])->name('forms.leave-form-preview');


        Route::get('/forms/checking', [FormsController::class, 'checking']);
        Route::get('/forms/checking/{action}', [FormsController::class, 'checking']);

        Route::post('/forms/checking/forward', [FormsController::class, 'forward']);

        Route::get('/forms/find/{form_type}/{user_id}/{year}', [FormsController::class, 'find']);

        Route::get('/departments', [DepartmentController::class, 'index']);

        Route::delete('/form/delete/{type}/{id}', [FormsController::class, 'delete']);

        Route::post('/departments/department-add', [DepartmentController::class,'create']);

        Route::get('/departments/department-delete/{id}', [DepartmentController::class, 'delete']);

        Route::post('/users/{id}/role-edit', [UserRoleController::class, 'userUpdateRole']);
        Route::post('/users/{id}/department-edit', [UserDepartmentController::class, 'userUpdateDepartment']);
   
   
        Route::get('/users/analytics/', [AnalyticsController::class, 'index']);

        Route::get('/about', [AboutController::class, 'index']);

        Route::get('/account/personal-data-sheet/{action}', [PersonalDetailController::class, 'preview']);

        Route::post('/users/{id}/evaluation-submit/', [EvaluationController::class, 'create']);

    });
    });

    Route::get('/personal-data-sheet', function(){
        return view('forms.personalDataSheet');
    });

    Route::get('/personal-data-sheet2', function(){
        return view('forms.page2');
    });

    Route::get('/personal-data-sheet3', function(){
        return view('forms.page3');
    });

    Route::get('/personal-data-sheet4', function(){
        return view('forms.page4');
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

