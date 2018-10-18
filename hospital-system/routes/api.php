<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('patients')->group(function () {
    Route::get('/','DashboardController@getPatients');
    Route::post('/create','DashboardController@createPatient');
    Route::get('/{id}','DashboardController@getPatientDetail');
    Route::get('/{id}/history','DashboardController@getPatientMedicalHistory');
    Route::get('/{id}/record','DashboardController@getPatientMedicalRecord');
    Route::get('/{id}/payment','DashboardController@getPatientPaymentRecord');
});

Route::prefix('history')->group(function () {
    Route::get('/items','DashboardController@getMedicalHistoryItem');
    Route::post('/create','DashboardController@createMedicalHistory');
});

Route::prefix('departments')->group(function () {
    Route::get('/','DashboardController@getDepartmentsList');
    Route::get('/{id}/doctors', 'DashboardController@getDoctorsListByDepartmentId');
});

Route::prefix('outpatient')->group(function () {
    Route::get('/','DashboardController@getOutpatientsList');
    Route::post('/create','DashboardController@createOutpatient');
    Route::post('/diagnose','DashboardController@updateOutpatientDiagnosis');
    Route::get('/{id}/patient','DashboardController@getPatientDetailByOutpatientId');
    Route::get('/{id}/diagnostic','DashboardController@getPatientDiagnostic');
});

Route::prefix('treatments')->group(function () {
    Route::get('/','DashboardController@getTreatmentsList');
    Route::get('/{id}','DashboardController@getTreatmentListByPatientId');
});

Route::prefix('inpatient')->group(function () {
    Route::get('/','DashboardController@getInpatientList');
    Route::get('/rooms','DashboardController@getAvailableRooms');
    Route::post('/create','DashboardController@createInpatient');
    Route::post('/treatment/create','DashboardController@createMedicalTreatment');
    Route::post('/checkin','DashboardController@checkIn');
    Route::post('/checkout','DashboardController@checkOut');
    Route::get('/{id}','DashboardController@getInpatientListByPatientId');
});

Route::prefix('payments')->group(function () {
    // Route::get('/','DashboardController@getTreatmentsList');
    // Route::get('/{id}','DashboardController@getTreatmentListByPatientId');
});
