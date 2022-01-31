<?php

use App\Helpers\Helper;

return [
    'in_progress' => 'not implemented may ask admin',
    'workListCriteria' => 'running',
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
        'financialprogressedit' => ['calculate_in' => 2, 'allowedno' => 60],
        'bond' => ['calculate_in' => 3,'allowedno' => 60  ],
        'bondedit' => ['calculate_in' => 2, 'allowedno' => 30],
        'bondProgress' => ['calculate_in' => 2,'allowedno' => 600  ],
        'bondProgressEdit' => ['calculate_in' => 2,'allowedno' => 2  ],
        'bondExpenditure' => ['calculate_in' => 2,'allowedno' => 600  ],
        'bondExpenditureEdit' => ['calculate_in' => 2,'allowedno' => 2  ],
        'bondTarget' => ['calculate_in' => 2,'allowedno' => 600  ],
        'bondTargetEdit' => ['calculate_in' => 2,'allowedno' => 2  ],
        'docUploadInWorks' => ['calculate_in' => 2, 'allowedno' => 7, ],
        'contractorEdit' => ['calculate_in' => 2, 'allowedno' => 7, ],
        'estimateEdit' => ['calculate_in' => 2, 'allowedno' => 7, ],
        'hrGrievance' => ['calculate_in' => 2, 'allowedno' => 2, ],

    ],
    'workDetails' => [
        'date_field_to_match' => 'created_at', //database table field to be match for backdate checking.
        'default' => [
            'calculate_in' => 2, // 1= diffInHours, 2 = diffInDays, 3 = diffInMonths
            'alloweno' => 7,
        ],
        'fields' => [
            'work_type_id' => ['calculate_in' => 2, 'allowedno' => 7],
            'yozana_id' => ['calculate_in' => 2, 'allowedno' => 7],
            'S_LO' => ['calculate_in' => 2, 'allowedno' => 7],
            'S_B_NO' => ['calculate_in' => 2, 'allowedno' => 7],
            'B_SO' => ['calculate_in' => 2, 'allowedno' => 7],
            'SCOST' => ['calculate_in' => 2, 'allowedno' => 7],
            'AA' => ['calculate_in' => 2, 'allowedno' => 7],
            'AA_DATE' => ['calculate_in' => 2, 'allowedno' => 7],
            'Villagetoconnect' => ['calculate_in' => 2, 'allowedno' => 7],
            'sjob' => ['calculate_in' => 2, 'allowedno' => 7],
            'sbuild' => ['calculate_in' => 2, 'allowedno' => 7],

            'forest_case' => ['calculate_in' => 2, 'allowedno' => 30],

            'STYEAR' => ['calculate_in' => 3, 'allowedno' => 1000],
            'S_LC' => ['calculate_in' => 3, 'allowedno' => 1000],
            'S_B_NC' => ['calculate_in' => 3, 'allowedno' => 1000],
            'B_SOC' => ['calculate_in' => 3, 'allowedno' => 1000],
            'RSCOST' => ['calculate_in' => 3, 'allowedno' => 1000],
            'TCOST' => ['calculate_in' => 3, 'allowedno' => 1000],
            'rjob' => ['calculate_in' => 3, 'allowedno' => 1000],
            'rbuild' => ['calculate_in' => 3, 'allowedno' => 1000],
            'cm_announce' => ['calculate_in' => 3, 'allowedno' => 1000],
            'priority' => ['calculate_in' => 3, 'allowedno' => 1000],
            'worktaken' => ['calculate_in' => 3, 'allowedno' => 1000],

            'SYEAR' => ['calculate_in' => 2, 'allowedno' => 7],
            'LEX' => ['calculate_in' => 2, 'allowedno' => 7],

            'DEMAND' => ['calculate_in' => 2, 'allowedno' => 7],
            'ALOTMENT' => ['calculate_in' => 2, 'allowedno' => 7],
            'TC_DATE' => ['calculate_in' => 2, 'allowedno' => 7],
            'status_of_work_id' => ['calculate_in' => 2, 'allowedno' => 7],
            'atal_yozana' => ['calculate_in' => 2, 'allowedno' => 7],
            'remark' => ['calculate_in' => 2, 'allowedno' => 7],
            'Bottelneck' => ['calculate_in' => 3, 'allowedno' => 1000],

            'PERCENT' => ['calculate_in' => 2, 'allowedno' => 7],
        ],
    ],
    'targetachievementyears' => range(Helper::currentFyYear(), Helper::currentFyYear()),
    'tokenname' => 'im',


    'officeType' => [ //todo same in mispwd
        'CE' => ['id' => 'CE', 'model' => 'App\CeOffice', 'name' => 'CE'],
        'SE' => ['id' => 'SE', 'model' => 'App\SeOffice', 'name' => 'SE'],
        'EE' => ['id' => 'EE', 'model' => 'App\EeOffice', 'name' => 'EE'],
    ],
    'userJobAllotmentMenu' => [ //todo same in mispwd
        '1' => ['id' => '1', 'name' => 'Offices'],
    ],

    'forestTimeLineBaseUrl' => 'http://forestsclearance.nic.in/timeline.aspx?pid=',

    'isRegistrationOpen' => env('IS_REGISTRATION_OPEN', false),
    'misFilePath' => env('PUBLIC_PATH_OF_MIS_SITE', '/var/www/html/pwd'),
    'app_url_mis' => env('APP_URL_OF_MIS_SITE', 'https://mis.pwduk.in/pwd'),
    'app_url' => env('APP_URL', 'https://mis.pwduk.in/misentry'),
    'app_url_local' => env('APP_URL_LOCAL', 'http://localhost/misentry'),
    'missite_base_address_local' => env('MIS_SITE_BASE_ADD_lOCAL','http://localhost/pwd'),
    'imsite_base_address_local' => env('IM_SITE_BASE_ADD_lOCAL','http://localhost/im'),
    'imsite_base_address' => 'http://mis.pwduk.in/im',
    'missite_workdetail_address' => 'workDetail',

    'form9ModifiedHeader' => '<?xml version="1.0"?>
<data><@attributes><id>PwdImage2.0</id><version>20210417</version></@attributes>',
    'form9OrignalHeader' => '<?xml version=\'1.0\' ?><data id="PwdImage2.0" version="20210417" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:orx="http://openrosa.org/xforms" xmlns:ev="http://www.w3.org/2001/xml-events" xmlns:odk="http://www.opendatakit.org/xforms" xmlns:h="http://www.w3.org/1999/xhtml" xmlns:jr="http://openrosa.org/javarosa">',

];
