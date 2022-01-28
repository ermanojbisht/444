<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ODK\WorkToNotify;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\user_office;
use Gate;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller {
	public function index() {

		//abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$users = User::with('roles')->get()->take(1000);

		return view('admin.users.index', compact('users'));
	}

	public function create() {
		abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$roles = Role::all()->pluck('name', 'id');
		unset($roles[1]);
		$permissions = Permission::all()->pluck('name', 'id');

		return view('admin.users.create', compact('roles', 'permissions'));
	}

	/**
	 * @param StoreUserRequest $request
	 */
	public function store(StoreUserRequest $request) {
		$user = User::create($request->all());
		$user->roles()->sync($request->input('roles', []));
		event(new UserCreatedEvent($user));

		return redirect()->route('admin.users.index');
	}

	/**
	 * @param User $user
	 */
	public function edit(User $user) {
		abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$roles = Role::all()->pluck('name', 'id');
		unset($roles[1]);
		$permissions = Permission::all()->pluck('name', 'id');
		//unset($permissions[1]);

		$user->load('roles');

		return view('admin.users.edit', compact('roles', 'user', 'permissions'));
	}

	/**
	 * @param UpdateUserRequest $request
	 * @param User $user
	 */
	public function update(UpdateUserRequest $request, User $user) {
		$user->update($request->all());
		$user->roles()->sync($request->input('roles', []));
		$user->permissions()->sync($request->input('permissions', []));
		return redirect()->route('admin.users.index');
	}

	/**
	 * @param User $user
	 */
	public function show(User $user) {
		abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		$user->load('roles');
		return view('admin.users.show', compact('user'));
	}

	/**
	 * @param User $user
	 */
	public function destroy(User $user) {
		abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$user->delete();

		return back();
	}

	/**
	 * @param MassDestroyUserRequest $request
	 */
	public function massDestroy(MassDestroyUserRequest $request) {
		User::whereIn('id', request('ids'))->delete();

		return response(null, Response::HTTP_NO_CONTENT);
	}

	/**
	 * @param $userid
	 */
	public function assignUserOffices($userid) {
		$userInfo        = User::find($userid);
		$offices         = $userInfo->userDirectOffices();
		$allowedEeoffice = $offices['ee'];
		$allowedSeoffice = $offices['se'];
		$allowedCeoffice = $offices['ce'];

		$Officetypes          = collect(config('site.officeType'))->pluck('name', 'id');
		$userJobAllotmentMenu = collect(config('site.userJobAllotmentMenu'))->pluck('name', 'id');

        $patterns=$userInfo->workToNotify()->get();

		return view('admin.users.userprofileForOffice', compact('userInfo', 'allowedEeoffice', 'allowedSeoffice', 'allowedCeoffice', 'Officetypes', 'userJobAllotmentMenu','patterns'));
	}

	/**
	 * @param Request $request
	 */
	public function detachOffice(Request $request) {
		//an user can not have same id in different offices
		$userid   = $request->get('id');
		$eeoffice = $request->get('eeoffice');
		$seoffice = $request->get('seoffice');
		$ceoffice = $request->get('ceoffice');
		Log::info("eeoffice = ".print_r($eeoffice, true));
		Log::info("seoffice = ".print_r($seoffice, true));
		Log::info("ceoffice = ".print_r($ceoffice, true));

		if ($eeoffice) {
			foreach ($eeoffice as $key => $oneOffice) {
				user_office::where('user_id', '=', $userid)
					->where('user_office_type', 'App\EeOffice')
					->where('user_office_id', $oneOffice)
					->delete();
			}
		}
		if ($seoffice) {
			foreach ($seoffice as $key => $oneOffice) {
				user_office::where('user_id', '=', $userid)
					->where('user_office_type', 'App\SeOffice')
					->where('user_office_id', $oneOffice)
					->delete();
			}
		}
		if ($ceoffice) {
			foreach ($ceoffice as $key => $oneOffice) {
				user_office::where('user_id', '=', $userid)
					->where('user_office_type', 'App\CeOffice')
					->where('user_office_id', $oneOffice)
					->delete();
			}
		}
		return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');
	}

	/**
	 * @param Request $request
	 */
	public function assignOfficeAndJob(Request $request) {
		$this->validate($request, [
			'id'         => 'required',
			'officeType' => 'required',
			'office'     => 'required',
			'jobType'    => 'required'
		]);
		$userid      = $request->get('id');
		$officeType  = $request->get('officeType');
		$offices     = $request->get('office');
		$officeModel = config("site.officeType.$officeType.model");
		$jobType     = $request->get('jobType');
		switch ($jobType) {
		case 1:
			$this->assignOffice($userid, $officeModel, $offices);
			break;
		case 2:
			$this->attachDetachOfficeForForestMsg($userid, $officeModel, $offices);
			break;
		}

		//$this->updateUserRulesDescInJson($userid);
		return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');

	}

	/**
	 * @param $userid
	 * @param $officeModel
	 * @param $offices
	 */
	public function assignOffice($userid, $officeModel, $offices) {
		foreach ($offices as $key => $oneOffice) {
			if (!user_office::where('user_id', '=', $userid)
				->where('user_office_type', '=', $officeModel)
				->where('user_office_id', '=', $oneOffice)->exists()) {
				$useroffice = new user_office([
					'user_id'          => $userid,
					'user_office_type' => $officeModel,
					'user_office_id'   => $oneOffice,
					'import_allowed'   => 0
				]);
				$useroffice->save();
			}
		}
	}

	/**
	 * @param $userid
	 * @param $officeModel
	 * @param $offices
	 * @param $attach  //todo this method taken from mispwd but not checked
	 */
	public function attachDetachOfficeForForestMsg($userid, $officeModel, $offices, $attach = false) {
		$onlyEEOffices = $this->onlyEEOffices($userid, $officeModel, $offices);
		$list          = '';
		foreach ($onlyEEOffices as $ee_office_id) {
			$list .= "^".$ee_office_id."W|";
		}
		$list      = rtrim($list, '|');
		$Proposals = ForestProposal::where('WORK_code', 'REGEXP', $list)->get();
		if ($Proposals) {
			Helper::addRemoveValueToCSVField($Proposals, $csvField = 'users_for_notification', $userid, $attach);
		}
		return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');
	}

	/**
	 * [fetchAOffices description]
	 * @param  [type] $officeType [description]
	 * @return [type]             [description]
	 */
	public function fetchAOffices($officeType) {
		/**
		 * [$labelText select box heading
		 * @var string
		 */
		$labelText = "Select ".$officeType;
		/**
		 * on basis of office type fetch office name and id from model
		 */
		switch ($officeType) {
		case 'CE':
			$offices = \App\Models\CeOffice::all();
			break;
		case 'SE':
			$offices = \App\Models\SeOffice::all();
			break;
		case 'EE':
			$offices = \App\Models\EeOffice::all();
			break;
		default:
			$offices = false;
			break;
		}
		/**
		 * [$html make multi select statement
		 * @var string
		 */
		$html = "";
		if ($offices) {
			$html = "<select name='office[]' size='15' class='form-control' id='officeid' multiple>";
			foreach ($offices as $office) {
				$html .= "<option value='".$office->id."'>".$office->name."</option>";
			}
			$html .= "</select>";
		}
		/**
		 * return select heading and options
		 */
		return array(
			'ele'    => $html,
			'lbltxt' => $labelText
		);
	}

    public function addTelegramPattern(User $user)
    {
        return view ('admin.users.createPattern',compact('user'));
    }
    public function storeWorkPatternForTelegram(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        $WORK_code=$request->WORK_code;
        $patterns=WorkToNotify::where('user_id',$request->user_id)
        ->where('WORK_code',$WORK_code)->first();
        if($patterns){
            Log::info("patterns = ".print_r($patterns,true));
            return redirect()->back()->with('fail',$request->WORK_code .' pattern already exists');
        }else{
            if(!$user->chat_id>10000){
                return redirect()->back()->with('fail','Teleram integration is not done by user');
            }
            WorkToNotify::create([
                'user_id'=>$request->user_id,
                'WORK_code'=>$request->WORK_code,
                'user_type'=>1,
                'chat_id'=>$user->chat_id,
            ]);
            return redirect()->back()->with('success',$request->WORK_code . " pattern is added");
        }

    }
}
