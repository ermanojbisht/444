<?php

return [

   'appraisalOfficerType'=>[
      1=>'Reporting',
      2=>'Reviewing',
      3=>'Accepting'
   ],

   'acrProcessFields'=>[
      1=>'report_employee_id',
      2=>'review_employee_id',
      3=>'accept_employee_id'
   ],

   'duty'=>[
      'submit'=>['field'=>'employee_id','period'=>30,'triggerOn'=>''],
      'report'=>['field'=>'report_employee_id','period'=>30,'triggerOn'=>'submit','triggerDate'=>'submitted_at'],
      'review'=>['field'=>'review_employee_id','period'=>30,'triggerOn'=>'report','triggerDate'=>'report_on'],
      'accept'=>['field'=>'accept_employee_id','period'=>30,'triggerOn'=>'review','triggerDate'=>'review_on'],
      //triggerOn accept ?  now target is submit beacause it's just back to user
      'reject'=>['field'=>'employee_id','period'=>30,'triggerOn'=>'reject','triggerDate'=>'reject_on'],
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
      0,30
   ] ,




];
