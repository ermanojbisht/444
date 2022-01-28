<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    {{-- header --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="MISPWD Contract">
    <meta name="author" content="PWD Uttarakahand">
    <meta name="keywords" content="mispwd, contract, bond,pwd, Uttarakahand">
    <title>Estimate {{ config('app.name', 'Estimate') }}</title>
    {{-- fonts --}}
    @include('layouts.type50._commonpartials._fonts')
    @include('layouts.type50._commonpartials.css._coreui')


    <style type="text/css">
        .form-group .required:after {
            content:" *";
            color: red;
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('../bootstrap5/img/icons/icon-48x48.png') }}"/>
    <link href="{{ asset('../bootstrap5/css/app.css') }}" rel="stylesheet">

    @yield('styles')
    @yield('headscripts')

</head>

<body>
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar @if ($isCollapsed??false) collapsed @endif">
            <a class="sidebar-brand" href="{{ url('/') }}">
                <span style=  "width: 100%;
                            fill: #88bce8; 
                            stroke-width: 3;
                            stroke-linecap: round;
                            stroke-linejoin:  round;" >
                    {!!config('mis_entry.svgIcon')['misentry']!!}
                </span>
                
            </a>
        <div class="sidebar-content js-simplebar">
            {{-- @include('layouts.type100.partials.user_menu') --}}

            @section('top_menu')
                @include('layouts.type100.partials.top_menu')
            @endsection

            @yield('user_menu')

            @yield('side_menu')

        </div>
        <div class="btn-toolbar p-0" role="toolbar" aria-label="Toolbar with button groups">
          <div class="btn-group m-0" role="group" aria-label="First group">
            <a class="btn btn-warning" href="http://mis.pwduk.in/pwd">
                <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['mis']!!}</span>
            </a>
            <a class="btn btn-success" href="http://mis.pwduk.in/im">
                <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['im']!!}</span>
            </a>
            <a class="btn btn-warning" href="http://mis.pwduk.in/dms">
                <span class="iconlogo" style="width:50px; fill: white;">{!!config('mis_entry.svgIcon')['dms']!!}</span>
            </a>
            </div>
        </div>
    </nav>
    <div class="main">
        @yield('top_menu')
        <main class="content p-0">
            <div class="container-fluid p-0">
                <div id="div_error_msg">
                    @if($errors->any())
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                @foreach($errors->all() as $errorMsg)
                                    <br/> {{$errorMsg}} <br/>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if(session('success'))
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                                </div>
                            </div>
                        @endif
                        @if(session('message'))
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="alert alert-info" role="alert">{{ session('message') }}</div>
                                </div>
                            </div>
                        @endif
                        @if(session('fail'))
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger" role="alert">{{ session('fail') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @yield('content')
            </div>
        </main>
        @include('layouts.type100.partials.footer')
    </div>
</div>

<script src="{{ asset('../bootstrap5/js/app.js') }}"></script>

<!-- jquery . min -->
<script src="https://code.jquery.com/jquery-3.6.0.js" crossorigin="anonymous"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="></script>

{{-- footerscript --}}
@yield('footscripts')
</body>

</html>
