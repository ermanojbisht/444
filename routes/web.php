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
Route::group(['prefix' => '', 'as' => 'employee.', 'namespace' => 'Employee'],function(){

    Route::group(['middleware' => ['auth','verified']], function () {

    });
});
//employee system routes-------------------------------



//  ACR

Route::get('create/{acr}', 'TempController@create');
Route::post('store', 'TempController@store')->name('temp.store');
Route::post('store2', 'TempController@store2')->name('temp.store2');
Route::post('store5', 'TempController@store2')->name('temp.store5');

//Route::post('/assignOfficeAndJob', 'UsersController@assignOfficeAndJob');



Route::get('view', 'Employee\Acr\AcrController@index')->name('myacr.list');
Route::get('create', 'Employee\Acr\AcrController@create')->name('acr.create');


//  ACR


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

Route::group(['prefix' => '', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','verified']], function () {
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
    Route::get('/fetchAOffices/{officeType}', 'UsersController@fetchAOffices');
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
