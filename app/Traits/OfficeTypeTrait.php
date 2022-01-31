<?php

namespace App\Traits;

use App\Models\CeOffice;
use App\Models\EeOffice;
use App\Models\Office;
use App\Models\SeOffice;
use DB;
use Illuminate\Support\Facades\Log;
trait OfficeTypeTrait {
	public function officeListAsPerOfficeType($officeType)
	{
		switch ($officeType) {
    		case 0:
    			$data= ["ENC Office","All office"];
    			break;
    		case 1:
    			$data= CeOffice::orderBy('name')->get()->pluck('name','id');
    			break;
    		case 2:
    			$data= SeOffice::orderBy('name')->get()->pluck('name','id');
    			break;
    		case 3:
    			$data= EeOffice::orderBy('name')->get()->pluck('name','id');
    			break;
    		
    		default:
    			$data= [];
    			break;
    	}
    	return $data;
	}

    public function officeListAsPerOfficeTypeObject($officeType)
	{
		switch ($officeType) {
    		case 0:
    			$data = [(collect(['id'=>'0', 'name' =>'ENC Office']))];
    			break;
    		case 1:
    			$data= CeOffice::select('name','id')->where('is_exist',1)->orderBy('name')->get();
    			break;
    		case 2:
    			$data= SeOffice::select('name','id')->where('is_exist',1)->orderBy('name')->get();
    			break;
    		case 3:
    			$data= EeOffice::select('name','id')->where('is_exist',1)->orderBy('name')->get();
    			break;
    		
    		default:
    			$data= [];
    			break;
    	}
    	return $data;
	}

	public function getOfficeListAsPerOfficeTypeId($officeId)
	{
		return Office::where('office_type',$officeId)->select('name','id')->get();
	}


	public function defineOfficeTypes()
	{
		return [           
            0=>'Head/All Office',
            1=>'Zonal',
            2=>'Circle',
            3=>'Division',
        ];
	}

	public function OfficeName($officeType,$officeId)
	{
		//Log::info("OfficeName = ".print_r([$officeType,$officeId],true));
		switch ($officeType) {
    		case 0:
    			return "ENC Office";
    			break;
    		case 1:
                if($data= CeOffice::find($officeId)){
                    return $data->name;
                }    			
    			break;
    		case 2:
                if($data= SeOffice::find($officeId)){
                    return $data->name;
                }
    			break;
    		case 3:
    			if($data= EeOffice::find($officeId)){
                    return $data->name;
                }               
    			break;
    	}
    	return 'Unknown';
	}

    public function OfficeDurgamSugamType($officeType,$officeId)
    {
        //Log::info("this = ".print_r($officeType,true));
        switch ($officeType) {
            case 0:
                return 1;
                break;
            case 1:
                if($data= CeOffice::find($officeId)){
                    return $data->period_category;
                }
                break;
            case 2:
                if($data= SeOffice::find($officeId)){
                    return $data->period_category;
                }
                break;
            case 3:
                if($data= EeOffice::find($officeId)){
                    return $data->period_category;
                }
                break;
            
            default:
                $data= 1;
                break;
        }
        return 1;
    }

    public function officeModelData($officeType)
    {
        switch ($officeType) {
        case '1':
            $officelistAll = CeOffice::all();
            break;
        case '2':
            $officelistAll = SeOffice::all();
            break;
        case '3':
            $officelistAll = EeOffice::all();
            break;
        }
        return $officelistAll;
    }

}