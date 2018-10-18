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

Route::prefix('hospitals')->group(function () {
  Route::get('/','DashboardController@getHospitalList');
  Route::post('/create','DashboardController@createHospital');
});

Route::prefix('claimables')->group(function () {
  Route::get('/','DashboardController@getClaimableList');
  Route::post('/create','DashboardController@createClaimable');
});

Route::prefix('insurances')->group(function () {
  Route::get('/','DashboardController@getInsurancePolicyList');
  Route::post('/create','DashboardController@createInsurancePolicy');
  Route::get('/{id}','DashboardController@getInsuranceDetail');
});

Route::prefix('claims')->group(function () {
  Route::get('/','DashboardController@getClaimRequestList');
  Route::post('/create','DashboardController@createClaimRequest');
  Route::get('/notifications/system','DashboardController@getSystemClaimNotificationList');
  Route::post('/notifications/app','DashboardController@getAppClaimNotificationList');
  Route::get('/{id}','DashboardController@getClaimRequestDetailById');
  Route::post('/{id}/reject','DashboardController@rejectClaimRequestById');
  Route::post('/{id}/approve','DashboardController@approveClaimRequestById');
});

Route::post('authenticate','UserController@authenticate');
Route::group(['middleware' => ['jwt.verify']], function() {
  Route::get('user', 'UserController@getAuthenticatedUser');
  Route::prefix('user')->group(function () {
    Route::get('/','UserController@getAuthenticatedUser');
    Route::get('/insurances','DashboardController@getUserInsurancePolicyList');
    Route::get('/claims','DashboardController@getUserClaimRequestList');
  });
});
