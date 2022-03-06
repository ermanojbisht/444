<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.type200._commonpartials._basiccommonheader')
@include('layouts._commonpartials.css.custom')
  
@include('layouts.type200._commonpartials.css.selected',['list'=>['_main','_simplebar',]])
@yield('styles')
@yield('headscripts')
<style type="text/css">
    tr:hover {font-weight: bolder;}
</style>
</head>
<body>
    @yield('sidebarmenu')
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    {{-- c-header --}}
    @include('layouts.type200._commonpartials._header')

    {{-- c-body --}}
    <div class="body flex-grow-1 px-3">
        <main class="c-main">
            <div class="container-fluid">
                @include('layouts._commonpartials._alerts_msg')
                @yield('content')
            </div>
        </main>
        @include('layouts._commonpartials._logoutform')
    </div>
    @include('layouts.type200._commonpartials._footer')
</div>


{{-- coreui --}}
@include('layouts.type200._commonpartials.js.selected',['list'=>['_jquery','_coreui']])
@yield('scripts')
@yield('footscripts')

<script type="text/javascript">
    // for Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-coreui-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new coreui.Tooltip(tooltipTriggerEl)
    })
</script>
</body>
</html>
