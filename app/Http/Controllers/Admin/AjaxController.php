<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function districtDetail($districtid, $detailsof)
    {
        if(!$districtid){
            return false;
        }
        $district = District::findOrFail($districtid);
        $values = false;
        switch($detailsof){
            case "block":
                $values = $district->blocks;
                break;
            case "tehsil":
                $values = $district->tehsils;
                break;
            case "constituency":
                $values = $district->constituencies;
                break;
        }
        if($values){
            $values = $values->pluck('name','id');
            
            $options = "<option value=''>Select ".ucfirst($detailsof)."</option>";
            foreach($values as $key=>$value){
                $options .= "<option value='{$key}'>{$value}</option>";
            }
            return $options;
        }

    }
}
