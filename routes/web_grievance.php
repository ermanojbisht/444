<?php

use Illuminate\Support\Facades\Route;
// GrievanceController

Route::group(['as' => 'employee.'], function () {

    Route::get('hr_grievance', 'HrGrievance\GrievanceController@index')->name('hr_grievance');

    Route::get('hr_grievance/create', 'HrGrievance\GrievanceController@create')->name('hr_grievance.create');
    Route::post('store', 'HrGrievance\GrievanceController@store')->name('hr_grievance.store');

    Route::get('hr_grievance/edit/{hr_grievance}', 'HrGrievance\GrievanceController@edit')->name('hr_grievance.edit');
    Route::post('update', 'HrGrievance\GrievanceController@update')->name('hr_grievance.update');

    Route::get('hr_grievance/{hr_grievance}', 'HrGrievance\GrievanceController@show')->name('hr_grievance.show');

    Route::post('submit', 'HrGrievance\GrievanceController@submit')->name('hr_grievance.submit');
    Route::post('reopen', 'HrGrievance\GrievanceController@reopen')->name('hr_grievance.reopen');

    Route::post('ajaxDataForOffice', 'HrGrievance\GrievanceController@ajaxDataForOffice')->name('ajaxDataForOffice'); //todo detach it for base use
    
    Route::post('ajaxForGrievanceResolver', 'HrGrievance\GrievanceController@ajaxForGrievanceResolver')
    ->name('ajaxForGrievanceResolver');

});

//ResolveGrievanceController

Route::get('HrGrievance/Index', 'OthersHrGrievance\ResolveGrievanceController@index')->name('resolve_hr_grievance');

Route::group(['prefix' => 'resolve'], function () {
    Route::get('HrGrievance/{hr_grievance}/Show', 'OthersHrGrievance\ResolveGrievanceController@show')->name('View.hrGrievance');

    Route::get('{hr_grievance}/HrGrievance', 'OthersHrGrievance\ResolveGrievanceController@resolveGrievance')->name('view_hr_grievance');

    Route::get('HrGrievance/{hr_grievance}/addDraft', 'OthersHrGrievance\ResolveGrievanceController@addDraft')->name('hr_grievance.resolve.addDraft');
    Route::post('HrGrievance/updateDraft', 'OthersHrGrievance\ResolveGrievanceController@updateGrievance')->name('hr_grievance.updateGrievance');

    Route::get('HrGrievance/{hr_grievance}/Final', 'OthersHrGrievance\ResolveGrievanceController@addFinalAnswer')->name('hr_grievance.resolve.final');
    Route::post('HrGrievance/Final', 'OthersHrGrievance\ResolveGrievanceController@resolveFinalGrievance')->name('hr_grievance.resolveGrievance');

    Route::post('HrGrievance/Revert', 'OthersHrGrievance\ResolveGrievanceController@revertGrievance')
        ->name('hr_grievance.revertGrievance');

    Route::get('hr_grievances', 'OthersHrGrievance\ResolveGrievanceController@officeHrGrievances')
        ->name('office_hr_grievances');
});


//ResolveGrievanceController

 

// End Grievance