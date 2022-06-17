<?php

namespace App\Traits\Acr;

use App\Models\Acr\AcrType;
use Illuminate\Http\Request;
use Log;



trait AcrFormTrait
{

	public function getAcrTypefromAcrGroupId(Request $request)
	{
		return AcrType::where('group_id', $request->acr_group_id)->where('is_active',1)->select('description as name', 'id')->get();
	}

	public function defineAcrGroup()
	{
		return [0=>'ENC', 1=>'CE', 2=>'SE', 3=>'EE', 4=>'AE', 5=>'AAE / JE',  7=>'Ministerial/ PA/ Draftsman/ Ameen/ Work Agent/ Mate'];
		//6=>'Others'
	}
}
