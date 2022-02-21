@component('mail::message')
Dear {{$targetUser->shriName}}
@component('mail::panel')
Following ACRs are pending with you

@component('mail::table')
| #    | Name    | Employee Id| Process| % time elapsed|
| ---- |:-------:|:----------:|:------:|:-------------:|
@foreach($userPendingAcrs as $acr)
|{{$loop->iteration}}|{{$acr['name']}}|{{$acr['employee_id']}}|{{$acr['pending_process']}}|{{$acr['percentage_period']}}|
@endforeach
@endcomponent
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
