<?php




return [

   'gender' => [
      0 => 'Unknown',
      1 => 'Male',
      2 => 'Female',
      3 => 'Transgender'
   ],

   'religion' => [
      0 => 'Unknown',
      1 => 'Hindu',
      2 => 'Muslim',
      3 => 'Sikh',
      4 => 'Christian',
      5 => 'Buddhists',
      6 => 'Jains'
   ],

   'married' => [
      0 => 'Unknown',
      1 => 'Married',
      2 => 'Single',
      3 => 'Widow',
      4 => 'Seperated',
      5 => 'Divorced'
   ],

   'bloodGroup' => [
      0 => 'Unknown',
      1 => 'O-',
      2 => 'O+',
      3 => 'A-',
      4 => 'A+',
      5 => 'B-',
      6 => 'B+',
      7 => 'AB-',
      8 => 'AB+'
   ],

   'cast' => [
      0 => 'Unknown',
      1 => 'General',
      2 => 'OBC',
      3 => 'SC',
      4 => 'ST'
   ],

   'disability' => [
      0 => 'Unknown',
      1 => 'None',  // default will be 1 in DB
      2 => 'Uttrakhand Dependent of Freedom Fighters',
      3 => 'Ex-Servicemen',
      4 => 'Women',
      5 => 'Physical Handicap',
      6 => 'Sports'
   ],

   'addressType' => [
      1 => 'Correspondence',
      2 => 'Permanent',
      3 => 'Home'
   ],

   'qualificationType' => [
      1 => 'Essential(Qualifying)',
      2 => 'Additional'
   ],

   'qualification' => [
      1 => 'Highschool',
      2 => 'Intermediate',
      3 => 'Diploma',
      4 => 'Graduation',
      5 => 'Post-Graduation'
   ],

   /* 1st to 7th are taken as they were in HRMS SQL => DB   */
   'relation' => [
      0 => 'Unknown',
      1 => 'Wife',
      2 => 'Son',
      3 => 'Daughter',
      4 => 'Father',
      5 => 'Mother',
      6 => 'Sister',
      7 => 'Husband',
      8 => 'Brother',
      9 => 'Other'
   ],

   'regular_incharge' => [
      1 => 'regular',  // Db Default  -> 1 
      2 => 'incharge'
   ],

   'appointmentType' => [
      0 => 'Unknown',
      1 => 'UKPSC',
      2 => 'UPNL',
      3 => 'UKSSSC',
      4 => 'UPSSSC',
      5 => 'UPPSC',
      6 => 'Adhoc'
   ],



   'leaveType' => [
      4   => 'Commuted leave',
      21  => 'Earned Leave',
      31  => 'Leave on Medical Certificate',
      32  => 'Extraordinary Leave',
      33  => 'Leave on Private Affairs',
      36  => 'Paternity Leave',
      37  => 'Hospital Leave',
      38  => 'Special casual Leave',
      39  => 'Special disability Leave',
      40  => 'Study Leave'
   ],



   'historyType' =>
   [
      1 => 'Transfer',
      2 => 'Attachment',
      3 => 'Promotion',
      4 => 'Promotion In Charge',
      5 => 'Demotion',
      6 => 'Deputation',
      7 => 'Rejoin after Deputation',
      8 => 'Suspension',
      9 => 'Rejoin after Suspension',
      10 => 'Retired',
      11 => 'Lean',
      12 => 'New Appointment'
   ],


   'DurgamSugamyear' => 2021,
];
