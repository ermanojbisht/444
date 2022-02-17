@component('mail::message')
# Introduction

The body of your message.
@foreach($userPendingAcrs as $acr)
{{$acr->employee_id}}  {{$acr->pending_process}} {{$acr->percentage_period}}
@endforeach
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
