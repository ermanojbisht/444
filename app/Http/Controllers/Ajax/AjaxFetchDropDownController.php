<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Im\Village;
use App\Models\Im\Ulb;
use App\Models\Track\EstimateFeatureType;
use Illuminate\Http\Request;
use DB;
use Log;

class AjaxFetchDropDownController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        /*Log::info("this = ".print_r( $request->all(),true));*/
        //on basis of office type select office in office_id element
        if ($request->dependent == "employee_id") {
            return $this->employeeDropDown($request);
        };
        if ($request->dependent == "estimate_feature_group") {
            return $this->getFeatureListAsPerSelectedGroup($request);
        };
        if ($request->dependent == "block") {
            return $this->villageDropDown($request);
        };
        if ($request->dependent == "ulbType") {
            return $this->ulbDropDown($request);
        };
    }

    /**
     * @param $request
     */
    public function employeeDropDown($request)
    {
        $data = [];
        if ($request->has('term')) {
            $search = $request->term;
            $data = Employee::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->orWhere('id', 'LIKE', "%$search%")
                ->orderBy('name')
                ->get();
        }
        //Log::info("employeeDropDown data = ".print_r($data,true));

        return response()->json($data);
    }

    /**
     * @param Request $request
     */
    public function getFeatureListAsPerSelectedGroup(Request $request)
    {
        return EstimateFeatureType::where("group_id", $request->get('key'))->select("id", "name")->get();
    }

    /**
     * @param Request $request
     */
    public function villageDropDown(Request $request, $htmloutput=false)
    {
        $villageList = Village::where('villages.block_ID_MIS', $request->key)
            ->select('id', 'name')->orderBy('name')->get();

        if(!$htmloutput) return $villageList;

        $output = '<option value="">Select Village</option>';
        $preSelected = $request->key; //key is block id already selected in form
        foreach ($villageList as $value) {
            $attribute = ($value->id == $preSelected) ? "selected" : "";
            $output .= '<option value="'.$value->id.'" '.$attribute.'>'.$value->id.'('.$value->name.')</option>';
        }
        echo $output;
    }
    public function ulbDropDown(Request $request, $htmloutput=false)
    {
        Log::info("this = ".print_r($request->all(),true));
        $ulbList = Ulb::where('type_id', $request->key)
            ->select(DB::raw('id ,title as name'))->orderBy('name')->get();



        if(!$htmloutput) return $ulbList;
    }
}
