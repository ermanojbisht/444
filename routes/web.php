<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('changeLang');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'Employee\HomeController@dashboard')->name('employee.home');
    Route::post('employeeBasicData', 'Employee\HomeController@employeeBasicData')->name('employee.basicData');
});
//Auth::routes();
Auth::routes(['verify' => true]);

//employee system routes-------------------------
Route::group(['prefix' => '', 'as' => 'employee.', 'namespace' => 'Employee'], function () {

    Route::group(['middleware' => ['auth', 'verified']], function () {
    });
});
//employee system routes-------------------------------



//  ACR
//  ACR


// acr routes-------------------------  // 




Route::group(['prefix' => 'cr', 'as' => 'acr.', 'middleware' => ['auth']], function () {

    // AcrController

    Route::get('/', 'Employee\Acr\AcrController@index')->name('myacrs');
    Route::get('/create', 'Employee\Acr\AcrController@create')->name('create');
    Route::post('/store', 'Employee\Acr\AcrController@store')->name('store');

    Route::get('/edit/{acr}/acr', 'Employee\Acr\AcrController@edit')->name('edit');
    Route::post('/update/acr', 'Employee\Acr\AcrController@update')->name('update');


    Route::get('/{acr}/view', 'Employee\Acr\AcrController@show')->name('view');
    Route::get('/{acr}/view/part1', 'Employee\Acr\AcrController@showPart1')->name('view.part1');

    Route::get('addOfficers/{acr}', 'Employee\Acr\AcrController@addOfficers')->name('addOfficers');
    Route::post('addAcrOfficers', 'Employee\Acr\AcrController@addAcrOfficers')->name('addAcrOfficers');

    Route::post('deleteAcrOfficers', 'Employee\Acr\AcrController@deleteAcrOfficers')->name('deleteAcrOfficers');

 
    Route::get('addLeaves/{acr}', 'Employee\Acr\AcrController@addLeaves')->name('addLeaves');
    Route::post('addAcrLeaves', 'Employee\Acr\AcrController@addAcrLeaves')->name('addAcrLeaves');


    Route::post('submitAcr', 'Employee\Acr\AcrController@submitAcr')->name('submit');

    Route::post('/getAcrTypefromAcrGroupId', 'Employee\Acr\AcrController@getAcrTypefromAcrGroupId')->name('getAcrType'); // Gives Acr Type object for drop down


    // Employee\Acr\AcrFormController

    Route::get('form/{acr}/part1', 'Employee\Acr\AcrFormController@create1')->name('form.create1');
    Route::get('form/{acr}/part2', 'Employee\Acr\AcrFormController@create2')->name('form.create2');
    Route::get('form/{acr}/part3', 'Employee\Acr\AcrFormController@create3')->name('form.create3');
    Route::get('form/{acr}/part4', 'Employee\Acr\AcrFormController@create4')->name('form.create4');
    Route::get('form/{acr}/appraisal1', 'Employee\Acr\AcrFormController@appraisal1')->name('form.appraisal1');
    
    Route::post('form/store1', 'Employee\Acr\AcrFormController@store1')->name('form.store1');
    Route::post('form/store2', 'Employee\Acr\AcrFormController@store2')->name('form.store2');
    Route::post('form/store3', 'Employee\Acr\AcrFormController@store3')->name('form.store3');
    Route::post('form/store4', 'Employee\Acr\AcrFormController@store4')->name('form.store4');
    Route::post('form/appraisal1', 'Employee\Acr\AcrFormController@storeAppraisal1')->name('form.storeAppraisal1');

    Route::get('getUserParameterData/{acrId}/{paramId}', 'Employee\Acr\AcrFormController@getUserParameterData')->name('ajax.getUserParameterData');
    Route::get('getUserNegativeParameterData/{acrId}/{paramId}', 'Employee\Acr\AcrFormController@getUserNegativeParameterData')->name('ajax.getUserNegativeParameterData');
});


Route::group(['prefix' => 'cr/others', 'as' => 'acr.others.', 'middleware' => ['auth']], function () {

    // OtherAcrController
    Route::get('/', 'Employee\OthersAcr\OthersAcrController@index')->name('index');
});


// GrievanceController

//employee system routes-------------------------  // 
Route::group(['prefix' => 'employee', 'as' => 'employee.', 'middleware' => ['auth']], function () {

    Route::get('hr_grievance', 'Employee\HrGrievance\GrievanceController@index')->name('hr_grievance');

    Route::get('hr_grievance/create', 'Employee\HrGrievance\GrievanceController@create')->name('hr_grievance.create');
    Route::post('store', 'Employee\HrGrievance\GrievanceController@store')->name('hr_grievance.store');

    Route::get('hr_grievance/edit/{hr_grievance}', 'Employee\HrGrievance\GrievanceController@edit')->name('hr_grievance.edit');
    Route::post('update', 'Employee\HrGrievance\GrievanceController@update')->name('hr_grievance.update');

    Route::get('hr_grievance/{hr_grievance}', 'Employee\HrGrievance\GrievanceController@show')->name('hr_grievance.show');

    Route::post('ajaxDataForOffice', 'Employee\HrGrievance\GrievanceController@ajaxDataForOffice')->name('ajaxDataForOffice');




});



//employee system routes-------------------------------

//ResolveGrievanceController

Route::get('Resolve/HrGrievance', 'Employee\OthersHrGrievance\ResolveGrievanceController@index')->name('resolve_hr_grievance');
Route::get('Resolve/HrGrievance/{hr_grievance}/Show', 'Employee\OthersHrGrievance\ResolveGrievanceController@show')->name('office.View.hrGrievance');
Route::get('Resolve/HrGrievance/addDraft/{hr_grievance}', 'Employee\OthersHrGrievance\ResolveGrievanceController@addDraft')->name('office.resolve.hr_grievance.addDraftAnswer');
Route::post('addDraft', 'Employee\OthersHrGrievance\ResolveGrievanceController@updateGrievance')->name('officer.hr_grievance.updateGrievance');

Route::get('Resolve/hr_grievance/{hr_grievance}', 'Employee\OthersHrGrievance\ResolveGrievanceController@addFinalAnswer')->name('office.resolve.hr_grievance');


//ResolveGrievanceController




// End Grievance



Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');

// Admin

Route::group(['prefix' => '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified']], function () {
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('/assignUserOffices/{userid}', 'UsersController@assignUserOffices')->middleware('can:user_role_assignment')->name('assignUserOffices');
    Route::post('/assignOfficeAndJob', 'UsersController@assignOfficeAndJob');
    Route::post('/detachOffice', 'UsersController@detachOffice');
    Route::get('/fetchAOffices/{officeType}', 'UsersController@fetchAOffices');  // Gives Html to select multiple Office
    Route::get('/getOfficesfromOfficeType/{officeType}', 'UsersController@getOfficeListAsPerOfficeTypeId'); // Gives json object to select Office in drop down

    Route::get('/addTelegramPattern/{user}', 'UsersController@addTelegramPattern')->name('addTelegramPattern');
    Route::post('/storeWorkPatternForTelegram', 'UsersController@storeWorkPatternForTelegram')->name('storeWorkPatternForTelegram');

    // Ce Offices
    Route::delete('ce-offices/destroy', 'CeOfficeController@massDestroy')->name('ce-offices.massDestroy');
    Route::post('ce-offices/parse-csv-import', 'CeOfficeController@parseCsvImport')->name('ce-offices.parseCsvImport');
    Route::post('ce-offices/process-csv-import', 'CeOfficeController@processCsvImport')->name('ce-offices.processCsvImport');
    Route::resource('ce-offices', 'CeOfficeController');

    // Se Offices
    Route::delete('se-offices/destroy', 'SeOfficeController@massDestroy')->name('se-offices.massDestroy');
    Route::post('se-offices/media', 'SeOfficeController@storeMedia')->name('se-offices.storeMedia');
    Route::post('se-offices/ckmedia', 'SeOfficeController@storeCKEditorImages')->name('se-offices.storeCKEditorImages');
    Route::post('se-offices/parse-csv-import', 'SeOfficeController@parseCsvImport')->name('se-offices.parseCsvImport');
    Route::post('se-offices/process-csv-import', 'SeOfficeController@processCsvImport')->name('se-offices.processCsvImport');
    Route::resource('se-offices', 'SeOfficeController');
    // Ee Offices
    Route::delete('ee-offices/destroy', 'EeOfficeController@massDestroy')->name('ee-offices.massDestroy');
    Route::post('ee-offices/media', 'EeOfficeController@storeMedia')->name('ee-offices.storeMedia');
    Route::post('ee-offices/ckmedia', 'EeOfficeController@storeCKEditorImages')->name('ee-offices.storeCKEditorImages');
    Route::post('ee-offices/parse-csv-import', 'EeOfficeController@parseCsvImport')->name('ee-offices.parseCsvImport');
    Route::post('ee-offices/process-csv-import', 'EeOfficeController@processCsvImport')->name('ee-offices.processCsvImport');
    Route::resource('ee-offices', 'EeOfficeController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);


    // Office Jobs
    Route::resource('office-jobs', 'OfficeJobController');
    // Office Jobs defailt user
    Route::resource('office-job-defaults', 'OfficeJobDefaultController');
    Route::get('bulkUpdateOfficeHeadJob', 'OfficeJobDefaultController@bulkUpdateOfficeHeadJob')->name('bulkUpdateOfficeHeadJob');


    Route::get('getdistrictdetails/{districtid}/{dropdown}', 'AjaxController@districtDetail');
});
//task
Route::group(['prefix' => 'task', 'as' => 'task.', 'namespace' => 'MgtTask', 'middleware' => ['auth']], function () {
    Route::get('attach', 'ForestUserMgtCtrl@attachUser')->name('attach');
    Route::get('detach', 'ForestUserMgtCtrl@detachUser')->name('detach');
});


Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});

Route::Post('dynamicdependent', 'Ajax\AjaxFetchDropDownController@index')->name('dynamicdependent');


Route::get('client', function () {
    return view('temp');
});
//ae from HR employee table
Route::get('aefromhr', 'Admin\AeToWorkController@updateAeFromEmployee')->name('updateAeFromEmployee');
Route::get('syncuserFromRoadlue', 'MgtTask\UserMakingMgtController@syncuserFromRoadlue')->name('syncUser');
Route::get('addEmpCode', 'MgtTask\UserMakingMgtController@addEmpCode')->name('addEmpCode');


Route::get('/temp', 'TempController@temp');
