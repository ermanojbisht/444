<?php

namespace App\Models\Acr;

use App\Mail\Acr\AcrSumittedMail;
use App\Models\Acr\AcrNotification;
use App\Models\Acr\AcrType;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;
use App\Notifications\Acr\AcrSubmittedNotification;
use Auth;
use Carbon\CarbonPeriod;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Acr extends Model
{
    /**
     * @var string
     */
    protected $table = 'acrs';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_id', 'acr_type_id', 'office_id', 'from_date', 'to_date', 'prpoerty_return_date',
        'good_work', 'difficultie', 'appreciations', 'submitted_at',
        'report_employee_id', 'review_employee_id', 'accept_employee_id',
        'is_active', 'appraisal_note_1', 'appraisal_note_2', 'appraisal_note_3',
        'professional_org_membership', 'property_filing_return_at', 'report_duration_lapsed',
        'review_duration_lapsed', 'accept_duration_lapsed',
        'report_no', 'report_on', 'report_remark',
        'review_no', 'review_on', 'review_remark',
        'accept_no', 'accept_on', 'accept_remark'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'from_date', 'to_date', 'property_filing_return_at', 'submitted_at', 'report_on', 'review_on', 'accept_on'
    ];

    /**
     * @return mixed
     */
    public function acrMasterParameters()
    {
        return $this->hasMany(AcrMasterParameter::class, 'acr_type_id', 'acr_type_id');
    }

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->belongsTo(AcrType::class, 'acr_type_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getTypeNameAttribute()
    {
        if ($this->type) {
            return $this->type->description;
        }

        return 'Defaulter\'s ACR';
    }

    /**
     * @return mixed
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /**
     * @return mixed
     */
    public function personalAttributes()
    {
        return $this->hasMany(AcrPersonalAttribute::class);
    }

    /**
     * at what level acr is , submit means acr is submitted and reporting is pending
     * @param  $query
     * @param  $value
     * @return mixed
     */
    public function scopeLevel($query, $value = 'submit')
    {
        $query = $query->whereNotNull('report_employee_id')->whereNotNull('review_employee_id')->whereNotNull('accept_employee_id')->whereNotNull('submitted_at')->whereIsActive(1);
        switch ($value) {
            case 'submit':
                return $query->whereNull('report_on')
                    ->orderBy('submitted_at');
                break;
            case 'report':
                return $query->whereNull('review_on')
                    ->whereNotNull('report_on')
                    ->orderBy('report_on');
                break;
            case 'review':
                return $query->whereNull('accept_on')
                    ->whereNotNull('review_on')
                    ->orderBy('review_on');
                break;
            case 'accept':
                return $query->whereNotNull('accept_on')
                    ->orderBy('accept_on');
                break;
        }
    }

    /**
     * @param $scope
     * @param $attributes
     */
    public function isScope($scope, ...$attributes)
    {
        return static::$scope(...$attributes)->where($this->getKeyName(), $this->getKey())->exists();
    }

    /**
     * The roles that belong to the Acr
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appraisalOfficers()
    {
        return $this->belongsToMany(Employee::class, 'appraisal_officers', 'acr_id', 'employee_id')
            ->withPivot('appraisal_officer_type', 'from_date', 'to_date', 'is_due');
    }

    /**
     * @return mixed
     */
    public function appraisalOfficerRecords()
    {
        return $this->hasMany(AppraisalOfficer::class);
    }

    /**
     * @param $start
     * @param $end
     */
    public function checkisDateInBetween($start, $end)
    {
        $acrPeriodStartDate = $this->from_date;
        $acrPeriodEndDate = $this->to_date;
        //$start<$end //return with msg "start/from date can not be less then end/to date"
        if ($start > $end) {
            return ['status' => false, 'msg' => 'From date '.$start->format('d M y').' can not be less then To date'.$end->format('d M y')];
        }
        //$start,$end within $acrPeriodStartDate,$acrPeriodEndDate //start and end date should be within ACR period as mentioned by you

        if (!$start->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'From date '.$start->format('d M y').' is beyond the ACR period ('.$acrPeriodStartDate->format('d M y').' - '.$acrPeriodEndDate->format('d M y').' )'];
        }

        if (!$end->betweenIncluded($acrPeriodStartDate, $acrPeriodEndDate)) {
            return ['status' => false, 'msg' => 'To date '.$end->format('d M y').' is beyond the ACR period ('.$acrPeriodStartDate->format('d M y').' - '.$acrPeriodEndDate->format('d M y').' )'];
        }

        return ['status' => true, 'msg' => ''];
    }

    /**
     * @param $start
     * @param $end
     * @param $appraisal_officer_type
     */
    public function checkPeriodInput($start, $end, $appraisal_officer_type)
    {
        $this->checkisDateInBetween($start, $end);

        //same officer level it should not intersect // period overlaps with previos line at record no
        $otherRecords = $this->appraisalOfficerRecords()->where('appraisal_officer_type', $appraisal_officer_type)->get();
        foreach ($otherRecords as $record) {
            $recordPeriod = CarbonPeriod::create($record->from_date, $record->to_date);
            if ($recordPeriod->overlaps($start, $end)) {
                return ['status' => false, 'msg' => 'Given period ('.$start->format('d M y').' - '.
                    $end->format('d M y').') intersect with period ( '.
                    $record->from_date->format('d M y').' - '.$record->to_date->format('d M y').
                    ' ) in our record Employee ID = '.$record->employee_id];
            }
            //if old record has already period for 90 days then revert
            if ($recordPeriod->count() >= 90) {
                return ['status' => false, 'msg' => 'Period ( '.$record->from_date->format('d M y').' - '.
                    $record->to_date->format('d M y').' ) in our Employee ID='.$record->employee_id.
                    ' already has '.$recordPeriod->count().' days'];
            }
        }

        return ['status' => true, 'msg' => ''];
    }

    /**
     * @param  $appraisal_officer_type
     * @return mixed
     */
    public function hasAppraisalOfficer($appraisal_officer_type)
    {
        return $this->appraisalOfficers()->wherePivot('appraisal_officer_type', $appraisal_officer_type)->count();
    }

    public function isSubmitted()
    {
        return ($this->submitted_at) ? true : false;
    }

    /**
     * @param $appraisal_officer_type
     */
    public function updateIsDue($appraisal_officer_type)
    {
        $records = $this->appraisalOfficerRecords()->whereAppraisalOfficerType($appraisal_officer_type)->orderBy('from_date')->get();
        $responsible_employee_id = '';
        foreach ($records as $key => $record) {
            //Log::info(print_r($record, true));

            if ($record->from_date->diffInDays($record->to_date) >= 90 && $responsible_employee_id === '') {
                $record->is_due = 1;
                $responsible_employee_id = $record->employee_id;
            } else {
                if ($record->to_date == $this->to_date) {
                    //if last record to_date is same as period last date then although acr is not due but still responsible officer will be last person
                    $record->is_due = 0;
                    $responsible_employee_id = $record->employee_id;
                } else {
                    $record->is_due = 0;
                }
            }

            $record->save();
        }
        $this->update([config('acr.basic.acrProcessFields')[$appraisal_officer_type] => $responsible_employee_id]);
    }

    /**
     * @return mixed
     */
    public function filledparameters()
    {
        return $this->hasMany(AcrParameter::class);
    }

    /**
     * @return mixed
     */
    public function fillednegativeparameters()
    {
        return $this->hasMany(AcrNegativeParameter::class);
    }

    /**
     * @return mixed
     */
    public function type1RequiremntsWithFilledData()
    {
        $filledparameters = $this->filledparameters()->get()->keyBy('acr_master_parameter_id');
        $requiredParameters = $this->acrMasterParameters()->where('type', 1)->get();
        $requiredParameters->map(function ($row) use ($filledparameters) {
            if (isset($filledparameters[$row->id])) {
                $row->user_target = $filledparameters[$row->id]->user_target;
                $row->user_achivement = $filledparameters[$row->id]->user_achivement;
                $row->status = $filledparameters[$row->id]->status;
                $row->applicable = $filledparameters[$row->id]->is_applicable;
                $row->reporting_marks = $filledparameters[$row->id]->reporting_marks;
                $row->reviewing_marks = $filledparameters[$row->id]->reviewing_marks;
            } else {
                $row->user_target = $row->user_achivement = $row->status = 0;
            }

            return $row;
        });

        return $requiredParameters->groupBy('config_group');
    }

    /**
     * @return mixed
     */
    public function type2RequiremntsWithFilledData()
    {
        $filledparameters = $this->filledparameters()->get()->keyBy('acr_master_parameter_id');
        $requiredParameters = $this->acrMasterParameters()->where('type', 0)->get();
        $requiredParameters->map(function ($row) use ($filledparameters) {
            if (isset($filledparameters[$row->id])) {
                $row->reporting_marks = $filledparameters[$row->id]->reporting_marks;
                $row->reviewing_marks = $filledparameters[$row->id]->reviewing_marks;
            } else {
                $row->reporting_marks = $row->reviewing_marks = 0;
            }

            return $row;
        });

        return $requiredParameters;
        //return $requiredParameters->groupBy('config_group');
    }

    /**
     * @return mixed
     */
    public function negative_groups()
    {
        $require_negative_parameters = $this->acrMasterParameters()->where('type', 0)->get()->keyBy('id');
        $filled_negative_parameters = $this->fillednegativeparameters()->get()->groupBy('acr_master_parameter_id');
        $require_negative_parameters->map(function ($row) use ($filled_negative_parameters) {
            if (isset($filled_negative_parameters[$row->id])) {
                $row->user_filled_data = $filled_negative_parameters[$row->id];
            } else {
                $row->user_filled_data = [];
            }

            return $row;
        });

        return $require_negative_parameters->groupBy('config_group');
    }

    /**
     * @return mixed
     */
    public function peronalAttributeSWithMasterData()
    {
        $personalAttributes = $this->personalAttributes()->get()->keyBy('personal_attribute_id');

        return AcrMasterPersonalAttributes::all()->map(function ($row) use ($personalAttributes) {
            if (isset($personalAttributes[$row->id])) {
                $row->reporting_marks = $personalAttributes[$row->id]->reporting_marks;
                $row->reviewing_marks = $personalAttributes[$row->id]->reviewing_marks;
            } else {
                $row->reporting_marks = $row->reviewing_marks = 0;
            }

            return $row;
        });
    }

    public function getPdfFilePathAttribute()
    {
        return 'acr/'.$this->employee_id.'/'.$this->id.'.pdf';
    }

    /**
     * @return mixed
     */
    public function getGradeAttribute()
    {
        $marks = $this->accept_no;
        switch (true) {
            case ($marks > 80.0):
                {
                    $grades = 'Out Standing';
                    break;
                }
            case ($marks > 60.0 && $marks <= 80.0):
                {
                    $grades = 'Very Good';
                    break;
                }
            case ($marks > 40.0 && $marks <= 60.0):
                {
                    $grades = 'Good';
                    break;
                }
            case ($marks > 20.0 && $marks <= 40.0):
                {
                    $grades = 'Satisfactory';
                    break;
                }
            case ($marks <= 20.0):
                {
                    $grades = 'Unsatisfactory';
                    break;
                }
            default:{
                    $grades = 'Unknown / Not decided';
                    break;
                }
        }

        return $grades;
    }

    public function getIsSinglePageAttribute()
    {
        return in_array($this->acr_type_id, config('acr.basic.acrWithoutProcess'));
    }

    public function getPdfFullFilePathAttribute()
    {
        return \Storage::disk('public')->path($this->pdf_file_path);
    }

    public function isFileExist()
    {
        return \Storage::disk('public')->exists($this->pdf_file_path);
    }

    /**
     * @return mixed
     */
    public function submitUser()
    {
        return $this->userOnBasisOfDuty('submit');
    }

    /**
     * @return mixed
     */
    public function reportUser()
    {
        return $this->userOnBasisOfDuty('report');
    }

    /**
     * @return mixed
     */
    public function reviewUser()
    {
        return $this->userOnBasisOfDuty('review');
    }

    /**
     * @return mixed
     */
    public function acceptUser()
    {
        return $this->userOnBasisOfDuty('accept');
    }

    /**
     * @param $dutyType
     */
    public function userOnBasisOfDuty($dutyType)
    {
        $target_employee_field = config('acr.basic.duty')[$dutyType]['targetemployee'];
        $target_employee_id = $this->$target_employee_field;
        if ($target_employee_id) {
            return User::where('employee_id', $target_employee_id)->first();
        }

        return false;
    }

    /**
     * @param $pdf
     * @param $forced
     */
    public function createPdfFile($pdf, $forced = true)
    {
        //Log::info("in acr createPdfFile  ");
        //$fullpath=\Storage::disk('public')->path($this->pdf_file_path);
        if ($forced || (!$this->isFileExist())) {
            $path = $this->pdf_file_path;
            File::ensureDirectoryExists(dirname($this->pdfFullFilePath), $mode = 0755, $recursive = true);
            if ($this->isFileExist()) {
                \Storage::disk('public')->delete($path);
            }
            $pdf->save(\Storage::disk('public')->path($path));
        }
    }

    public function submitNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'report', $notification_type = 2);
    }

    public function reportNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'review', $notification_type = 3);
    }

    public function reviewNotification()
    {
        $this->mailNotificationFor($targetDutyType = 'accept', $notification_type = 4);
    }

    public function acceptNotification()
    {
        //now target is submit beacause it's just back to user
        $this->mailNotificationFor($targetDutyType = 'submit', $notification_type = 5);
    }

    public function rejectNotification()
    {
        // on reject targetduty is againsubmit or rejecr itself
        $this->mailNotificationFor($targetDutyType = 'reject', $notification_type = 6);
    }

    /**
     * @param $targetDutyType
     * @param $notification_type
     */
    public function mailNotificationFor($targetDutyType, $notification_type)
    {
        $targetEmployee = $this->userOnBasisOfDuty($targetDutyType);
        if ($targetEmployee) {
            //check if already notified
            $previousNotification = AcrNotification::where('employee_id', $targetEmployee->employee_id)
                ->where('acr_id', $this->id)
                ->where('through', 1) //for mail , may be 2 for sms
                ->where('notification_type', $notification_type) //2=for report
                ->orderBy('notification_on', 'DESC')->first();

            if (!$previousNotification) {
                $mail = Mail::to($targetEmployee);
                if ($targetEmployee->chat_id > 90000) {
                    $response = $targetEmployee->notify(new AcrSubmittedNotification($this, $targetEmployee, $targetDutyType));
                }

                switch ($targetDutyType) {
                    case 'report':
                        //on submit event  , report is targeted
                        //reportUser is as target
                        $mail->cc($this->submitUser());
                        break;
                    case 'review':
                        //on report event , review is targeted
                        //review is as target
                        $mail->cc($this->userOnBasisOfDuty('report'));
                        //$mail->cc($this->submitUser());
                        break;
                    case 'accept':
                        //on review event , accept is targeted
                        //accept user is as target
                        $mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        //$mail->cc($this->submitUser());
                        break;

                    case 'submit':
                        //on accept event , submituser is targeted
                        //$mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        $mail->cc($this->userOnBasisOfDuty('accept'));
                        break;

                    case 'reject':
                        //on reject event , submituser is targeted
                        //$mail->cc($this->userOnBasisOfDuty('review'));
                        //$mail->cc($this->userOnBasisOfDuty('report'));
                        $mail->cc([$this->userOnBasisOfDuty('review'), $this->userOnBasisOfDuty('report'), $this->userOnBasisOfDuty('accept')]);
                        break;
                }
                $mail->send(new AcrSumittedMail($this, $targetEmployee, $targetDutyType));

                $data = [
                    'employee_id' => $targetEmployee->employee_id,
                    'acr_id' => $this->id,
                    'notification_on' => now(),
                    'through' => 1,
                    'notification_type' => $notification_type,
                    'notification_no' => 1
                ];
                AcrNotification::create($data);
            }
        }
    }

    /**
     * @return mixed
     */
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * @param  $Officer_type
     * @return mixed
     */
    public function report_review_Accept_officers($Officer_type)
    {
        return $this->belongsTo(Employee::class, $Officer_type.'_employee_id', 'id')->first();
    }

    public function firstFormData()
    {
        $employee = Employee::findOrFail($this->employee_id);
        $appraisalOfficers = $this->appraisalOfficers()->get();

        $officeWithParentList = Office::ancestorsAndSelf($this->office_id)->pluck('name', 'office_type')->reverse()->toArray();

        if (count($officeWithParentList) > 1) {
            array_pop($officeWithParentList);
        }

        $leaves = Leave::where('acr_id', $this->id)->get();
        $appreciations = Appreciation::where('acr_id', $this->id)->get();

        $inbox = Acr::whereNotNull('submitted_at')->where('report_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNull('report_on')->get();

        $reviewed = Acr::whereNotNull('submitted_at')->where('review_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNull('review_on')->get();
        $accepted = Acr::whereNotNull('submitted_at')->where('accept_employee_id', $this->employee_id)
            ->where('is_active', 1)->whereNotNull('report_on')->whereNotNull('review_on')->whereNull('accept_on')->get();

        return [$employee, $appraisalOfficers, $leaves, $appreciations, $inbox, $reviewed, $accepted, $officeWithParentList];
    }

    /**
     * @param $dutyType
     */
    public function updateEsclationFor($dutyType)
    {
        $duty = config('acr.basic.duty')[$dutyType];
        $duty_duration_lapsed_field = $dutyType.'_duration_lapsed';
        $duty_triggerDate = $duty['triggerDate'];
        $this->$duty_duration_lapsed_field = round($this->$duty_triggerDate->diffInDays(now(), false) / $duty['period'] * 100, 0);
        if ($this->$duty_triggerDate->diffInDays(now(), false) > $duty['period']) {
            $finalDateField = $dutyType.'_on';
            $this->$finalDateField = now();
        }
        $this->save();
    }

    public function checkSelfAppraisalFilled()
    {
        // check table 1
        if (in_array($this->acr_type_id, config('acr.basic.acrWithoutProcess')) == false) {
            if (AcrParameter::where('acr_id', $this->id)->count() == 0) {
                return ['status' => false, 'msg' => 'Self-Appraisal Not Filled for this ACR '];
            }
        } else {
            if (!$this->good_work) {
                return ['status' => false, 'msg' => 'Self-Appraisal Not Filled for this ACR '];
            }
        }

        return ['status' => true, 'msg' => ''];
    }

    public function permissionForPdf()
    {
        $user = Auth::user();

        if ($user->hasPermissionTo(['acr-special']) || ($user->employee_id == $this->employee_id)) {
            return true;
        }

        if ($user->employee_id == $this->report_employee_id && (!$this->report_on)) {
            return true;
        }

        if ($user->employee_id == $this->review_employee_id && (!$this->review_on)) {
            return true;
        }

        if ($user->employee_id == $this->accept_employee_id && (!$this->accept_on)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function rejectionDetail()
    {
        return $this->hasOne(AcrRejection::class);
    }

    /**
     * @return mixed
     */
    public function rejectUser()
    {
        if ($this->rejectionDetail) {
            $user = User::where('employee_id', $this->rejectionDetail->employee_id)->first();
            if ($user) {
                return $user;
            }
        }

        return (new User);
    }

    /**
     * @return mixed
     */
    public function status()
    {
        if ($this->is_active == 0) {
            $rejection = $this->rejectionDetail()->first();
            $rejection_Reason = ' Rejected By ';
            if (!$this->report_on) {
                $rejection_Reason = $rejection_Reason.' Reporting Officer ';
            } else if (!$this->review_on) {
                $rejection_Reason = $rejection_Reason.'Reporting Officer ';
            } else if (!$this->accept_on) {
                $rejection_Reason = $rejection_Reason.'Reporting Officer ';
            }

            return $rejection_Reason.$this->rejectUser()->name.' on '.$rejection->created_at->format('d M Y');
        } else if ($this->accept_on) {
            return 'Accepted on '.$this->accept_on->format('d M Y');
        } else if ($this->review_on) {
            return 'Reviewed on '.$this->review_on->format('d M Y');
        } else if ($this->report_on) {
            return 'Reported on '.$this->report_on->format('d M Y');
        } else if ($this->submitted_at) {
            return 'Submitted on '.$this->submitted_at->format('d M Y');
        } else {
            return 'New Created';
        }
    }

    public function status_bg_color()
    {
        if ($this->is_active == 0) {
            return 'bg-danger bg-gradient ';
        } else if ($this->accept_on) {
            return 'bg-success bg-gradient  ';
        } else if ($this->review_on) {
            return 'bg-info bg-gradient ';
        } else if ($this->report_on) {
            return 'bg-primary bg-gradient ';
        } else if ($this->submitted_at) {
            return 'bg-info bg-gradient ';
        } else {
            return ' bg-info bg-gradient';
        }
    }

    /**
     * @return mixed
     */
    public function analysisForAlert()
    {
        $result = ['name' => $this->employee->name, 'employee_id' => $this->employee_id, 'target_employee_id' => '', 'pending_process' => '', 'percentage_period' => ''];

        $duties = ['report', 'review', 'accept'];
        foreach ($duties as $key => $duty) {
            $duration_lapsed_field = $duty.'_duration_lapsed';
            $targetEmployee_field = $duty.'_employee_id';
            if ($this->$duration_lapsed_field > 0) {
                $targetEmployee = $this->$targetEmployee_field;
                $targetProcess = $duty;
                $lapsedPeriod = $this->$duration_lapsed_field;
            }
        }

        $result['target_employee_id'] = $targetEmployee;
        $result['pending_process'] = $targetProcess;
        $result['percentage_period'] = $lapsedPeriod;

        return $result;
    }
}
