<?php

namespace App\Http\Controllers\Employee\OthersAcr;

use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use App\Models\Employee;
use App\Models\Office;
use App\Traits\Acr\AcrFormTrait;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcrLegacyController extends Controller
{

    use OfficeTypeTrait, AcrFormTrait;

    /**
     * @var mixed
     */
    protected $user;
    protected $msg403 = 'Unauthorized action.You are not authorised to procees this ACR ';

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
     * @param $id
     * $id => Instance Id
     * To create legacy Acr
     */
    public function legacyIndex($office_id)
    {
        /*if ($office_id != 0) {
            abort_if(!$this->user->canDoJobInOffice('create-others-acr-job', $office_id), 403, 'You are Not Allowed to view this Office Employees');
        }*/
        // $allowed_Offices = Office::pluck('name','id');
        //$allowed_Offices = $this->user->OfficeToAnyJob(['create-others-acr-job']);

        switch ($office_id) {
            case '2':
                $legacyAcrs = Acr::where('acr_type_id', 0)->with(['office', 'employee', 'employee.designation'])->get();
                break;
            case '0':
                $office_id = $this->user->employee->office_idd;
                $legacyAcrs =  $legacyAcrs = Acr::where('acr_type_id', 0)->where('office_id', $office_id)->with(['office', 'employee', 'employee.designation'])->get();       //->with(['employee','employee.designation'])       
                break;
            default:
                $legacyAcrs = Acr::where('acr_type_id', 0)->where('office_id', $office_id)->with(['office', 'employee', 'employee.designation'])->get();       //->with(['employee','employee.designation'])       
                break;
        }

        $Offices = Office::select('name', 'id')->orderBy('name')->get();

        return view('employee.acr.create_legacy_acr', compact('legacyAcrs', 'Offices', 'office_id'));
    }

    /**
     * @param $request
     * To Store Indivitual Legacy ACR
     */
    public function legacystore(Request $request)
    {
        // validate appraisal_officer_type
        // todo office allowed,job allowed
        if ($request->has("is_Final_Acr")) {
            $this->validate(
                $request,
                [
                    'office_id' => 'required',
                    'acr_type_id' => 'required',
                    'from_date' => 'required|date', // |before:"2022-04-01
                    'to_date' => 'required|date|after_or_equal:from_date', // |before:"2022-04-01
                    'employee_id' => 'required',
                    'employee_id' => 'required',
                    'report_no' => 'nullable|numeric',
                    'review_no' => 'nullable|numeric',
                    'accept_no' => 'nullable|numeric',
                    'report_integrity' => 'required',
                    'appraisal_note_1' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
                    'appraisal_note_2' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
                    'appraisal_note_3' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
                    'report_remark' => 'nullable'
                ]
            );
        } else {
            $this->validate(
                $request,
                [
                    'office_id' => 'required',
                    'acr_type_id' => 'required',
                    'from_date' => 'required|date', // |before:"2022-04-01'
                    'to_date' => 'required|date|after_or_equal:from_date', // |before:"2022-04-01'
                    'employee_id' => 'required',
                    'employee_id' => 'required',
                    'report_no' => 'nullable|numeric',
                    'review_no' => 'nullable|numeric',
                    'accept_no' => 'nullable|numeric',
                    'report_integrity' => 'required',
                    'appraisal_note_1' => 'nullable',
                    'appraisal_note_2' => 'nullable',
                    'appraisal_note_3' => 'nullable',
                    'report_remark' => 'nullable'
                ]
            );
        }

        $employee = Employee::findOrFail($request->employee_id);
        $start = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
        $end = Carbon::createFromFormat('Y-m-d', $request->to_date)->startOfDay();

        $result = $employee->checkAcrDateInBetweenPreviousACRFilled($start, $end);

        if (!$result['status']) {
            return Redirect()->back()->with('fail', $result['msg']);
        }

        $request->merge([
            'submitted_at' => $request->to_date,
            'report_on' => $request->to_date,
            'review_on' => $request->to_date,
            'accept_on' => $request->to_date,
            'good_work' => 'Legacy data of  ' . $employee->shriName . '. has been filled ',
        ]);

        $acr = Acr::create($request->all());
        return redirect(route('acr.others.legacy', ['office_id' => $acr->office_id]));
    }

    /**
     * @param $request
     * To Edit Indivitual Legacy ACR
     */
    public function editLegacyAcr(Acr $acr)
    {
        
        abort_if($acr->acr_type_id != 0, 403, 'Only legacy unprocessed ACR can only be edited here...'); //todo is it needed
        abort_if(($acr->appraisal_note_1 || $acr->appraisal_note_2 || $acr->appraisal_note_3 ||
            $acr->report_no || $acr->review_no || $acr->accept_no), 403, 'ACR is already finalized, can not be edited...'); //todo is it needed

        $Offices = Office::select('name', 'id')->orderBy('name')->get();
        $creater = $this->user;

        return view('employee.acr.edit_legacy_acr', compact('acr', 'Offices', 'creater'));
       // return view('employee.other_acr.edit', compact('acr', 'Offices', 'creater'));
    }


    /**
     * @param $request
     * To Update Indivitual Legacy ACR
     */
    public function updateLegacyAcr(Request $request)
    {
      
        $acr = Acr::findOrFail($request->acr_id);

        //abort_if($this->user->employee_id <> $acr->employee_id, 403, $this->msg403);
        abort_if(($acr->appraisal_note_1 || $acr->appraisal_note_2 || $acr->appraisal_note_3 ||
            $acr->report_no || $acr->review_no || $acr->accept_no), 403, 'ACR is already finalized, can not be edited...'); //todo is it needed

        $this->validate(
            $request,
            [
                'report_integrity' => 'nullable',
                'report_no' => 'nullable|numeric',
                'review_no' => 'nullable|numeric',
                'accept_no' => 'nullable|numeric',
                'appraisal_note_1' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
                'appraisal_note_2' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
                'appraisal_note_3' => "required|min:2|regex:/^[0-9A-Za-z. \s,'-]*$/",
            ]
        );

        $acr->update($request->all());
        
        $acr->employee->updateMissing();
        return redirect(route('acr.others.legacy', ['office_id' => $acr->office_id]));
    }
}
