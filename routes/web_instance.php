<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']],function(){
//InstanceController
Route::get('instance/create','App\Http\Controllers\Track\InstanceController@create')->name('instance.create');
Route::post('instance','App\Http\Controllers\Track\InstanceController@store')->name('instance.store');
Route::get('myInstances','App\Http\Controllers\Track\InstanceController@index')->name('myInstances');
Route::get('instance/{instance}/destroy','App\Http\Controllers\Track\InstanceController@destroy')->name('instance.destroy');


//EstimateController
Route::get('/','App\Http\Controllers\Track\EstimateController@index')->name('index');
Route::get('estimate/create/{id}','App\Http\Controllers\Track\EstimateController@create')->name('estimate.create');
Route::post('store','App\Http\Controllers\Track\EstimateController@store')->name('estimate.store');
Route::get('instanceEstimate/{instance_estimate}','App\Http\Controllers\Track\EstimateController@show')->name('track.estimate.view');
Route::get('receivedInstances','App\Http\Controllers\Track\EstimateController@receivedInstances')->name('receivedInstances');
Route::get('sentEstimateInstances','App\Http\Controllers\Track\EstimateController@sentEstimateInstances')->name('sentEstimateInstances');
Route::post('getEmployeeDesignationWise','App\Http\Controllers\Track\EstimateController@getEmployeeDesignationWise')->name('getEmployeeDesignationWise');
Route::post('getBlocksInDistrict', 'App\Http\Controllers\Track\EstimateController@getBlocksInDistrict')->name('getBlocksInDistrict');
Route::post('getLoksabhaByconstituency', 'App\Http\Controllers\Track\EstimateController@getLoksabhaByconstituency')->name('getLoksabhaByconstituency');
Route::post('getConstituenciesInDistrict', 'App\Http\Controllers\Track\EstimateController@getConstituenciesInDistrict')->name('getConstituenciesInDistrict');
Route::get('movement/{instanceId}/{senderId}','App\Http\Controllers\Track\EstimateController@moveEstimates')->name('movement');
Route::post('storeEstimateMovements','App\Http\Controllers\Track\EstimateController@storeEstimateMovements')->name('storeEstimateMovements');
Route::get('edit_estimate_status/{instanceId}','App\Http\Controllers\Track\EstimateController@editEstimateStatus')->name('editEstimateStatus');
Route::post('updateEstimateStatus','App\Http\Controllers\Track\EstimateController@updateEstimateStatus')->name('updateEstimateStatus');
Route::post('move','App\Http\Controllers\Track\EstimateController@move')->name('move');
Route::post('ajaxDataForEstimateMovements', 'App\Http\Controllers\Track\EstimateController@ajaxDataForEstimateMovements')->name('estimate.ajaxDataForEstimateMovements');

// UpdateEstimateController
Route::get('estimate/edit/{estimateId}','App\Http\Controllers\Track\UpdateEstimateController@editEstimate')->name('estimate.edit');
Route::post('updateEstimate','App\Http\Controllers\Track\UpdateEstimateController@updateEstimate')->name('estimate.updateEstimate');

Route::get('estimate/editDetails/{instance_estimate}','App\Http\Controllers\Track\UpdateEstimateController@editEstimateDetails')->name('estimate.editDetails');
Route::post('estimate/updateDetails','App\Http\Controllers\Track\UpdateEstimateController@updateEstimateDetails')->name('estimate.updateEstimateDetails');

//InstanceReportController
Route::any('report', 'App\Http\Controllers\Track\InstanceReportController@index')->name('estimate.report');
Route::get('ajaxDataForEstimateReport', 'App\Http\Controllers\Track\InstanceReportController@ajaxDataForEstimateReport')->name('estimate.ajaxDataForEstimateReport');

Route::get('efc/{instance_estimate}', 'App\Http\Controllers\Track\EfcReportController@show')->name('efc.show');
Route::get('efc', 'App\Http\Controllers\Track\EfcReportController@index')->name('efc.index');

//estimateFeature
Route::resource('instanceEstimate.instanceEstimateFeature', 'App\Http\Controllers\Track\EstimateFeatureController')->except(['show']);
Route::resource('instanceEstimate.group', 'App\Http\Controllers\Track\EstimateGroupController')->except(['show']);

Route::get('estimate/{instance_estimate}/village','App\Http\Controllers\Track\EstimateVillageController@indexCreateEdit')->name('estimate.villages');
Route::post('estimate/attachvillage','App\Http\Controllers\Track\EstimateVillageController@store')->name('estimate.attachvillage');
Route::post('estimate/detachvillage/','App\Http\Controllers\Track\EstimateVillageController@destroy')->name('estimate.detachvillage');

Route::get('estimate/{instance_estimate}/ulb','App\Http\Controllers\Track\EstimateUlbController@indexCreateEdit')->name('estimate.ulbs');
Route::post('estimate/attachulb','App\Http\Controllers\Track\EstimateUlbController@store')->name('estimate.attachulb');
Route::post('estimate/detachulb','App\Http\Controllers\Track\EstimateUlbController@destroy')->name('estimate.detachulb');


// Grievance

// GrievanceController
Route::get('grievance','App\Http\Controllers\Track\Grievance\GrievanceController@index')->name('grievance');

Route::get('grievance/create','App\Http\Controllers\Track\Grievance\GrievanceController@create')->name('grievance.create');
Route::post('ajaxDataForOffice','App\Http\Controllers\Track\Grievance\GrievanceController@ajaxDataForOffice')->name('ajaxDataForOffice');

Route::get('/dashboard',function(){
    return view('track.estimate.estimate-dashboard');
} );

});
