<?php
 

// Employe Document
// 'middleware' => ['auth']
Route::group(['prefix' => 'employee/hr_grievance', 'as' => 'employee.hr_grievance.', 
'namespace' => 'Employee\HrGrievance', ], function () {
    
    Route::get('{hr_grievance}/adddocument', 'GrievanceDocController@addDocument')->name('addDoc');
    Route::post('savedocument', 'GrievanceDocController@saveDocument')->name('storeDocInHrGrievance');
    
    Route::get('{hr_grievance}/doclist', 'GrievanceDocController@doclist')->name('doclist1');
    Route::get('{hr_grievance}/doclist/{is_question}', 'GrievanceDocController@doclist')->name('doclist');

    // Route::post('searchDoc', 'InstanceEstimateDocController@searchDoc')->name('searchDoc');
});
 