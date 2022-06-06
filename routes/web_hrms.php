<?php

use Illuminate\Support\Facades\Route;
// EmployeeController

Route::group(['as' => 'employee.'], function () {

  
    Route::get('create', 'Hrms\EmployeeController@create')->name('create');
  
    Route::post('store', 'Hrms\EmployeeController@store')->name('store');
 

    Route::post('ajaxDataForOffice', 'Hrms\Hrms@ajaxDataForOffice')->name('ajaxDataForOffice'); //todo detach it for base use
});

   
// End Employee Controller