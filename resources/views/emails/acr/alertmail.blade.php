@component('mail::message')
Dear {{$targetUser->shriName}}
@component('mail::panel')
Following ACRs are pending with you

@component('mail::table')
| #    | Name    | Employee Id| Process| % time elapsed|Retirement Issue,If Any|
| ---- |:-------:|:----------:|:------:|:-------------:|:-------------:|
@foreach($userPendingAcrs as $acr)
|{{$loop->iteration}}|{{$acr['name']}}|{{$acr['employee_id']}}|{{$acr['pending_process']}}|{{$acr['percentage_period']}}|{{$acr['retirement_issue']}}|
@endforeach
@endcomponent
@endcomponent

Please go through the HRMS web portal and if you have processed above ACR then ignore this message

Thanks,<br>
{{ config('app.name') }}
@endcomponent
