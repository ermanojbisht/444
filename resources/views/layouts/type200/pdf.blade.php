<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('layouts.type200._commonpartials._basiccommonheader')
@include('layouts._commonpartials.css.custom')
  
@include('layouts.type200._commonpartials.css.selected',['list'=>['_main','_simplebar',]])
<style type="text/css">
    .page {
        overflow: hidden;
        page-break-after: always;
    }
</style>
@yield('styles')
@yield('headscripts')
</head>
<body>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <div class="body flex-grow-1 px-3">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
