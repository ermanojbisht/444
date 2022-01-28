<?php

Route::group(['prefix' => 'track/instanceEstimate', 'as' => 'instance.estimate.', 'namespace' => 'Track', 'middleware' => ['auth']], function () {
    Route::get('{instance_estimate}/adddocument', 'InstanceEstimateDocController@addDocument')->name('addDoc');
    Route::post('savedocument', 'InstanceEstimateDocController@saveDocument')->name('storeDocInTnstanceEstimate');
    Route::get('doclist', 'InstanceEstimateDocController@doclist')->name('doclist-2');
    Route::get('{instance_estimate}/doclist', 'InstanceEstimateDocController@doclist')->name('doclist-1');
    Route::get('{instance_estimate}/doclist/{doctypeid}', 'InstanceEstimateDocController@doclist')->name('doclist');
    Route::post('searchDoc', 'InstanceEstimateDocController@searchDoc')->name('searchDoc');
    Route::get('publishdocument/{docid}/{isactive}', 'InstanceEstimateDocController@publishToggle')->name('publishdocument');
});
