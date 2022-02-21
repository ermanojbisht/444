<?php

namespace App\Traits;

use App\Models\Acr\AcrType;
use Illuminate\Http\Request;
use Log;



trait AcrFormTrait
{

	public function getAcrTypefromAcrGroupId(Request $request)
	{
		return AcrType::where('group_id', $request->acr_group_id)->select('description as name', 'id')->get();
	}

	public function defineAcrGroup()
	{
		return ['ENC', 'CE', 'SE', 'EE', 'AE', 'AAE / JE', 'Non Technical'];
	}
}
