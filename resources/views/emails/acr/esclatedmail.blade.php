@component('mail::message')
Dear {{$defaulterEmployee->shriName}}


@if($dutyType=='report')
{{$acr->employee->shriName}} has submitted his/her self appraisal on @mkbdate($acr->submitted_at).
But you have not reported this ACR within the prescribed timelimit hence it has been esclated to heigher authorties .
@endif

@if($dutyType=='review')
{{$acr->employee->shriName}}'s performance report has been reported by {{$acr->userOnBasisOfDuty('report')->shriName}} on @mkbdate($acr->report_on).
But you have not reviewed this ACR within the prescribed timelimit hence it has been esclated to heigher authorties .
@endif

@if($dutyType=='accept')
{{$acr->employee->shriName}}'s performance report has been reviewed by {{$acr->userOnBasisOfDuty('review')->shriName}} on @mkbdate($acr->review_on).
But you have not accepted this ACR within the prescribed timelimit hence it has been esclated to heigher authorties .
@endif

@if($dutyType=='submit')

You have not submitted your ACR within the prescribed timelimit hence it has been esclated to heigher authorties .

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
