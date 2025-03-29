<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\LeaveFormController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PersonalDetailController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TravelFormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\Check2WayVerification;
use App\Http\Middleware\CheckIsActive;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\CheckIsDefaultPassword;

Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-submit', [LoginController::class, 'login'])->name('login-submit');
Route::get('/verification', [VerificationController::class, 'index'])->name('verification');
Route::post('/verification-submit', [VerificationController::class, 'verify']);
Route::post('/authentication-check', [AuthController::class, 'auth']);
Route::get('/unauthorized', function () {
    return inertia('Pages/Others/Unauthorized');
})->name('unauthorized');

Route::middleware([Check2WayVerification::class])->group(function () {

    Route::middleware('auth')->group(function () {

        Route::get('/account', [AccountController::class, 'index'])->name('account');
        Route::put('/user-account-setting-update', [UserController::class, 'update']);
        Route::post('/user-account-feature-update', [AccountController::class, 'accountFeatureUpdate']);
        Route::post('/personal-details-update-submit', [PersonalDetailController::class, 'updatePersonalDetails']);
        Route::post('/upload-cropped-profile-pic', [UserController::class, 'updateProfilePicture']);
        Route::get('/account/personal-data-sheet/{action}', [PersonalDetailController::class, 'preview']);

        Route::middleware([CheckIsDefaultPassword::class, CheckIsActive::class])->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/forms/travel-form-request', [TravelFormController::class, 'index'])->name('forms.travel-form');
            Route::get('/forms/leave-form-request', [LeaveFormController::class, 'index']);
            Route::post('/forms/travel-form-submit', [TravelFormController::class, 'submit']);
            Route::get('/forms/travel-form-preview', [TravelFormController::class, 'preview']);
            Route::post('/leave-form-submit', [LeaveFormController::class, 'submit'])->name('forms.leave-form-submit');
            Route::get('/leave-form-preview', [LeaveFormController::class, 'preview'])->name('forms.leave-form-preview');
            Route::get('/forms/tracking', [FormsController::class, 'index'])->name('forms.tracking');
            Route::get('/forms/evaluation-form/{type}/{id}', [EvaluationController::class, 'evaluate']);
            Route::get('/forms/edit-mode/{id}/{type}', [FormsController::class, 'editMode']);

            Route::middleware([CheckUserRole::class . ':dean,hr,v-admin,vp-acad,p-admin,admin'])->group(function () {
                Route::get('/forms/checking', [FormsController::class, 'checking']);
                Route::get('/forms/checking/{action}', [FormsController::class, 'checking']);
                Route::put('/forms/checking/forward', [FormsController::class, 'forward']);
                Route::get('/forms/find/{form_type}/{user_id}/{year}', [FormsController::class, 'find']);
            });

            Route::delete('/form/delete/{type}/{id}', [FormsController::class, 'delete']);

            Route::put('/evaluations/template/update-item', [EvaluationController::class, 'updateTemplateItem']);
            Route::delete('/evaluations/template/delete-item/{id}', [EvaluationController::class, 'deletTemplateItem']);

            Route::middleware(CheckUserRole::class . ':dean')->group(function () {
                Route::post('/evaluations/evaluation-submit', [EvaluationController::class, 'submitEvaluation']);
            });

            Route::get('/evaluations/evaluate/{type}/{user_id}', [EvaluationController::class, 'evaluateUser']);

            Route::middleware(CheckUserRole::class . ':teacher')->group(function () {
                Route::get('/teachers/search/{search_value}', [TeacherController::class, 'search']);
            });


            Route::middleware(CheckUserRole::class . ':admin')->group(function () {
                Route::get('/users/search/', [StaffController::class, 'search']);
                Route::get('/users/user-list/{id}/evaluation-form', [UserController::class, 'userEvaluation'])->name('user.evaluation');
                Route::get('/users/user-list/{id}/{is_evaluation}', action: [UserController::class, 'userView'])->name('user.view');
                Route::post('/users/{id}/role-edit', [UserRoleController::class, 'userUpdateRole']);
                Route::get('/users/users-list', [UserController::class, 'users']);
                Route::post('/users/{type}/add', [UserController::class, 'userAdd']);
                Route::get('/users/sync/{type}', [UserController::class, 'syncUsers']);

                Route::patch('/users/user-department-update', [UserController::class, 'updateUserDepartment']);

                Route::get('/departments', [DepartmentController::class, 'index']);
                Route::get('/departments/sync', [DepartmentController::class, 'syncDepartments']);

                Route::get('/users/analytics/', [AnalyticsController::class, 'index']);

                Route::put('/users/teacher/edit-details', [UserController::class, "teacherUpdate"]);
                Route::put('/users/staff/edit-details', [UserController::class, 'staffUpdate']);
                Route::put('/users/user/edit-details', [UserController::class, 'userUpdate']);
            });

            Route::get('/evaluations/evaluation-manager', [EvaluationController::class, 'evaluationManager']);
            Route::get('/evaluations/evaluation-manager/{id}', [EvaluationController::class, 'evaluationManager']);
            Route::get('/evaluations/evaluation-manager/sample', [EvaluationController::class, 'view']);
            Route::post('/evaluations/add-new-template', [EvaluationController::class, 'createTemplate']);
            Route::post('/evaluations/copy-old-template/', [EvaluationController::class, 'createTemplate']);
            Route::delete('/evaluations/template-delete/{id}', [EvaluationController::class, 'deleteTemplate']);
            Route::post('/evaluations/template/add-category', [EvaluationController::class, 'addCategory']);
            Route::post('/evaluations/template/add-item', [EvaluationController::class, 'addItem']);
            Route::get('/evaluations/template-toggle/{id}/{type}', [EvaluationController::class, 'toggleEvaluationTemplate']);
            Route::get('/evaluations/{type}', [EvaluationController::class, 'userList']);
            Route::get('/evaluations/user-view/{id}', [EvaluationController::class, 'userView'])->name('evaluations.user-view');

            Route::get('/forms/evaluation-form/{id}/teacher', [EvaluationController::class, 'evaluate']);

            Route::get('/about', [AboutController::class, 'index']);

        });

        Route::get('/notifications/{id}', [NotificationController::class, 'fetch']);
        Route::get('/notifications/read/{id}/{type}', [NotificationController::class, 'read']);
        Route::get('/notifications/delete/{id}/{type}', [NotificationController::class, 'delete']);


        Route::get('/api/hr/subject-classes', [ApiController::class, 'subjectClasses']);
    });


});


Route::get('/logout', function () {
    Auth::logout();
    Session::put('authenticate', false);
    Session::put('code', null);
    return redirect()->route('logout');
});

Route::get('/success-session-remove', function () {
    session()->forget('success');
    return redirect()->route('login');
})->name('logout');

