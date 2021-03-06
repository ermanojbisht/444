@component('mail::message')
Dear {{$reportingEmployee->shriName}}

@if($targetDutyType=='acknowledge')
{{$acr->employee->shriName}} .  {{$msg}}.
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if($targetDutyType=='report')
{{$acr->employee->shriName}} has submitted his/her self appraisal on @mkbdate($acr->submitted_at).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if($targetDutyType=='review')
{{$acr->employee->shriName}}'s performance report has been reported by {{$acr->userOnBasisOfDuty('report')->shriName}} on @mkbdate($acr->report_on).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if($targetDutyType=='accept')
{{$acr->employee->shriName}}'s performance report has been reviewed by {{$acr->userOnBasisOfDuty('review')->shriName}} on @mkbdate($acr->review_on).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if($targetDutyType=='correctnotice')
{{$acr->employee->shriName}}'s performance report has been corrected on @mkbdate($acr->updated_at).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if($targetDutyType=='submit')
@if($acr->isTwoStep)
Your performance report has been reviewed by {{$acr->userOnBasisOfDuty('review')->shriName}} on @mkbdate($acr->review_on).
Please visit your 'myacr' section .
@else
Your performance report has been acccepted by {{$acr->userOnBasisOfDuty('accept')->shriName}} on @mkbdate($acr->accept_on).
Please visit your 'myacr' section .
@endif
@endif

@if($targetDutyType=='reject')
Your performance report has been rejected by {{$acr->rejectUser()->shriName }} on @mkbdate($acr->rejectionDetail->created_at).
Comment By rejection authority : {{$acr->rejectionDetail->remark}}
Please visit your 'myacr' section and recreate your acr .
@endif

ACR Period : {{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}

You are hereby intimated for futher action.
Please follow relevent orders to follow the appraisal process.

@component('mail::panel')
You may visit following link.
<br>
@component('mail::button', ['url' => route('employee.home')])
HRMS
@endcomponent

@component('mail::button', ['url' => config('site.dmsSiteBaseAddress').'/index.php/category/288','color' => 'green'])
Trainning content for ACR process
@endcomponent

@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent