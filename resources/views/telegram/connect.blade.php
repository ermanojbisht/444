@extends('layouts.type200.pdf')

@section('headscripts')

    @if(Auth::check())
        @if(Auth::user()->chat_id > 100000)
            User already Integred with Telegram .
        @else
            User do not have Telegram Integreation.
            <script
                async
                type="application/javascript"
                src="https://telegram.org/js/telegram-widget.js?15"
                data-telegram-login="{{ config('services.telegram-bot-api.name') }}"
                data-size="large"
                data-auth-url="{{ route('telegram.callback') }}"
                data-request-access="write"
            ></script>
        @endif
    @else
        User Not Logged!  <a class="btn nav-button" href="{{ url('/login') }}">Login</a>
    @endif

@endsection
