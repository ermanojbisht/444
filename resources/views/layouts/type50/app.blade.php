<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.type50._commonpartials._basiccommonheader')
    @include('layouts.type50._commonpartials._fonts')

    {{-- bootstrap4.1.3 --}}
    @include('layouts.type50._commonpartials.css._bootstrap4')
    {{-- select2 4.0.5 --}}
    @include('layouts._commonpartials.css._select2')
    {{-- datetimepicker --}}
    @include('layouts._commonpartials.css._datetimepicker')
    {{-- dropzone --}}
    @include('layouts._commonpartials.css._dropzone')
    {{-- coreui --}}
    @include('layouts.type50._commonpartials.css._coreui')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
    @yield('headscripts')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    <div class="c-app flex-row align-items-center">
        <div class="container">
            @yield("content")
        </div>
    </div>
    @yield('scripts')
    @yield('footscripts')
</body>
</html>
