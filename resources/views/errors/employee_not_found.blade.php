@extends('errors.layout')

@php
  $error_number = 404;
@endphp

@section('title')
  Page not found.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href='javascript:history.back()' >go back</a> or return to <a href='".url('')."'>our homepage</a>.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
  </br><small>Dear User this Employee Code does't exist</small>
   </br><small>प्रिय उपयोगकर्ता कोड की पुनः जांच कर लें , सम्बन्धित  कर्मचारी / अधिकारी  का डाटा मौजूद नहीं है</small>
@endsection
