@extends('layouts.type50.app')
@section('content')
<div class="row justify-content-center">

  <div class="col-lg-10">
    <div class="card-group d-block d-md-flex row">

        <div class="card col-md-6 p-4 mb-0">
            <div class="card-body ">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-medium-emphasis">{{ trans('global.login') }}</p>

                @if(session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="employee_id" name="employee_id" type="text" class="form-control{{ $errors->has('employee_id') ? ' is-invalid' : '' }}" required autocomplete="employee_id" autofocus placeholder="{{ trans('global.login_employee_id') }}" value="{{ old('employee_id', null) }}">

                        @if($errors->has('employee_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('employee_id') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>

                        <input id="password" name="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-4">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            @if(Route::has('password.request'))
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a><br>
                            @endif
                            @if(config('site.isRegistrationOpen'))
                            <a class="btn btn-link px-0" href="{{ route('register') }}">
                                {{ trans('global.register') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card col-md-6 text-white bg-primary py-5">
            <div class="card-body text-center">
                <div>
                  <p>@include('icon.icon',['icon'=>'telegram','width'=>80,'height'=>80])</p>
                  If you have informed the system about your Telegram integration then you may Login through Telegram. Otherwise after login with credentials you may like to integerate yourself with telegram
                    <script
                        async
                        type="application/javascript"
                        src="https://telegram.org/js/telegram-widget.js?7"
                        data-telegram-login="{{ config('services.telegram-bot-api.name') }}"
                        data-size="large"
                        data-auth-url="{{ route('telegram.telegramLogged') }}"
                        data-request-access="write"
                    ></script>
                    {{-- <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button> --}}
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
