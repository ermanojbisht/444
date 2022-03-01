<?php

return [

   'appraisalOfficerType'=>[
      1=>'Reporting',
      2=>'Reviewing',
      3=>'Accepting'
   ],

   'appraisalOfficerType2step'=>[
      1=>'Reporting',
      2=>'Reviewing',     
   ],

   'acrProcessFields'=>[
      1=>'report_employee_id',
      2=>'review_employee_id',
      3=>'accept_employee_id'
   ],


   'duty'=>[
      'submit'=>['period'=>90,'triggerOn'=>'','targetemployee'=>'employee_id'],
      'report'=>['period'=>30,'triggerOn'=>'submit','triggerDate'=>'submitted_at','targetemployee'=>'report_employee_id'],
      //what duty is to perform. report means acr is at submit level report is to be done . iska triggerOn submit hoga
      'review'=>['period'=>30,'triggerOn'=>'report','triggerDate'=>'report_on','targetemployee'=>'review_employee_id'],
      'accept'=>['period'=>30,'triggerOn'=>'review','triggerDate'=>'review_on','targetemployee'=>'accept_employee_id'],



      'reject'=>['period'=>30,'triggerOn'=>'reject','triggerDate'=>'submitted_at','targetemployee'=>'employee_id'],
      'correctnotice'=>['period'=>300,'triggerOn'=>'correct','triggerDate'=>'corrected_on','targetemployee'=>'employee_id'],
      //triggerDate might be anydate  [submitted_at,report_on, reviwed_on], field can be [report_employee_id,review_employee_id,accept_employee_id], triggerOn can be [submit,report,review]
      //sabhi case mai targetemployee hai jise msg karna hai
   ],

   'acrLeaveType'=>[
      1=>'Leave',
      2=>'Absence'
   ],

   'acrRejectionReason'=>[
      1=>'Wrong Period',
      2=>'Wrong Officer Selection',
      3=>'Wrong Targets'
   ] ,

   'acrWithoutProcess'=>[
      30,31
   ] ,




];
