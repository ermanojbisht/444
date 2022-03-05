<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '', 'as' => 'acr.', 'middleware' => ['auth', 'verified']], function () {

    // AcrController

    Route::get('/', 'Acr\AcrController@index')->name('myacrs');
    Route::get('/create', 'Acr\AcrController@create')->name('create');
    Route::post('/store', 'Acr\AcrController@store')->name('store');

    Route::get('/edit/{acr}/acr', 'Acr\AcrController@edit')->name('edit');
    Route::post('/update/acr', 'Acr\AcrController@update')->name('update');


    Route::get('/edit/{acr}/alteredAcr', 'Acr\AlterAcrController@edit')->name('edit.alteredAcr');
    Route::post('/update/{acr}/alteredAcr', 'Acr\AlterAcrController@update')->name('update.alteredAcr');


    Route::get('/{acr}/view', 'Acr\AcrController@show')->name('view');
    Route::get('/{acr}/view/part1', 'Acr\AcrController@showPart1')->name('view.part1');

    Route::get('addOfficers/{acr}', 'Acr\AcrController@addOfficers')->name('addOfficers');
    Route::post('addAcrOfficers', 'Acr\AcrController@addAcrOfficers')->name('addAcrOfficers');

    Route::post('deleteAcrOfficers', 'Acr\AcrController@deleteAcrOfficers')->name('deleteAcrOfficers');

    Route::get('addLeaves/{acr}', 'Acr\AcrController@addLeaves')->name('addLeaves');
    Route::post('addAcrLeaves', 'Acr\AcrController@addAcrLeaves')->name('addAcrLeaves');
    Route::post('deleteAcrLeaves', 'Acr\AcrController@deleteAcrLeaves')->name('deleteAcrLeaves');

    Route::get('addAppreciation/{acr}', 'Acr\AcrController@addAppreciation')->name('addAppreciation');
    Route::post('addAcrAppreciation', 'Acr\AcrController@addAcrAppreciation')->name('addAcrAppreciation');
    Route::post('deleteAcrAppreciation', 'Acr\AcrController@deleteAcrAppreciation')->name('deleteAcrAppreciation');

    Route::post('submitAcr', 'Acr\AcrController@submitAcr')->name('submit');
    Route::post('destroy', 'Acr\AcrController@destroy')->name('destroy');

    Route::post('/getAcrTypefromAcrGroupId', 'Acr\AcrController@getAcrTypefromAcrGroupId')->name('getAcrType'); // Gives Acr Type object for drop down


    // Acr\AcrFormController

    Route::get('form/{acr}/part1', 'Acr\AcrFormController@create1')->name('form.create1'); //target/achivement
    Route::get('form/{acr}/part2', 'Acr\AcrFormController@create2')->name('form.create2'); //difficulty
    Route::get('form/{acr}/part3', 'Acr\AcrFormController@create3')->name('form.create3'); //deduction
    Route::get('form/{acr}/part4', 'Acr\AcrFormController@addTrainningToEmployee')->name('form.addTrainningToEmployee'); //training
    Route::get('form/{acr}/createSinglePageAcr', 'Acr\AcrFormController@createSinglePageAcr')->name('form.createSinglePageAcr'); //training

    Route::get('form/{acr}/show', 'Acr\AcrFormController@show')->name('form.show'); //training

    Route::post('form/store1', 'Acr\AcrFormController@store1')->name('form.store1');
    Route::post('form/store2', 'Acr\AcrFormController@store2')->name('form.store2');
    Route::post('form/store3', 'Acr\AcrFormController@store3')->name('form.store3');
    Route::post('form/storeTrainning', 'Acr\AcrFormController@storeTrainning')->name('form.storeTrainning');
    Route::post('form/storeSinglePageAcr', 'Acr\AcrFormController@storeSinglePageAcr')->name('form.storeSinglePageAcr');


    // Acr Reporting 
    Route::get('form/{acr}/appraisal1', 'OthersAcr\AcrReportController@appraisal1')->name('form.appraisal1');
    Route::post('form/appraisal1', 'OthersAcr\AcrReportController@storeAppraisal1')->name('form.storeAppraisal1');
    Route::post('form/storeAcrWithoutProcess', 'OthersAcr\AcrReportController@storeAcrWithoutProcess')->name('form.storeAcrWithoutProcess');

    Route::get('form/{acr}/appraisal/show', 'OthersAcr\AcrReportController@show')->name('form.appraisalShow');

    // Acr Review 
    Route::get('form/{acr}/appraisal2', 'OthersAcr\AcrReviewController@appraisal2')->name('form.appraisal2');
    Route::post('form/appraisal2', 'OthersAcr\AcrReviewController@storeAppraisal2')->name('form.storeAppraisal2');
    Route::post('form/storeAcrWithoutProcessReview', 'OthersAcr\AcrReviewController@storeAcrWithoutProcessReview')->name('form.storeAcrWithoutProcessReview');
  
    Route::get('getUserParameterData/{acrId}/{paramId}', 'OthersAcr\AcrReportController@getUserParameterData')->name('ajax.getUserParameterData');
    Route::get('getUserNegativeParameterData/{acrId}/{paramId}', 'OthersAcr\AcrReportController@getUserNegativeParameterData')->name('ajax.getUserNegativeParameterData');
});

Route::group(['prefix' => 'others', 'as' => 'acr.others.', 'middleware' => ['auth', 'verified']], function () {

    //AcrDefaulterController
    Route::get('/defaulters', 'OthersAcr\AcrDefaulterController@index')->name('defaulters');
    Route::get('/legacy/{office_id}', 'OthersAcr\AcrDefaulterController@legacyIndex')->name('legacy');
    Route::post('/store', 'OthersAcr\AcrDefaulterController@store')->name('store');
    Route::post('/legacystore', 'OthersAcr\AcrDefaulterController@legacystore')->name('legacystore');

    Route::get('/edit/{acr}/defaulters', 'OthersAcr\AcrDefaulterController@edit')->name('edit');
    Route::post('/update/acr', 'OthersAcr\AcrDefaulterController@update')->name('update');
    Route::post('/acknowledged', 'OthersAcr\AcrDefaulterController@acknowledged')->name('acknowledged');


    // AcrInboxController
    Route::get('/', 'OthersAcr\AcrInboxController@index')->name('index');


    Route::get('report/{acr}/submit', 'OthersAcr\AcrReportController@submitReported')->name('report.submit');
    Route::post('report', 'OthersAcr\AcrReportController@storeReportedAcr')->name('report.save');

    Route::post('review', 'OthersAcr\AcrReviewController@storeReviewedAcr')->name('review.save');

    Route::get('accept/{acr}/submit', 'OthersAcr\AcrAcceptController@submitAccepted')->name('accept.submit');
    Route::post('accpet', 'OthersAcr\AcrAcceptController@storeAcceptedAcr')->name('accept.save');


    //AcrIntegrityController
    Route::get('view/{acr}/integrity', 'OthersAcr\AcrIntegrityController@viewIntegrity')->name('acr.view.integrity');
    Route::get('view/{acr}/accepted', 'OthersAcr\AcrInboxController@viewAccepted')->name('acr.view.accepted');

    Route::get('{acr}/reject/{dutyType}', 'OthersAcr\AcrInboxController@reject')->name('reject');
    Route::post('/reject/acr', 'OthersAcr\AcrInboxController@storeReject')->name('storeReject');

});
