<?php

use App\Http\Controllers\Admin\UsersController; 
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('changeLang');

Route::get('acrs/{employee}', 'Employee\Acr\AcrReportsController@show')->name('employee.acr.view')
    ->missing(fn ($request) => response()->view('errors.employee_not_found'));

Route::get('officeacrs', 'Employee\Acr\AcrReportsController@officeAcrs')->name('office.acrs.view');
Route::get('difficulties', 'Employee\Acr\AcrReportsController@difficulties')->name('office.acrs.difficulties');
Route::get('employeesWithoutAcr/{office_id}/{year}', 'Employee\Acr\AcrReportsController@officeEmployeeListWithoutAcr')->name('office.employeesWithoutAcr.list');
Route::post('/filter',FilterController::class)->name('filter');

//-----------------------------------------------------------------------------------------------------------------------------
//Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'Employee\HomeController@dashboard')->name('employee.home');
    Route::get('/home', function(){ return redirect()->route('employee.home'); });
    Route::post('employeeBasicData', 'Employee\HomeController@employeeBasicData')->name('employee.basicData');
});


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

    //token UserTokenController
    Route::get('/createToken/{user}', 'UserTokenController@create')->name('token.create');
    Route::post('/storeToken', 'UserTokenController@store')->name('token.store');
    Route::get('/destroyToken/{user}', 'UserTokenController@destroy')->name('token.destroy');

});


Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
    if (file_exists(app_path('Http/Controllers/Auth/ChangeEmailController.php'))) {
        Route::get('email', 'ChangeEmailController@edit')->name('email.edit');
        Route::post('email', 'ChangeEmailController@update')->name('email.update');
    }
});

Route::Post('dynamicdependent', 'Ajax\AjaxFetchDropDownController@index')->name('dynamicdependent');


//

Route::get('/temp', 'TempController@temp1');
Route::get('/temp1', 'Employee\Acr\MonitorAcrController@countEsclation');
Route::get('/temp2', 'Employee\Acr\MonitorAcrController@identify');

//telegram
Route::get('/telegram/connect', 'TelegramBotController@connect')->name('telegram.connect');
Route::get('/telegram/callback', 'TelegramBotController@callback')->name('telegram.callback');
Route::get('/telegram/telegramLogged', 'TelegramBotController@telegramLogged')->name('telegram.telegramLogged');

//consume api experimental
Route::prefix('consume')->group(function () {
    Route::get('apiwithoutkey', [UsersController::class, 'updateUserFromEmployee'])->name('apiWithoutKey');
    Route::get('apiwithkey', [UsersController::class, 'updateUserFromEmployee'])->name('apiWithKey');
});


// Start : Hrms new laravel system routes  // todo:: also tried web_hrms need to remove or refactor later 
Route::group(['as' => 'employee.'], function () {

    Route::get('employee/index', 'Hrms\HrmsEmployeeController@index')->name('index');

    Route::get('employee/create', 'Hrms\HrmsEmployeeController@create')->name('create');
    Route::post('store', 'Hrms\HrmsEmployeeController@store')->name('store');
    
    Route::get('employee/edit/{employee}', 'Hrms\HrmsEmployeeController@edit')->name('edit');
    Route::post('employee/update', 'Hrms\HrmsEmployeeController@update')->name('update');
    
    Route::post('employee/lockEmployee/{employee}/{lock_level}', 'Hrms\HrmsEmployeeController@lockEmployee')
    ->name('lockEmployee');


    Route::post('ajaxDataForOffice', 'Hrms\Hrms@ajaxDataForOffice')->name('ajaxDataForOffice'); //todo detach it for base use

    Route::get('office/employees/index', 'Hrms\UpdateEmployeeController@index')->name('office.index');
    Route::get('office/employees/view/{employee}', 'Hrms\UpdateEmployeeController@view')->name('office.view');
    



});


// End : Hrms new laravel system routes 


