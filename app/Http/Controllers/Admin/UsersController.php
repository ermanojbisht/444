<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Employee;
use App\Models\ForestProposal;
use App\Models\Office;
use App\Models\OfficeJob;
use App\Models\OfficeJobDefault;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\user_office;
use App\Traits\OfficeTypeTrait;
use App\Traits\UserOfficesTrait;
use Gate;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    use UserOfficesTrait, OfficeTypeTrait;
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = User::with(['roles', 'employee', 'employee.designation'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return view('partials.datatablesActionsForUser', compact('row'));
            });

            $table->addColumn('designation', function ($row) {
                if ($row->employee->designation) {
                    return $row->employee->designation->name;
                }

                return 'no designation';
            });

            $table->editColumn('roles', function ($row) {
                $roles = '';
                foreach ($row->roles as $key => $item) {
                    $roles .= '<span class="badge badge-info">'.$item->name.'</span>';
                }

                return $roles;
            });
            $table->editColumn('approved', function ($row) {
                $verifiedchecked = $row->approved ? 'checked' : '';

                return '<input type="checkbox" disabled="disabled" '.$verifiedchecked.'>';
            });

            $table->editColumn('verified', function ($row) {
                $verifiedchecked = $row->verified ? 'checked' : '';

                return '<input type="checkbox" disabled="disabled" '.$verifiedchecked.'>';
            });

            $table->rawColumns(['actions', 'placeholder', 'roles', 'approved', 'verified']);

            return $table->make(true);
        }
        $offices = Office::all();

        return view('admin.users.index', compact('offices'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('name', 'id');
        unset($roles[1]);
        $permissions = Permission::all()->pluck('name', 'id');

        return view('admin.users.create', compact('roles', 'permissions'));
    }

    /**
     * @param StoreUserRequest $request
     */
    public function store(StoreUserRequest $request)
    {
        $this->checkEmployeeIdExist($request);
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        event(new UserCreatedEvent($user));

        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
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
     * @param User              $user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->checkEmployeeIdExist($request);
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.users.index');
    }

    /**
     * @param User $user
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    /**
     * @param MassDestroyUserRequest $request
     */
    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $userid
     */
    public function assignUserOffices($userid)
    {
        $userInfo = User::find($userid);
        $jobs = $userInfo->jobs(); //->orderBy('name')->get();

        $Officetypes = $this->defineOfficeTypes();
        $joblist = OfficeJob::all()->pluck('name', 'id');

        return view('admin.users.userprofileForOffice', compact('userInfo', 'Officetypes', 'joblist', 'jobs'));
    }

    /**
     * @param Request $request
     */
    public function detachOffice(Request $request)
    {
        //an user can not have same id in different offices
        $userid = $request->get('id');
        $jobs = $request->get('job'); //OfficeJobDefault id array

        if ($jobs) {
            foreach ($jobs as $job) {
                $officeJobDefault=OfficeJobDefault::find($job);
                $job_id=$officeJobDefault->job_id;
                $officeJobDefault->delete();
                //if user has no job_id=5,6 create-others-acr-job,acknowledge-acr-job  then remove permission 102,103
                if(in_array($job_id, [5,6])){
                    $anyJobExist=OfficeJobDefault::where('job_id',$job_id)->where('user_id',$userid)->first();
                    if(!$anyJobExist){
                        $permission=$this->permissionRelatedToJob($job_id);
                        User::find($userid)->permissions()->detach($permission);
                    }
                }
            }
        }


        $anyJobExist=OfficeJobDefault::where('job_id',$job_id)->where('user_id',$userid)->first();

        return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');
    }

    /**
     * @param Request $request
     */
    public function assignOfficeAndJob(Request $request)
    {
        $this->validate($request, [
            'id' => 'required', //user_id
            'office' => 'required', //office_id as array
            'job_id' => 'required' //job_id
        ]);
        $userid = $request->get('id');
        $offices = $request->get('office');
        $job_id = $request->get('job_id');

        $this->assignOffice($userid, $job_id, $offices);

        //for job_id=5,6 add permission to user create-others-acr-job,acknowledge-acr-job
        if(in_array($job_id, [5,6])){
            $permission=$this->permissionRelatedToJob($job_id);
            User::find($userid)->permissions()->syncWithoutDetaching([$permission]);
        }

        return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');
    }

    /**
     * @param $userid
     * @param $officeModel
     * @param $offices
     */
    public function assignOffice($userid, $job_id, $offices)
    {
        foreach ($offices as  $office_id) {

            $selectedUser = User::find($userid);
            if ($selectedUser) {

                //office head should be only one in office or similar job
                $jobWhichNeedSingleUser = [1, 2, 3];
                if (in_array($job_id, $jobWhichNeedSingleUser)) {
                    $OfficeHeadJobRowExist = OfficeJobDefault::whereJobId($job_id)->whereOfficeId($office_id)->first();
                    if ($OfficeHeadJobRowExist) {
                        return redirect()->back()->with('fail', "Office head/ similar one person row already exist for selected office . you can't add more then one head for a office. Delete existing row then add new one");
                    }
                }
            } else {
                return redirect()->back()->with('fail', "User having user id =$userid does't exist");
            }

            $OfficeJob = OfficeJobDefault::updateOrcreate(
                ['user_id'=>$userid,'office_id'=>$office_id,'job_id'=>$job_id],
                ['user_id'=>$userid,'office_id'=>$office_id,'job_id'=>$job_id, 'employee_id'=>$selectedUser->employee_id]
            );
            //head_emp_code will also change in office tables
            $OfficeJob->updateHeadEmpCodeInOfficeTables();
        }
    }

    /**
     * @param $userid
     * @param $officeModel
     * @param $offices
     * @param $attach        //todo this method taken from mispwd but not checked
     */
    public function attachDetachOfficeForForestMsg($userid, $officeModel, $offices, $attach = false)
    {
        $onlyEEOffices = $this->onlyEEOffices($userid, $officeModel, $offices);
        $list = '';
        foreach ($onlyEEOffices as $ee_office_id) {
            $list .= "^".$ee_office_id."W|";
        }
        $list = rtrim($list, '|');
        $Proposals = ForestProposal::where('WORK_code', 'REGEXP', $list)->get();
        if ($Proposals) {
            Helper::addRemoveValueToCSVField($Proposals, $userid, $attach, $csvField = 'users_for_notification');
        }

        return redirect('/assignUserOffices/'.$userid)->with('status', 'User Office Updated Successfully!');
    }

    /**
     * [fetchAOffices description]
     * @param  [type] $officeType     [description]
     * @return [type] [description]
     */
    public function fetchAOffices($officeType)
    {
        $officeTypes=$this->defineOfficeTypes();
        /**
         * on basis of office type fetch office name and id from model
         */
        $labelText="Select ".$officeTypes[$officeType];

        $offices = Office::where('office_type',$officeType)->get();

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

        return [
            'ele' => $html,
            'lbltxt' => $labelText
        ];
    }



    /**
     * @param $request
     */
    public function checkEmployeeIdExist($request)
    {
        if ($request->employee_id) {
            $employee = Employee::find($request->employee_id);
            if (!$employee) {
                return redirect()->back()->with('fail', 'employee_id is not valid');
            }
        }
    }

    public function updateUserFromEmployee()
    {
        $url = "http://localhost/pwd/api/v1/employee";


        /*$client = new Client();

        $headers = [
            'Authorization' => 'Bearer 1|n3OLMZirYDxdtH1OuTItg6rTWMxxynrggfMbd8Fz'
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);*/
        //$response = Http::withDigestAuth('er_manojbisht@yahoo.com', 'Im123456')->get($url);
        $response = Http::withToken('1|n3OLMZirYDxdtH1OuTItg6rTWMxxynrggfMbd8Fz')->get($url);

        return $responseBody = json_decode($response->getBody());

        return view('projects.apiwithkey', compact('responseBody'));
    }

    public function permissionRelatedToJob($job_id)
    {
        if($job_id==5){
           return 102;
        }

        if($job_id==6){
           return 103;
        }
    }
}
