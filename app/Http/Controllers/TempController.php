<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrBasic;
use App\Models\Acr\AcrNegativeParameter;
use App\Models\Acr\AcrParameter;
use App\Models\CeOffice;
use App\Models\Education;
use App\Models\EeOffice;
use App\Models\Employee;
use App\Models\Office;
use App\Models\SeOffice;
use App\Models\User;
use App\Traits\Acr\AcrPdfArrangeTrait;
use Illuminate\Http\Request;
use Log;

class TempController extends Controller
{
    use AcrPdfArrangeTrait;
    /**
     * @return mixed
     */
    public function temp()
    {
        // Configuration settings for the key
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key into $private_key
        openssl_pkey_export($res, $private_key);

        // Extract the public key into $public_key
        $public_key = openssl_pkey_get_details($res);
        $public_key = $public_key["key"];

        Log::info("public_key = ".print_r($public_key,true));

        // Something to encrypt
        $text = 'Manoj Bisht';

        echo "This is the original text: $text\n\n";

        // Encrypt using the public key
        openssl_public_encrypt($text, $encrypted, $public_key);

        $encrypted_hex = bin2hex($encrypted);
        echo "This is the encrypted text: $encrypted_hex\n\n";

        // Decrypt the data using the private key
        openssl_private_decrypt($encrypted, $decrypted, $private_key);

        echo "This is the decrypted text: $decrypted\n\n";
       


        
        Log::info("public_key = ".print_r($key,true));
        return ;


        return Education::first();
        $employees=Employee::whereOfficeIdd(0)->get()->take(5000);
        foreach ($employees as $key => $employee) {
            $employee->updateOfficeIdd();

        }

        return;

        $acr = Acr::findOrFail(32);

        return $acr->reportUser();

        return view('temp');

        return User::find(600)->canDoJobInOffice('office-head', 2001);

        return User::find(600)->OfficeToAnyJob(['cao', 'office-head']);

        (new CeOffice)->bulkUpdateHeadEmpAsUserInJobTable();
        (new EeOffice)->bulkUpdateHeadEmpAsUserInJobTable();
        (new SeOffice)->bulkUpdateHeadEmpAsUserInJobTable();

        Office::fixTree();

        return $root = Office::descendantsAndSelf(2001)->toTree()->first();

        return Office::descendantsAndSelf(2001)->toTree();
        $node = Office::find(2001);

        return $result = Office::whereDescendantOf(2001)->get();

        return Office::descendantsAndSelf(2001);
        $node->descendants->pluck('name', 'id');

        return $node->ancestors;

        return $node = Office::withDepth()->having('depth', '=', 2)->findOrFail(2001);

        return $node->descendantsOf()->get(); // OK

        return Office::get()->toTree();

        return Office::withDepth()->having('depth', '=', 2)->get();

        /*$employees=Employee::whereNotNull('password')->get()->take(5000);
        foreach ($employees as $key => $employee) {
        $birth_date=$employee->birth_date->format('ddmmyyyy');
        $password=Hash::make($birth_date);
        //Log::info("this = ".print_r($password,true));
        $employee->update(['password'=>$password]);
        }*/

        /*
        UPDATE `employees` INNER JOIN `users`
        ON employees.id=users.`emp_code`
        SET employees.`password`=users.`password`
        WHERE employees.`password` IS NOT NULL

        UPDATE `employees` INNER JOIN `users`
        ON employees.c_email=users.`email`
        SET employees.`password`=users.`password`
        WHERE employees.`password` IS NOT NULL*/

        $instanceEstimate = InstanceEstimate::find(2);

        return $instanceEstimate->lastAddedFeatureGroup();

        $alertprojects = AlertProject::all();
        foreach ($alertprojects as $key => $alertproject) {
            $contractor_details = $alertproject->contractor_details;
            $result = Helper::checkContractorNameAndPan($contractor_details);
            if ($result['status']) {
                $contractor = Contractor::where('pan', $result['string']['pan'])->first();
                if ($contractor) {
                    $gstn = $contractor->gstn;
                    $alertproject->gstn = $contractor->gstn;
                    $alertproject->save();
                }
            }
        }

        echo "start";
        $old_string = '/media/dell/New\\ Volume/CloudStation/devpy/test.py';
        $old_string = '/media/dell/datadrive/CloudStation/devpy/test.py ';
        $new_string = str_replace(" ", "\\ ", $old_string);
        $command = escapeshellcmd($new_string);

        return $output = shell_exec($command.' 2>&1');

        echo "d";

        echo $output;

        return;
        Actor::chunk(25, function ($chunk) {
            foreach ($chunk as $actor) {
                $employee = $actor->employee;
                $qrrequest = Qrrequest::where('emp_code', $actor->displayName)->first();
                if ($employee) {
                    if (!$qrrequest) {
                        Qrrequest::create([
                            'user_id' => 1710,
                            'emp_code' => $actor->displayName,
                            'request_type_id' => 1,
                            'status' => 1,
                            'created_at' => $actor->createdAt,
                            'updated_at' => $actor->updatedAt
                        ]);
                    } else {
                        $qrrequest->timestamps = false;
                        $qrrequest->status = 1;
                        $qrrequest->save();
                    }
                }
                $actor->updateAvialbleFormsNameToQrrequest();
            }
        });

        return 0;

        Bond::chunk(3, function ($chunk) {
            foreach ($chunk as $key => $bond) {
                $bond->updateStage();
            }
        });

        return 0;

        $nabardWorks = NabardWorkDetail::all();
        foreach ($nabardWorks as $nabardWork) {
            $nabardWork->work->updateNabardExpenditure();
        }

        return 0;

        $obseleteWorks = Work::whereIn('WORK_code', ["35W1", "35W10", "35W11", "35W12", "35W13", "35W14", "35W15", "35W16", "35W17", "35W18", "35W19", "35W2", "35W20", "35W21", "35W22", "35W23", "35W24", "35W25", "35W26", "35W27", "35W28", "35W29", "35W3", "35W30", "35W31", "35W32", "35W33", "35W34", "35W35", "35W36", "35W37", "35W38", "35W39", "35W4", "35W40", "35W41", "35W42", "35W43", "35W44", "35W45", "35W46", "35W47", "35W48", "35W49", "35W5", "35W50", "35W51", "35W52", "35W53", "35W54", "35W55", "35W56", "35W57", "35W58", "35W59", "35W6", "35W60", "35W61", "35W62", "35W7", "35W8", "35W9", "41W1", "41W10", "41W11", "41W12", "41W13", "41W14", "41W15", "41W16", "41W17", "41W18", "41W19", "41W2", "41W20", "41W21", "41W22", "41W23", "41W24", "41W25", "41W26", "41W27", "41W28", "41W29", "41W3", "41W30", "41W31", "41W32", "41W33", "41W34", "41W35", "41W36", "41W37", "41W38", "41W39", "41W4", "41W40", "41W41", "41W42", "41W43", "41W44", "41W45", "41W46", "41W47", "41W48", "41W49", "41W5", "41W50", "41W51", "41W52", "41W53", "41W54", "41W55", "41W56", "41W57", "41W58", "41W59", "41W6", "41W60", "41W61", "41W62", "41W63", "41W64", "41W65", "41W66", "41W67", "41W68", "41W69", "41W7", "41W70", "41W71", "41W72", "41W73", "41W74", "41W75", "41W76", "41W77", "41W78", "41W79", "41W8", "41W80", "41W9", "42W1", "42W2", "42W3", "42W4", "42W5", "42W6", "42W7", "50W1", "50W10", "50W11", "50W12", "50W13", "50W14", "50W15", "50W16", "50W17", "50W18", "50W19", "50W2", "50W20", "50W21", "50W22", "50W23", "50W24", "50W25", "50W26", "50W27", "50W28", "50W29", "50W3", "50W30", "50W31", "50W32", "50W33", "50W34", "50W35", "50W36", "50W37", "50W38", "50W39", "50W4", "50W40", "50W41", "50W42", "50W43", "50W44", "50W45", "50W46", "50W47", "50W48", "50W49", "50W5", "50W50", "50W51", "50W52", "50W53", "50W54", "50W55", "50W56", "50W57", "50W58", "50W59", "50W6", "50W61", "50W62", "50W63", "50W64", "50W65", "50W66", "50W7", "50W8", "50W9", "57W1", "57W10", "57W11", "57W12", "57W13", "57W14", "57W15", "57W16", "57W17", "57W18", "57W19", "57W2", "57W20", "57W21", "57W22", "57W23", "57W24", "57W26", "57W28", "57W29", "57W3", "57W30", "57W31", "57W32", "57W33", "57W34", "57W35", "57W36", "57W37", "57W38", "57W39", "57W4", "57W40", "57W41", "57W42", "57W43", "57W44", "57W45", "57W46", "57W47", "57W48", "57W49", "57W5", "57W50", "57W6", "57W7", "57W8", "57W9", "73W1", "73W10", "73W11", "73W12", "73W13", "73W14", "73W15", "73W16", "73W17", "73W18", "73W19", "73W2", "73W20", "73W21", "73W22", "73W23", "73W24", "73W25", "73W26", "73W27", "73W28", "73W29", "73W3", "73W30", "73W31", "73W32", "73W33", "73W34", "73W35", "73W36", "73W37", "73W38", "73W39", "73W4", "73W40", "73W41", "73W42", "73W43", "73W44", "73W45", "73W46", "73W47", "73W48", "73W49", "73W5", "73W50", "73W51", "73W52", "73W53", "73W54", "73W55", "73W56", "73W57", "73W58", "73W59", "73W6", "73W60", "73W61", "73W62", "73W64", "73W7", "73W8", "73W9", "74W1", "74W10", "74W11", "74W12", "74W13", "74W14", "74W15", "74W16", "74W2", "74W3", "74W4", "74W5", "74W6", "74W7", "74W8", "74W9", "75W1", "75W10", "75W11", "75W12", "75W13", "75W14", "75W15", "75W16", "75W2", "75W3", "75W4", "75W5", "75W6", "75W7", "75W8", "75W9", "77W1", "77W10", "77W11", "77W12", "77W13", "77W14", "77W15", "77W16", "77W17", "77W18", "77W19", "77W2", "77W20", "77W21", "77W22", "77W23", "77W24", "77W25", "77W26", "77W27", "77W28", "77W29", "77W3", "77W30", "77W31", "77W32", "77W33", "77W34", "77W35", "77W36", "77W37", "77W38", "77W39", "77W4", "77W40", "77W41", "77W42", "77W43", "77W44", "77W45", "77W46", "77W47", "77W48", "77W49", "77W5", "77W50", "77W51", "77W52", "77W6", "77W7", "77W8", "77W9"])->get();

        foreach ($obseleteWorks as $key => $work) {
            $work->removeWork();
        }

        return 0;

        /*
        $url="https://data.pwduk.in/v1/sessions";
        $response = Http::post($url, [
        "email"=>"er_manojbisht@yahoo.com",
        "password"=>"123456"
        ]);*/
        //$response = Http::get('http://localhost:81/pwd/pic/w/129W521/159');
        //Log::info("response = ".print_r($response->json(), true));
        //Log::info("response = ".print_r($response->status(), true));

        return "hello";

        return $user = User::find(1710);
        //Log::info("user = ".print_r($user, true));

        /*// Creating a token without scopes...
        return $token = $user->createToken('Token Name')->accessToken;

        DB::enableQueryLog();
        //DB::setFetchMode(\PDO::FETCH_ASSOC);
        $model_temp=DB::table('ifms_allotments_temp')->get();
        //DB::setFetchMode($fetchMode);
        //return $queries = DB::getQueryLog();
        $model_temp->map(function($item){

        $model = new IfmsAllotment;
        $resultArray = json_decode(json_encode($item), true);
        $model::updateOrCreate($resultArray);
        }
        );

        return  Carbon::createFromFormat('d M y', '9 Dec 20')->toDateTimeString(); // 1975-05-21 22:00:00
        $this->updateUserToDeafaultJob(2, true);
        return 0;

        return AlertType::find(1);
        $alertProject = AlertProject::find(27);
        $id = 1710;
        return $alertProject->userForNotification; //->contains($id);

        EeOffice::all()->map(function ($ee) {
        $ee->allUsersToRelatedOfficeUpdateInDB();
        });*/

        //$user= Auth::User();
        //DB::enableQueryLog();
        //return $user->onlyEEOffice()->pluck('id');
        //$ee=EeOffice::find(23);
        //return $ee->allUsersToRelatedOffice();

        //});
        //$userToWhomEEOfficeAlloted= $ee->users;
        //return $ee->allUsersToRelatedOffice();

        return $queries = DB::getQueryLog();
    }


    public function temp1($acrid=0,$milestone='reject')
    {
        
        $acrs=Acr::whereIn('id',[2,7,39,50,55,56,77,80,104,105,106,109,118,121,122,123,124,125,126,130,131,136,137,143,144,151,153,155,166,173,178,180,182,184,187,188,193,198,201,202,208,212,217,219,222,224,227,230,241,251,260,263,264,267,268,270,271,275,277,278,284,296,309,314,319,320,325,326,327,328,329,330,331,332,336,338,340,341,344,345,349,354,355,356,361,364,367,368,369,370,371,372,373,375,376,378,379,380,381,382,383,384,385,408,410,412,414,415,416,417,418,419,420,421,422,425,428,429,430,435,436,438,439,441,443,445,450,451,453,462,465,469,470,471,480,481,486,487,488,489,499,500,501,503,504,506,520,521,522,523,524,525,526,527,528,533,535,539,542,544,545,547,554,555,559,561,566,575,576,578,582,584,586,588,590,591,595,603,604,607,612,630,636,637,640,647,648,658,669,673,675,676,677,679,680,685,687,689,691,693,695,696,698,699,700,701,712,717,720,730,733,734,736,737,738,740,743,745,761,768,772,791,795,801,803,825,832,834,842,847,855,856,859,877,881,886,891,903,913,915,916,917,918,921,926,927,931,936,943,944,945,946,954,971,992,1015,1017,1023,1024,1027,1028,1029,1030,1067,1069,1078,1079,1080,1082,1087,1088,1089,1092,1097,1098,1101,1103,1107,1112,1120,1124,1127,1130,1155,1156,1158,1160,1161,1168,1179,1180,1191,1206,1212,1259,1271,1272,1274,1277,1282,1287,1288,1290,1292,1297,1298,1302,1310,1313,1319,1321,1322,1348,1349,1350,1367,1370,1372,1374,1376,1378,1380,1381,1383,1384,1385,1388,1394,1395,1396,1397,1398,1401,1402,1405,1406,1407,1408,1409,1410,1411,1413,1428,1429,1430,1431,1432,1435,1438,1439,1445,1454,1487,1489,1491,1494,1495,1498,1501,1502,1506,1507,1508,1510,1511,1520,1523,1535,1540,1543,1567,1578,1590,1592,1593,1603,1611,1619,1625,1649,1650,1654,1656,1658,1660,1668,1672,1675,1677,1678,1679,1682,1694,1698,1701,1703,1706,1725,1727,1757,1763,1785,1786,1787,1823,1824,1836,1864,1865,1866,1894,1896,1899,1902,1903,1904,1906,1917,1920,1922,1925,1926,1935,1936,1937,1941,1956,1957,1958,1959,1960,1963,1964,1973,1975,1981,1985,1986,1988,1995,1999,2001,2007,2010,2015,2016,2022,2024,2032,2037,2051,2056,2058,2072,2076,2086,2087,2091,2097,2099,2103,2104,2107,2115,2119,2123,2125,2126,2127,2131,2132,2133,2134,2136,2137,2139,2140,2143,2154,2155,2158,2159,2161,2168,2169,2178,2183,2184,2188,2189,2190,2193,2194,2195,2197,2198,2201,2202,2203,2204,2205,2211,2216,2218,2219,2220,2222,2248,2254,2258,2259,2260,2261,2262,2268,2270,2284,2293,2300,2302,2304,2305,2311,2314,2331,2336,2344,2346,2348,2351,2354,2355,2356,2359,2360,2363,2364,2365,2366,2367,2369,2372,2373,2374,2375,2378,2380,2381,2382,2383,2384,2385,2387,2388,2390,2391,2392,2394,2396,2398,2400,2401,2403,2405,2407,2408,2411,2415,2416,2417,2420,2422,2423,2425,2426,2432,2435,2436,2439,2440,2441,2442,2443,2444,2445,2446,2447,2448,2450,2451,2452,2453,2454,2457,2458,2460,2462,2465,2471,2474,2478,2481,2483,2484,2488,2489,2491,2492,2493,2494,2496,2501,2503,2506,2509,2510,2514,2515,2516,2518,2520,2527,2528,2531,2533,2535,2536,2537,2542,2551,2554,2557,2558,2561,2563,2566,2567,2569,2570,2573,2574,2579,2582,2583,2584,2585,2587,2590,2591,2592,2593,2594,2595,2598,2606,2611,2612,2615,2616,2617,2619,2620,2637,2646,2647,2649,2650,2651,2658,2659,2661,2662,2665,2666,2667,2668,2672,2673,2678,2682,2683,2685,2686,2687,2689,2690,2695,2696,2699,2702,2703,2704,2705,2713,2714,2718,2728,2730,2737,2740,2742,2743,2746,2751,2753,2754,2758,2761,2763,2765,2766,2769,2770,2773,2774,2775,2777,2778,2780,2781,2784,2787,2792,2793,2794,2797,2798,2799,2800,2802,2803,2804,2806,2808,2809,2810,2811,2831,2832,2833,2836,2837,2838,2844,2847,2850,2851,2875,2891,2897,2906,2907,2908,2911,2913,2914,2915,2917,2955,2969,2974,3004,3005,3012,3016,3017,3038,3041,3049,3056,3063,3075,3079,3080,3081,3093,3102,3103,3104,3107,3110,3112,3120,3122,3124,3125,3126,3127,3128,3132,3134,3143,3187,3192,3195,3196,3198,3201,3202,3208,3210,3211,3213,3218,3220,3225,3232,3234,3235,3240,3242,3244,3245,3246,3251,3252,3253,3254,3256,3258,3259,3261,3262,3279,3282,3283,3286,3289,3290,3291,3318,3319,3321,3323,3324,3326,3327,3328,3331,3334,3335,3336,3337,3338,3340,3341,3351,3353,3354,3356,3357,3358,3360,3361,3362,3364,3373,3379,3399,3416,3418,3419,3420,3422,3423,3424,3425,3426,3427,3430,3431,3433,3435,3437,3439,3440,3442,3443,3449,3450,3454,3469,3471,3472,3474,3475,3477,3498,3500,3501,3503,3504,3506,3507,3508,3509,3523,3533,3535,3536,3538,3539,3543,3547,3550,3552,3554,3555,3556,3559,3563,3564,3565,3569,3570,3573,3581,3583,3585,3586,3593,3594,3598,3601,3604,3608,3609,3614,3615,3616,3619,3623,3625,3626,3628,3630,3644,3647,3655,3659,3661,3663,3665,3676,3677,3679,3680,3682,3684,3685,3692,3693,3713,3716,3718,3721,3728,3729,3730,3731,3732,3736,3737,3738,3741,3742,3747,3749,3750,3753,3754,3755,3756,3758,3759,3763,3765,3766,3767,3768,3769,3772,3774,3775,3780,3799,3800,3808,3812,3817,3822,3828,3830,3832,3834,3835,3837,3840,3845,3846,3848,3858,3859,3862,3863,3866,3868,3876,3878,3879,3884,3898,3900,3904,3905,3906,3907,3908,3909,3913,3914,3915,3916,3917,3918,3919,3920,3935,3936,3937,3939,3964,3972,3973,3983,3985,3987,3988,4007,4008,4015,4025,4026,4036,4043,4044,4063,4064,4071,4072,4095,4105,4106,4118,4119,4121,4122,4123,4125,4129,4131,4134,4138,4139,4140,4141,4143,4149,4152,4156,4157,4159,4162,4164,4168,4172,4174,4175,4178,4179,4188,4190,4239,4248,4249,4250,4255,4260,4261,4281,4292,4341])->get();
        foreach ($acrs as $acr) {
            //$acr=Acr::find($acrid);            

            $pages = $this->arrangePagesForPdf($acr, $milestone);

            $pdf = \App::make('snappy.pdf.wrapper');
            $pdf->setOption('margin-top', 10);
            $pdf->setOption('cover', view('employee.acr.pdfcoverpage', compact('acr')));
            $pdf->setOption('header-html', view('employee.acr.pdfheader'));
            $pdf->setOption('footer-html',  view('employee.acr.pdffooter'));
            $pdf->loadHTML($pages);

            $acr->createPdfFile($pdf, true);
        }



        
            
        
        




        //View::make() & view() are same
        //$pdf= SPDF::loadView('employee.acr.form.create1',compact('acr','data_groups'));

        /*//loadFile can be authanticate url link
        return SPDF::loadFile(url('/cr/form/32/part1'))->inline('github.pdf');*/
        /*
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = DPDF::loadView('myPDF', $data);
        return $pdf->download('itsolutionstuff.pdf');*/
        //return $pdf->stream('view.pdf');
    }
}
