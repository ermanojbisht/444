@extends('layouts.type200.main')
@section('headscripts')

    @include('cssbundle.datatablefor5',['button'=>true])
    <style type="text/css">
        .search_box_th {
          position: relative;
        }
        .search_box_input {
         /* position: absolute;*/
          display: block;
          top:0;
          left:0;
          margin: 0;
          width: 100%;
          box-sizing: border-box;
        }
    </style>
@endsection

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['active'=>$selectedMenu]) --}}
@endsection

@section('pagetitle')
     dddddddddd
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        ['datas'=> [
            ['label'=>'My Estimates','active'=>true],
                    ]  
        ])
@endsection


@section('content')
<div class="row p-2">
    <div class="col-12 col-lg-12 col-xxl-12 table-responsive">
        <table id="jformtable" class="display compact datatable nowrap table table-sm table-bordered" style="width:100%">
            <thead>
                <tr class="bg-info text-white">
                    <th> # </th>
                    <th class="text-center"> Marked From </th>
                    <th class="text-center"> Marked To</th>
                    <th class="text-center"> Marked Date </th>
                    <th class="text-center"> Status </th>
                    <th class="text-center"> Remark </th>
                    <th class="text-center">  </th>   
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <th class="search_box_th"><input class="search search_box_input" type="text" disabled></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" placeholder="search..."></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" placeholder="search..."></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" disabled></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" placeholder="search..."></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" placeholder="search..."></th>
                    <th class="search_box_th"><input class="search search_box_input" type="text" placeholder="search..."></th> 
                    <th class="search_box_th">
                        <select class="search">
                            <option value>All</option>
                            @foreach($instances as $instance)
                                <option value="{{ $instance->sender->user_id }}">{{ $instance->sender->name }}</option>
                            @endforeach
                        </select>
                    </th> 

            </tr>
            </thead>
            <tbody class="text-center"></tbody>
        </table>
    </div>
</div>

@endsection


@section('footscripts')
 
<script src="{{asset('js/adminlte/jquery.js')}}"></script>
  @include('jsbundle.datatablefor5',['button'=>true])
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>
<script type="text/javascript">
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    let dtOverrideGlobals = {
        responsive: true,
        buttons: dtButtons,
        aaSorting: [],
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{route('formjAjaxData')}}"
        },
        columns:[

            {"data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
            { data:'bond_id' },
            { data:'bill_no' },
            { data:'form_date' },
            { data:'mineral' },
            { data:'weight' },
            { data:'unit' },
            { data:'fornjno' },
            { data:'vehicle_no' },
            { data:'address' },
            { data:'is_duplicate' },
            { data:'uploader_name' },
            { data:'starttime' },
            { data:'registration_no' },
            { data: 'actions', name: 'View' }
        ],

        orderCellsTop: true,
        order: [[ 1, 'asc' ]],
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
                'pageLength','copy', 'csv', 'excel', 'pdf', 'print',
                {
                    extend: 'colvis',
                    collectionLayout: 'fixed two-column'
                }
            ],
        "columnDefs": [
                { "visible": false, "targets": [9,11,12,13] },
                //{'max-width': '10%', 'targets': 0},
            ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       // "scrollX": true,
        "sScrollX": "100%",
       // "sScrollXInner": "110%",
       // "bScrollCollapse": true,
        "createdRow": function( row, data, dataIndex ) {
             if ( data.is_duplicate > 0 ) {
         $(row).addClass('alert alert-danger');

       }}


    };

    let table = $('#jformtable').DataTable(dtOverrideGlobals);
    $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
    });

});
</script>
@endsection
