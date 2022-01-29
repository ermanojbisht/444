<?php

namespace App\Traits;
use App\Models\CeOffice;
use App\Models\EeOffice;
use App\Models\SeOffice;
use DB;
use Log;
trait UserOfficesTrait {
	/**
	 * [userOfficesaAsPerArray description] make list of offices as array
	 * @param  [type] $offices as array ['user_id','user_office_type','user_office_id']
	 * @return [type]   array       found the ce,se,ee of the user
	 */
    public function userOfficesaAsPerArray($offices)
	{
		//Log::info("offices++++++ = ".print_r($offices,true));
		$arrayOffices = array('ce' => '', 'se' => '', 'ee' => '');
		$arrCe = $arrSe = $arrEe = array();
		foreach ($offices as $office)
		{
			//Log::info("offices = ".print_r($office,true));
			$office_table = $office['user_office_type'];
			$office_id = $office['user_office_id'];
			switch ($office_table)
			{
			case 'App\CeOffice':
			//Log::info("office_id...... = ".print_r($office_id,true));
				$offices = DB::table('mispwd.ce_offices')
					->where('id', $office_id)->where('is_exist', 1)
					->first();
				
				if($offices){
					$ceid = $offices->id;
					$cename = $offices->name;
					$data = array('id' => $ceid, 'name' => $cename);
					array_push($arrCe, $data);
					 //DB::enableQueryLog();
					// INSERT SE OF THIS CE.
					//$se = SeOffice::where('ce_office_id',$ceid)->find($ceid)->get()[0]->seOffices()->get();
					//$se = CeOffice::find($ceid)->with('seOffices')->first();
					//$se =$se->seOffices;
					$se = SeOffice::where('ce_office_id',$ceid)->get();
					
					//$queries = DB::getQueryLog();
					//Log::info("queries = ".print_r($queries,true));
					
					//Log::info("se = ".print_r($se,true));

					//Log::info("se = ".print_r($se,true));
					foreach ($se as $seOff)
						{

						$seid = $seOff->id;
						$sename = $seOff->name;

						$data = array('id' => $seid, 'name' => $sename);
						array_push($arrSe, $data);
					}

					//INSERT EE OF THIS CE
					//$ee = CeOffice::find($ceid)->eeOffices;
					$ee = CeOffice::with('eeOffices')->where('id',$ceid)->get()[0]->eeOffices()->get();
					//Log::info("ee = ".print_r($ee,true));
					foreach ($ee as $eeOff)
						{
						$eeid = $eeOff->id;
						$eename = $eeOff->name;

						$data = array('id' => $eeid, 'name' => $eename);
						array_push($arrEe, $data);
					}
				}
				break;
			case 'App\SeOffice': //IF USER HAS SE OFFICE

				$offices = DB::table('mispwd.se_offices')
					->where('id', $office_id)->where('is_exist', 1)
					->first();
				if($offices){
					$seid = $offices->id;
					$sename = $offices->name;
					$data = array('id' => $seid, 'name' => $sename);
					$flag = 1;
					foreach ($arrSe as $se)
						{
						if ($se['id'] == $seid)
							{
							$flag = 0;
							break;
						}
						else
						{
							$flag = 1;
						}
					}
					if ($flag == 1)
					{
						array_push($arrSe, $data);
						//$ee = SeOffice::find($seid)->eeOffices;
						$ee = SeOffice::with('eeOffices')->where('id',$seid)->get()[0]->eeOffices()->get();
						foreach ($ee as $eeOff)
						{
							$eeid = $eeOff->id;
							$eename = $eeOff->name;

							$data = array('id' => $eeid, 'name' => $eename);
							array_push($arrEe, $data);
						}
					}
				}				
				break;

			case 'App\EeOffice': //IF USER HAS EE OFFICE
				$offices = DB::table('mispwd.ee_offices')
					->where('id', $office_id)
					->first();
				if($offices){
					$eeid = $offices->id;
					$eename = $offices->name;
					$data = array('id' => $eeid, 'name' => $eename);
					$flag = 1;
					foreach ($arrEe as $ee)
						{
						if ($ee['id'] == $eeid)
							{
							$flag = 0;
							break;
						}
						else
						{
							$flag = 1;
						}
					}
					if ($flag == 1)
					{
						array_push($arrEe, $data);
					}
				}
				break;
			}
		}

		$arrayOffices['ce'] = collect($arrCe);//->sortBy('name');
		$arrayOffices['se'] = collect($arrSe);//->sortBy('name');
		$arrayOffices['ee'] = collect($arrEe);//->sortBy('name');

		return collect($arrayOffices);
	}
	/**
	 * [makeArrayFromRequest description] from a form request for a user by selecting office type  and multiple office of that type 
	 * @param  [type] $userid      [description]
	 * @param  [type] $officeModel [description]
	 * @param  [type] $offices     [description]
	 * @return [type]    make a array ['user_id','user_office_type','user_office_id']
	 */
	public function makeArrayFromRequest($userid,$officeModel,$offices)
	{
		$officeArray=[];
		foreach ($offices as $key => $oneOffice) {
			$data=['user_id'=>$userid,'user_office_type'=>$officeModel,'user_office_id'=>$oneOffice];
			array_push($officeArray, $data);
		}
		return $officeArray;
	}
	/**
	 * [onlyEEOffices get user's ee officeid as array
	 * @param  [integer] $userid 
	 * @param  [string] $officeModel('App\CeOffice','App\SeOffice','App\EeOffice') 
	 * @param  [array] $offices     [description]
	 * @return [array]    of officeid
	 */
	public function onlyEEOffices($userid,$officeModel,$offices)
	{
		$ArrayFromRequest=$this->makeArrayFromRequest($userid,$officeModel,$offices);
		$userOfficesaAsPerArray=$this->userOfficesaAsPerArray($ArrayFromRequest);
		return $userOfficesaAsPerArray['ee']->pluck('id');
	}
	public function regexOfWorkCodeFromeEEofficeArray($eeOfficeArray)
	{
		 $regexString = '';
        foreach ($eeOfficeArray as $ee_office_id) {
             $regexString .="^".$ee_office_id."W|";
        }
        return rtrim($regexString,'|');
	}

    public function userDirectOfficesaAsPerArray($offices)
    {
        //Log::info("offices++++++ = ".print_r($offices,true));
        $arrayOffices = array('ce' => '', 'se' => '', 'ee' => '');
        $arrCe = $arrSe = $arrEe = array();
        foreach ($offices as $office)
        {
            //Log::info("offices = ".print_r($office,true));
            $office_table = $office['user_office_type'];
            $office_id = $office['user_office_id'];
            switch ($office_table)
            {
            case 'App\CeOffice':
            //Log::info("office_id...... = ".print_r($office_id,true));
                $ceofficetable='mispwd.'.(new CeOffice)->table;
               // Log::info("this = ".print_r($ceofficetable,true));
               /* $connection=(new CeOffice)->tableName();
                Log::info("this = ".print_r($connection,true));*/


                $offices = DB::table($ceofficetable)
                    ->where('id', $office_id)->where('is_exist', 1)
                    ->first();

                if($offices){
                    $ceid = $offices->id;
                    $cename = $offices->name;
                    $data = array('id' => $ceid, 'name' => $cename);
                    array_push($arrCe, $data);
                }
                break;
            case 'App\SeOffice': //IF USER HAS SE OFFICE
                $seofficetable='mispwd.'.(new SeOffice)->table;
                $offices = DB::table($seofficetable)
                    ->where('id', $office_id)->where('is_exist', 1)
                    ->first();
                if($offices){
                    $seid = $offices->id;
                    $sename = $offices->name;
                    $data = array('id' => $seid, 'name' => $sename);
                    array_push($arrSe, $data);
                }
                break;

            case 'App\EeOffice': //IF USER HAS EE OFFICE
                $eeofficetable='mispwd.'.(new EeOffice)->table;
                $offices = DB::table($eeofficetable)
                    ->where('id', $office_id)
                    ->first();
                if($offices){
                    $eeid = $offices->id;
                    $eename = $offices->name;
                    $data = array('id' => $eeid, 'name' => $eename);
                    array_push($arrEe, $data);
                }
                break;
            }
        }

        $arrayOffices['ce'] = collect($arrCe);//->sortBy('name');
        $arrayOffices['se'] = collect($arrSe);//->sortBy('name');
        $arrayOffices['ee'] = collect($arrEe);//->sortBy('name');

        return collect($arrayOffices);
    }

}
