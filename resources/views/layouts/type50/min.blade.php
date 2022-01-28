<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.type50._commonpartials._basiccommonheader')
    @include('layouts.type50._commonpartials._fonts')

    {{-- bootstrap4.1.3 --}}
    @include('layouts.type50._commonpartials.css._bootstrap4')
    {{-- coreui --}}
    @include('layouts.type50._commonpartials.css._coreui')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    @yield('styles')
    @yield('headscripts')
</head>

<body class="c-app">
    @include('partials._sidebarmenu')
    <div class="c-wrapper">
        @include('layouts.type50._commonpartials._c_header')
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @include('layouts._commonpartials._alerts_msg')
                    @yield('content')
                </div>
            </main>
            @include('layouts._commonpartials._logoutform')
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     {{-- bootstrap4.1.3 --}}
    @include('layouts._commonpartials.js._bootstrap4')
    {{-- coreui --}}
    @include('layouts._commonpartials.js._coreui')

    @yield('scripts')
    @yield('footscripts')
</body>
</html>
