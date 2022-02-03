<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acr\StoreAcrRequest;
use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrNotification;
use App\Models\Employee;
use App\Models\User;
use App\Traits\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
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
        return view('employee.acr.create', compact('employee','Officetypes','acrGroups'));
    }

    /**
     * @param $request 
     * To Store Indivitual ACR
     */
    public function store(StoreAcrRequest $request)
    {
        $acr = Acr::create($request->validated());
        return redirect(route('acr.myacrs'));
    }


    public function addOfficers (Acr $acr)
    {
        //$this->submitNotification($acr);
        $appraisalOfficers =  $acr->appraisalOfficers()->get();

        return view('employee.acr.add_officers', compact('acr','appraisalOfficers'));
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

        if($this->user->employee_id == $request->appraisal_officer_type)
        {
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
        $this->submitNotification($acr);
        return redirect()->back();
    }

    public function submitNotification($acr)
    {
        $acruser=User::where('employee_id',$acr->employee_id)->first();        
            $reporting_employee_id=$acr->report_employee_id;
            if($reporting_employee_id){
                $reportingEmployee=User::where('employee_id',$reporting_employee_id)->first();
                if($reportingEmployee){
                    $previousNotification=AcrNotification::where('employee_id',$reportingEmployee->employee_id)
                    ->where('acr_id',$acr->id)
                    ->where('through',1)
                    ->where('notification_type',2)
                    ->orderBy('notification_on','DESC')->first();

                    if(!$previousNotification){
                        Mail::to($reportingEmployee)
                        ->cc($acruser)
                        ->send(new AcrSumittedMail($acr,$reportingEmployee));

                        $data=[
                        'employee_id'=>$reportingEmployee->employee_id,
                        'acr_id'=>$acr->id,
                        'notification_on'=>now(),
                        'through'=>1,
                        'notification_type'=>2,
                        'notification_no'=>1
                        ];
                        AcrNotification::create($data);
                    }
                }
            }

    }

    public function show(Acr $acr) {

        //return view('employee.acr.show',compact('acr'));
        $dataArray=['acr'=>$acr];
        $pdf= SPDF::loadview('employee.acr.show',compact('acr'));
        $pdf->setOption('cover', View::make('employee.acr.pdfcoverpage', $dataArray));
       /* $pdf->setOption('margin-top',0);
        $pdf->setOption('margin-bottom',10);
        $pdf->setOption('margin-left',0);
        $pdf->setOption('margin-right',0);*/

        $pdf->setOption('footer-html',  View::make('employee.acr.pdffooter'));
        $pdf->setOption('footer-right', '[page]');
        //$pdf->setOption('footer-line');

        return $pdf->stream('view.pdf');
    }
       
}


