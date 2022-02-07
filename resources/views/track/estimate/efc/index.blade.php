@extends('layouts.type200.main')

@section('headscripts')
    @include('cssbundle.datatablefor5',['button'=>true])  
@endsection


@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',[]) --}}
@endsection

@section('pagetitle')
     EFC Estimate Reports
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'home','active'=>false,'route'=>'admin.home','icon'=>'home'],
                        ['label'=>'Track','active'=>false],
                        ['label'=>'Estimate','active'=>false],                       
                        ['label'=>'EFC List','active'=>true],
                    ]
        ])
@endsection


@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <table id="estimateReport" class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name </th>
                            <th>Created on</th>
                            <th>EFC on</th>
                            <th>Office Name </th>
                            <th>District </th>                           
                            <th>Constituency </th>
                            <th>Estimate Cost in lakhs</th>
                            <th>Due to </th>
                            <th>Created Work </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <br />

        </div>
    </div>
</div>

@endsection

@section('footscripts')

@include('jsbundle.datatablefor5',['button'=>true])

<script type="text/javascript">
    $(function () { getData();  });

function getData()
{
    $('#estimateReport').DataTable().destroy();

        
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    let dtOverrideGlobals = {
        retrieve: true,  
        responsive: true,
        buttons: dtButtons,
        aaSorting: [],
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{route('efc.index')}}"            
        },
        columns:[

            {"data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },"width": "3%"},
            { data:'instance_name',"width": "25%" },
            { data:'created_at',"width": "8%"},
            { data:'estimate.efc_date',type: 'num',render: {  _: 'display',sort: 'timestamp'} ,"width": "8%"},
            { data:'estimate.office_name.name' },
            { data:'estimate.district.name' },          
            { data: 'estimate.constituency.name',  "defaultContent": "Unknown" },         
            { data: 'estimate.estimate_cost' ,"width": "5%"},
            { data: 'estimate.due_to', "defaultContent": "0" },
            { data:'estimate.new_Work_Code' },

        ]

        };

        let table = $('#estimateReport').DataTable(dtOverrideGlobals);

    }

</script>


@include('partials.js._dropDownJs')


@endsection
