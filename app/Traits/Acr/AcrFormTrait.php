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
		return ['ENC', 'CE', 'SE', 'EE', 'AE', 'AAE / JE', 'Others', 'Ministerial/ PA/ Draftsman/ Ameen/ Work Agent/ Mate'];
	}
}
