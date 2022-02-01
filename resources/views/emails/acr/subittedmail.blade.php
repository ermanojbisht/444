@component('mail::message')
Dear {{$reportingEmployee->name}}

{{$acr->employee->name}} has subitted his/her ACR .

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
