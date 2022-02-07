@component('mail::message')
Dear {{$reportingEmployee->name}}

@if('targetDutyType'==report)
{{$acr->employee->name}} has subitted his/her self appraisal on @mkbdate($acr->submitted_at).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if('targetDutyType'==review)
{{$acr->employee->name}}'s performance report has been reported by {{$acr->userOnBasisOfDuty('report')->name}} on @mkbdate($acr->report_on).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if('targetDutyType'==accept)
{{$acr->employee->name}}'s performance report has been reviewed by {{$acr->userOnBasisOfDuty('review')->name}} on @mkbdate($acr->review_on).
Please visit your inbox section at HRMS/Track AR portal.
@endif

@if('targetDutyType'==submit)
Your performance report has been acccepted by {{$acr->userOnBasisOfDuty('accept')->name}} on @mkbdate($acr->accept_on).
Please visit your 'myacr' section .
@endif

ACR Period : {{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}

You are hereby intimated for futher action.

@component('mail::panel')
You may visit following link.
<br>
@component('mail::button', ['url' => route('employee.home')])
HRMS
@endcomponent


 <small>
@component('mail::button', ['url' => config('site.dmsSiteBaseAddress').'/index.php/download/128-website-software-trainning-material/1276-subscribe-telegram-bot-for-pwd-alerts','color' => 'green'])
Trainning content for ACR process
@endcomponent
</small>
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
