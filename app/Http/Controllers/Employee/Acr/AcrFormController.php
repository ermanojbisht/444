<?php

namespace App\Http\Controllers\Employee\Acr; 

use App\Http\Controllers\Controller; 
use App\Models\Acr\Acr;
use App\Models\Acr\AcrNegativeParameter;
use App\Models\Acr\AcrParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  

class AcrFormController extends Controller
{
 
    /**
     * @var mixed
     */
    protected $user;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();
            return $next($request);
        });
    }

    /**
     * @param Acr     $acr
     * @param Request $request
     */
    public function create(Acr $acr, Request $request)
    {
        $data_groups = $acr->acrMasterParameters()->where('type',1)->get()->groupBy('config_group');
        $negative_groups = $acr->acrMasterParameters()->where('type',0)->get()->groupBy('config_group');
        
        return view('employee.acr.form.create',compact('acr','data_groups','negative_groups'));
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
          
        foreach ($request->acr_master_parameter_id as $acr_master_parameter) {
            if ($request->applicable[$acr_master_parameter] == 1) {
                AcrParameter::create([
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $acr_master_parameter,
                    'user_target' => $request->target[$acr_master_parameter] ?? '',
                    'user_achivement' => $request->achivement[$acr_master_parameter] ?? '',
                    'status' => $request->status[$acr_master_parameter] ?? ''
                ]);
            }
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function store2(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update(['good_work' => $request->good_work,
            'difficultie' => $request->difficultie]);
        //$acr->save();

        return redirect()->back();
    }

    public function store3(Request $request)
    {
        //return $request->all();
        foreach ($request->acr_master_parameter_id as $parameter_id) {
            foreach($request->$parameter_id as $rowNo=> $rowData){
                AcrNegativeParameter::create([
                    'acr_id' => $request->acr_id,
                    'acr_master_parameter_id' => $parameter_id??'',
                    'row_no' => $rowNo,
                    'col_1' => $rowData['col_1']??'',
                    'col_2' => $rowData['col_2']??'',
                    'col_3' => $rowData['col_3']??'',
                    'col_4' => $rowData['col_4']??'',
                    'col_5' => $rowData['col_5']??'',
                    'col_6' => $rowData['col_6']??'',
                    'col_7' => $rowData['col_7']??'',
                    'col_8' => $rowData['col_8']??'',
                    'col_9' => $rowData['col_9']??''
                ]);
            }
        }

        return redirect()->back();
    }



}
