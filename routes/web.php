<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\patient_registration_app;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('layouts/index');
    })->name('login');
});
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('auth.staff');

Route::middleware('auth')->group(function(){
    Route::get('/sign-out', [LogoutController::class, 'perform'])->name('logout');

    Route::post('/new-patient', [patient_registration_app::class, 'registerPatients'])->name('new.patient');
    Route::post('/vital-submit', [patient_registration_app::class, 'VitalForm'])->name('new.vital');
    Route::post('/form-save', [patient_registration_app::class, 'VitalFormSection'])->name('new.formSave');
    
    Route::get('/patients/vital', function () {
        return view('layouts/patientsRegistration/vital_details');
    });
    Route::get('/patients/book-visit/{id}', function (Request $req) {
        return redirect('/patients/vital')->with('patient_id', $req->id);
    })->name('new.visit');
    Route::get('/patients/vital/form/section-a', function () {
        return view('layouts/patientsRegistration/vitalSections/formA');
    });
    Route::get('/patients/vital/form/section-b', function () {
        return view('layouts/patientsRegistration/vitalSections/formB');
    });
    Route::get('/patients/new', function () {
        return view('layouts/patientsRegistration/registration');
    })->name('newPatient');
    Route::get('/cancel-vital-form/{patient_id}', [patient_registration_app::class, 'CancelVital'])->name('cancel.vital');
    Route::get('/back/{patient_id}', [patient_registration_app::class, 'SectionBackWithData'])->name('back.vital');
    Route::get('/patients/visits', [patient_registration_app::class, 'GetVisits'])->name('get.visits');
    Route::get('/patients/all', [patient_registration_app::class,'GetPatients'])->name('get.patients');
    Route::get('/patients/list', function () {
        return view('layouts/index');
    });
});