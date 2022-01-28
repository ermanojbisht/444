@component('mail::message')
{{$greeting}} <br>
@component('mail::panel')
{{$alert_for}}<br>
<b>{{$work_name}}</b><br><br>
{{$subject}}<br>
Details are:<br>
Refference no:{{$refference_no}}<br>
Issuing authority:{{$issuing_authority}}<br>
contractor details::{{$contractor_details}}<br>
Amount In Lakh::{{$amount}}<br>
Valid upto:{{$valid_upto}}<br>
@endcomponent
<small>{{$closing_lines}}</small>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
