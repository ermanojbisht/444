<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrLeaveRequest;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Jobs\Acr\MakeAcrPdfOnSubmit;
use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrMasterPersonalAttributes;
use App\Models\Acr\AcrNotification;
use App\Models\Acr\AcrPersonalAttribute;
use App\Models\Acr\AcrType;
use App\Models\Acr\Appreciation;
use App\Models\Acr\Leave;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use DPDF;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Log;
use SPDF;

class AcrController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

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
     *   
     * To View All ACR Created by logged in Employee
     */
    public function index()
    {
        
        $acrs = Acr::where('employee_id', '=', $this->user->employee_id)->get();

        return view('employee.acr.my_acr', compact('acrs'));
    }

    /**
     * @param $id
     * $id => Instance Id
     * To create Acr
     */
    public function create()
    {
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();

        return view('employee.acr.create', compact('employee', 'Officetypes', 'acrGroups'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    {
        Acr::create($request->validated());

        return redirect(route('acr.myacrs'));
    }


    public function edit(Acr $acr)
    {
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, can not be edited...');
        }

        $acr_selected_group_type = AcrType::where('id', $acr->acr_type_id)->select('description as name', 'group_id', 'id')->first();
        $acr_Types = AcrType::where('group_id', $acr_selected_group_type->group_id)->select('description as name', 'id')->get();
        $acr_office = Office::where('id', $acr->office_id)->select('office_type', 'name', 'id')->first();
        $Offices = Office::select('name', 'id')->get();
        $employee = Employee::findOrFail($this->user->employee_id);
        $Officetypes = $this->defineOfficeTypes();
        $acrGroups = $this->defineAcrGroup();

        return view('employee.acr.edit', compact(
            'acr',
            'acr_selected_group_type',
            'acr_Types',
            'acr_office',
            'Offices',
            'employee',
            'Officetypes',
            'acrGroups'
        ));
    }

    public function update(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);

        $acr->update([
            'acr_group_id' => $request->acr_group_id,
            'acr_type_id' => $request->acr_type_id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'office_id' => $request->office_id,
            'property_filing_return_at' => $request->property_filing_return_at,
            'professional_org_membership' => $request->professional_org_membership
        ]);

        return redirect(route('acr.myacrs'));
    }


    public function showPart1(Acr $acr)
    {
        list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted) = $acr->firstFormData();

        return view('employee.acr.view_part1', compact(
            'acr',
            'employee',
            'appraisalOfficers',
            'leaves',
            'appreciations',
            'inbox',
            'reviewed',
            'accepted'
        ));
    }


    public function addOfficers(Acr $acr)
    {
        //$this->submitNotification($acr);
        $appraisalOfficers =  $acr->appraisalOfficers()->get();

        return view('employee.acr.add_officers', compact('acr', 'appraisalOfficers'));
    }

    public function addAcrOfficers(Request $request)
    {

        // validate appraisal_officer_type 
        $this->validate(
            $request,
            [
                'appraisal_officer_type' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'employee_id' => 'required' // in AppraisalOfficer acr_id , appraisal_officer_type, employee_id should not be repeated 
            ]
        );

        $acr = Acr::findOrFail($request->acr_id);
        $appraisal_officer_type = $request->appraisal_officer_type;

        if ($this->user->employee_id == $request->appraisal_officer_type) {
            return Redirect()->back()->with('fail', 'You cannot submit ACR to Yourself...');
        }

        $startDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result = $acr->checkPeriodInput($startDate, $endDate, $appraisal_officer_type); //  give ['status'=>true,'msg'=>'']

        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        $acr->appraisalOfficers()->attach($request->employee_id, array(
            'appraisal_officer_type' => $appraisal_officer_type,
            'from_date' => $request->from_date, 'to_date' => $request->to_date
        ));

        $acr->updateIsDue($appraisal_officer_type);
        return Redirect()->back()->with('success', 'Officer has been Added to ACR Successfully...');
    }

    public function deleteAcrOfficers(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus No Offcials can be deleted...');
        }
        $acr->appraisalOfficers()->wherePivot('appraisal_officer_type', $request->appraisal_officer_type)->detach();
        return Redirect()->back()->with('success', 'Officer deleted Successfully...');
    }


    public function submitAcr(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        $acr->update(['submitted_at' => now()]);
        dispatch(new MakeAcrPdfOnSubmit($acr, 'submit'));

        return redirect()->back();
    }




    public function show(Acr $acr)
    {
        //own or some admin
        if($this->user->hasPermissionTo(['acr-special']) || $this->user->employee_id==$acr->employee_id){

            if ($acr->isFileExist()) {
                return response()->file($acr->pdfFullFilePath);
            }else
            {
                return Redirect()->back()->with('fail', 'Acr File does not exist');
            }
        }
        return abort(403, 'Unauthorized action.You are not authorised to see this ACR details');


        $pages = array();
        //$data_groups = $acr->type1RequiremntsWithFilledData();
        //$pages[] = view('employee.acr.form.create1', compact('acr', 'data_groups'));

        //first page
        list($employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted) = $acr->firstFormData();
        $pages[] = view('employee.acr.view_part1', ['acr' => $acr, 'employee' => $employee, 'appraisalOfficers' => $appraisalOfficers, 'leaves' => $leaves, 'appreciations' => $appreciations, 'inbox' => $inbox, 'reviewed' => $reviewed, 'accepted' => $accepted]);

        $requiredParameters = $acr->type1RequiremntsWithFilledData()->first();
        $requiredNegativeParameters = $acr->type2RequiremntsWithFilledData();
        $personal_attributes =  $acr->peronalAttributeSWithMasterData();



        $view = true;

        if ($acr->isScope('level', 'review')) {
            //review
            $pages[] = view('employee.acr.form.appraisal2', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'view'));
        } else {
            if ($acr->isScope('level', 'report')) {
                //report
                $pages[] = view('employee.acr.form.appraisal', compact('acr', 'requiredParameters', 'personal_attributes', 'requiredNegativeParameters', 'view'));
            }
        }
        //accept


        //$pages[] = view('employee.acr.show', compact('acr'));


        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('cover', View::make('employee.acr.pdfcoverpage', compact('acr')));
        $pdf->setOption('footer-html',  view('employee.acr.pdffooter'));
        $pdf->loadHTML($pages);




        //View::make() & view() are same
        //$pdf= SPDF::loadView('employee.acr.form.create1',compact('acr','data_groups'));

        /*//loadFile can be authanticate url link
        return SPDF::loadFile(url('/cr/form/32/part1'))->inline('github.pdf');*/
        /*
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = DPDF::loadView('myPDF', $data);
        return $pdf->download('itsolutionstuff.pdf');*/
        //return $pdf->stream('view.pdf');
    }


    public function addLeaves(Acr $acr)
    {
        $leaves = Leave::where('acr_id', $acr->id)->get();
        return view('employee.acr.add_leaves', compact('acr', 'leaves'));
    }


    public function addAcrLeaves(StoreAcrLeaveRequest $request) // 
    {

        $acr = Acr::findOrFail($request->acr_id);

        $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result = $acr->checkisDateInBetween($start, $end);
        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        Leave::create($request->validated());

        return redirect(route('acr.addLeaves', ['acr' => $acr->id]))->with('success', 'Leave added Sucessfully');
    }



    public function deleteAcrLeaves(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus Leaves can not be deleted...');
        }
        Leave::find($request->leave_id)->delete();

        return Redirect()->back()->with('success', 'Leave deleted Successfully...');
    }

    public function addAppreciation(Acr $acr)
    {
        $appreciations = Appreciation::where('acr_id', $acr->id)->get();

        return view('employee.acr.add_Appreciation', compact('acr', 'appreciations'));
    }

    public function addAcrAppreciation(Request $request)
    {
        // validate Appreciation_request
        $this->validate(
            $request,
            [
                'acr_id' => 'required',
                'appreciation_type' => 'required',
                'detail' => 'required'
            ]
        );

        Appreciation::create($request->all());

        return redirect(route('acr.addAppreciation', ['acr' => $request->acr_id]))->with('success', 'Appreciation added Sucessfully');
    }

    public function deleteAcrAppreciation(Request $request)
    {
        $acr = Acr::findOrFail($request->acr_id);
        if ($acr->isSubmitted()) {
            return Redirect()->back()->with('fail', ' ACR is already Submitted, Thus Appreciations can not be deleted...');
        }
        Appreciation::find($request->appreciation_id)->delete();

        return Redirect()->back()->with('success', 'Appreciation deleted Successfully...');
    }
}
