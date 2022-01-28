@if(config('site.assetFromCdn.datatable'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
@if($button)
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
@endif
@else
<link rel="stylesheet" href="{{ asset('../bootstrap5/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('../js/DataTables/DataTables-1.11.0/css/dataTables.bootstrap5.min.css') }}">
@if($button)
<link rel="stylesheet" href="{{ asset('../js/DataTables/Buttons-2.0.0/css/buttons.bootstrap5.min.css') }}">
@endif
@endif