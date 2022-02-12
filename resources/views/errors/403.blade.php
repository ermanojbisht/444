@extends('errors.layout')

@php
  $error_number = 403;
@endphp

@section('title')
  Forbidden.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href='javascript:history.back()''>go back</a> or return to <a href='".url('')."'>our homepage</a>.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
</br><small>Dear User you are not allowed to execute this operation/process</small>
</br><small>प्रिय उपयोगकर्ता आपको इस ऑपरेशन / प्रक्रिया को निष्पादित करने की अनुमति नहीं है</small>
@endsection