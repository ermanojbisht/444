<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Acr\Acr;

use Log;

class TempController extends Controller
{

    public function create(Acr $acr)
    {

        $acr_type_id =  $acr->acr_type_id;

        $groupIds = $acr->acrMasterParameters()->get()->pluck('config_group')->unique();


        $datas = $acr->acrMasterParameters()->get();

        return view('acr.create',compact('acr', 'groupIds','datas'));

    }

    public function store(Request $request)
    {
         Log::info("response = ".print_r($request->all(),true));
       // return $request->all();
    }
    public function temp()
    {

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



        return view('temp');

        $instanceEstimate=InstanceEstimate::find(2);
        return $instanceEstimate->lastAddedFeatureGroup();

        $alertprojects=AlertProject::all();
        foreach ($alertprojects as $key => $alertproject) {
            $contractor_details=$alertproject->contractor_details;
            $result=Helper::checkContractorNameAndPan($contractor_details);
            if($result['status']){
                $contractor=Contractor::where('pan',$result['string']['pan'])->first();
                if($contractor){
                   $gstn= $contractor->gstn;
                   $alertproject->gstn=$contractor->gstn;
                   $alertproject->save();
                }
            }
        }

        echo "start";
        $old_string='/media/dell/New\\ Volume/CloudStation/devpy/test.py';
        $old_string='/media/dell/datadrive/CloudStation/devpy/test.py ';
        $new_string = str_replace(" ", "\\ ", $old_string);
        $command = escapeshellcmd($new_string);

        return $output = shell_exec($command.' 2>&1');

        echo "d";

        echo $output;
        return ;
        Actor::chunk(25,function($chunk){
            foreach ($chunk as  $actor) {                
                $employee=$actor->employee;                
                $qrrequest=Qrrequest::where('emp_code',$actor->displayName)->first();
                if($employee){                    
                    if(!$qrrequest){
                        Qrrequest::create([                             
                          'user_id'=>1710,
                          'emp_code'=>$actor->displayName,
                          'request_type_id'=>1,
                          'status'=>1,
                          'created_at'=>$actor->createdAt,
                          'updated_at'=>$actor->updatedAt
                        ]);
                    }else{                        
                        $qrrequest->timestamps = false;
                        $qrrequest->status = 1;
                        $qrrequest->save(); 
                    }
                }
                $actor->updateAvialbleFormsNameToQrrequest();
            }
        });
        return 0;

        Bond::chunk(3,function($chunk){           
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

        $obseleteWorks=Work::whereIn('WORK_code',["35W1","35W10","35W11","35W12","35W13","35W14","35W15","35W16","35W17","35W18","35W19","35W2","35W20","35W21","35W22","35W23","35W24","35W25","35W26","35W27","35W28","35W29","35W3","35W30","35W31","35W32","35W33","35W34","35W35","35W36","35W37","35W38","35W39","35W4","35W40","35W41","35W42","35W43","35W44","35W45","35W46","35W47","35W48","35W49","35W5","35W50","35W51","35W52","35W53","35W54","35W55","35W56","35W57","35W58","35W59","35W6","35W60","35W61","35W62","35W7","35W8","35W9","41W1","41W10","41W11","41W12","41W13","41W14","41W15","41W16","41W17","41W18","41W19","41W2","41W20","41W21","41W22","41W23","41W24","41W25","41W26","41W27","41W28","41W29","41W3","41W30","41W31","41W32","41W33","41W34","41W35","41W36","41W37","41W38","41W39","41W4","41W40","41W41","41W42","41W43","41W44","41W45","41W46","41W47","41W48","41W49","41W5","41W50","41W51","41W52","41W53","41W54","41W55","41W56","41W57","41W58","41W59","41W6","41W60","41W61","41W62","41W63","41W64","41W65","41W66","41W67","41W68","41W69","41W7","41W70","41W71","41W72","41W73","41W74","41W75","41W76","41W77","41W78","41W79","41W8","41W80","41W9","42W1","42W2","42W3","42W4","42W5","42W6","42W7","50W1","50W10","50W11","50W12","50W13","50W14","50W15","50W16","50W17","50W18","50W19","50W2","50W20","50W21","50W22","50W23","50W24","50W25","50W26","50W27","50W28","50W29","50W3","50W30","50W31","50W32","50W33","50W34","50W35","50W36","50W37","50W38","50W39","50W4","50W40","50W41","50W42","50W43","50W44","50W45","50W46","50W47","50W48","50W49","50W5","50W50","50W51","50W52","50W53","50W54","50W55","50W56","50W57","50W58","50W59","50W6","50W61","50W62","50W63","50W64","50W65","50W66","50W7","50W8","50W9","57W1","57W10","57W11","57W12","57W13","57W14","57W15","57W16","57W17","57W18","57W19","57W2","57W20","57W21","57W22","57W23","57W24","57W26","57W28","57W29","57W3","57W30","57W31","57W32","57W33","57W34","57W35","57W36","57W37","57W38","57W39","57W4","57W40","57W41","57W42","57W43","57W44","57W45","57W46","57W47","57W48","57W49","57W5","57W50","57W6","57W7","57W8","57W9","73W1","73W10","73W11","73W12","73W13","73W14","73W15","73W16","73W17","73W18","73W19","73W2","73W20","73W21","73W22","73W23","73W24","73W25","73W26","73W27","73W28","73W29","73W3","73W30","73W31","73W32","73W33","73W34","73W35","73W36","73W37","73W38","73W39","73W4","73W40","73W41","73W42","73W43","73W44","73W45","73W46","73W47","73W48","73W49","73W5","73W50","73W51","73W52","73W53","73W54","73W55","73W56","73W57","73W58","73W59","73W6","73W60","73W61","73W62","73W64","73W7","73W8","73W9","74W1","74W10","74W11","74W12","74W13","74W14","74W15","74W16","74W2","74W3","74W4","74W5","74W6","74W7","74W8","74W9","75W1","75W10","75W11","75W12","75W13","75W14","75W15","75W16","75W2","75W3","75W4","75W5","75W6","75W7","75W8","75W9","77W1","77W10","77W11","77W12","77W13","77W14","77W15","77W16","77W17","77W18","77W19","77W2","77W20","77W21","77W22","77W23","77W24","77W25","77W26","77W27","77W28","77W29","77W3","77W30","77W31","77W32","77W33","77W34","77W35","77W36","77W37","77W38","77W39","77W4","77W40","77W41","77W42","77W43","77W44","77W45","77W46","77W47","77W48","77W49","77W5","77W50","77W51","77W52","77W6","77W7","77W8","77W9"])->get();

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
        Log::info("response = ".print_r($response->json(),true));
        Log::info("response = ".print_r($response->status(),true));
        return "hello";
        return $user = User::find(1710);
        Log::info("user = ".print_r($user,true));

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


}
