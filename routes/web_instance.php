<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']],function(){
 
// Grievance

// GrievanceController
Route::get('grievance','App\Http\Controllers\Track\Grievance\GrievanceController@index')->name('grievance');

Route::get('grievance/create','App\Http\Controllers\Track\Grievance\GrievanceController@create')->name('grievance.create');
Route::post('ajaxDataForOffice','App\Http\Controllers\Track\Grievance\GrievanceController@ajaxDataForOffice')->name('ajaxDataForOffice');

Route::get('/dashboard',function(){
    return view('track.estimate.estimate-dashboard');
} );

} );