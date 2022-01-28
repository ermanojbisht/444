@if(config('site.assetFromCdn.datatable'))
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap5.min.js "></script>
@if($button)
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js "></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap5.min.js "></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js "></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js "></script>

@endif

@else
<script src="{{ asset('../js/DataTables/DataTables-1.11.0/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../js/DataTables/DataTables-1.11.0/js/dataTables.bootstrap5.min.js') }}"></script>

@if($button)
<script src="{{ asset('../js/DataTables/Buttons-2.0.0/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('../js/DataTables/Buttons-2.0.0/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('../js/DataTables/Buttons-2.0.0/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('../js/DataTables/Buttons-2.0.0/js/buttons.html5.min.js') }}"></script>
@endif

@endif


   

 
  
    
    
    
