<?php
use Illuminate\Http\Request;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');
    Route::post('createUserFromEmployee', 'UsersApiController@createUserFromEmployee')->name('createUserFromEmployee');
    Route::get('userWithEmployeeCode/{employee_id}', 'UsersApiController@userWithEmployeeCode')->name('userWithEmployeeCode');

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Ce Offices
    Route::apiResource('ce-offices', 'CeOfficeApiController');

    // Se Offices
    Route::post('se-offices/media', 'SeOfficeApiController@storeMedia')->name('se-offices.storeMedia');
    Route::apiResource('se-offices', 'SeOfficeApiController');

    // Ee Offices
    Route::post('ee-offices/media', 'EeOfficeApiController@storeMedia')->name('ee-offices.storeMedia');
    Route::apiResource('ee-offices', 'EeOfficeApiController');
    Route::apiResource('employee', 'EmployeesApiController');
});


Route::post('login', '\App\Http\Controllers\Api\V1\Admin\UsersApiLoginController@login');

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware'=>['auth:api']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::post('education','Employee\EducationApiController@store')->name('education.store');
    Route::post('leave','Employee\LeaveApiController@store')->name('leave.store');
   // Route::get('work/{work}','WorkApiController@show')->name('work.show');

});
