<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');
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


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

   // Route::get('work/{work}','WorkApiController@show')->name('work.show');

});
