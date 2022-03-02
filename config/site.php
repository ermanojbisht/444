<?php

use App\Helpers\Helper;

return [    
    'defaultPass' => '123456',
    'backdate' => [
        'physicalprogress' => [
            'calculate_in' => 2, // 1= diffInHours, 2 = diffInDays, 3 = diffInMonths
            'allowedno' => 60, //number as per calculate_in
        ],
        'financialprogress' => [
            'calculate_in' => 2, // 1= diffInHours, 2 = diffInDays, 3 = diffInMonths
            'allowedno' => 60, //number as per calculate_in
        ],
        'physicalprogressedit' => [
            'calculate_in' => 1, // 1= diffInHours, 2 = diffInDays, 3 = diffInMonths
            'allowedno' => 24, //number as per calculate_in
        ],    
       
        'hrGrievance' => ['calculate_in' => 2, 'allowedno' => 2, ],

    ],  

    'officeType' => [ //todo same in mispwd
        'CE' => ['id' => 'CE', 'model' => 'App\CeOffice', 'name' => 'CE'],
        'SE' => ['id' => 'SE', 'model' => 'App\SeOffice', 'name' => 'SE'],
        'EE' => ['id' => 'EE', 'model' => 'App\EeOffice', 'name' => 'EE'],
    ],

    'officeTypeOnNo'=>[
        0=>'Head Office',
        1=>'Zone',
        2=>'Circle',
        3=>'Division',
    ],
    'userJobAllotmentMenu' => [ //todo same in mispwd
        '1' => ['id' => '1', 'name' => 'Offices'],
    ], 

    'isRegistrationOpen' => env('IS_REGISTRATION_OPEN', false),
    'misFilePath' => env('PUBLIC_PATH_OF_MIS_SITE', '/var/www/html/pwd'),
    'app_url_mis' => env('APP_URL_OF_MIS_SITE', 'https://mis.pwduk.in/pwd'),
    'app_url' => env('APP_URL', 'https://mis.pwduk.in/misentry'),
    'app_url_local' => env('APP_URL_LOCAL', 'http://localhost/misentry'),
    'missite_base_address_local' => env('MIS_SITE_BASE_ADD_lOCAL','http://localhost/pwd'),
    'imsite_base_address_local' => env('IM_SITE_BASE_ADD_lOCAL','http://localhost/im'),
    'imsite_base_address' => 'http://mis.pwduk.in/im',
    'dmsSiteBaseAddress' => 'http://mis.pwduk.in/dms',
    'missite_workdetail_address' => 'workDetail',  

    'yesNo' => ['No','Yes' ],

];
