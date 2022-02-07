@extends('layouts.type200.main')

@section('headscripts')
    @include('cssbundle.datatablefor5',['button'=>true])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['active'=>'estimate.report']) --}}
@endsection

@section('pagetitle')
     Estimate Reports
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Reports','active'=>true],
                    ]  
        ])
@endsection


@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div>
                @csrf
                <br />
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="category">District </label>
                            {{-- onchange="getSetectedDistrict()" --}}
                            <select class="form-select select2" id="district_id" name="district_id"
                                onchange="getSetectedBlocks()">>
                                <option value="0">All District</option>
                                @foreach($districts as $district)
                                <option value="{{$district->id}}"> {{$district->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="registor_for">Block </label> <br />
                            <select class="form-select select2" id="block_id" name="block_id">
                               <option value="0">All Block</option>
                                {{-- @foreach($blocks as $block)
                                <option value="{{$block->id}}"> {{$block->name}} </option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="registor_for">Constituency </label><br />
                            <select class="form-select select2 " id="constituency_id" name="constituency_id">
                               <option value="0">All Constituency</option>
                                {{-- @foreach($constituencies as $constituency)
                                <option value="{{$constituency->id}}"> {{$constituency->name}} </option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="registor_for">Lok Sabha </label>
                            <select class="form-select " id="loksabha_id" name="loksabha_id">
                                <option value="0">All Loksabha</option>
                                @foreach($Loksabhas as $loksabha)
                                <option value="{{$loksabha->id}}"> {{$loksabha->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="registor_for">Work Type </label>
                            <select class="form-select" id="worktype_id" name="worktype_id" required>
                                <option value="0">All work Type</option>
                                @foreach($workType as $work)
                                <option value="{{$work->id}}"> {{$work->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="road_length">Due To </label>
                            <select class="form-select" id="due_to" name="due_to" required>
                                @foreach(config('mis_entry.estimate.due_to') as $key => $value)
                                <option value="{{$key}}"> {{$value}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <br />
                            <input type="submit" onclick="getData()" class="btn btn-success" value="Submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <table id="estimateReport" class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Instance Name </th>
                            <th>Instance Date </th>
                            <th>Office Name </th>
                            <th>District </th>
                            <th>Block </th>
                            <th>Constituency </th>
                            <th>Lok Sabha</th>
                            <th>Work Type</th>
                            <th>Pending With</th>
                            <th>Estimate Cost </th>
                            <th>Status </th>
                            <th>Due to </th>
                            <th>Reff No </th>
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(function () {
        getData();
    });

function getData()
{
    $('#estimateReport').DataTable().destroy();

    var datas = {
            _token: $('input[name="_token"]').val(),
            district_id : $("#district_id").val(),
            block_id : $("#block_id").val(),
            constituency_id : $("#constituency_id").val(),
            loksabha_id : $("#loksabha_id").val(),
            worktype_id : $("#worktype_id").val(),
            dueTo_id : $("#due_to").val(),
        };
     
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    let dtOverrideGlobals = {
        retrieve: true,  
        responsive: true,
        buttons: dtButtons,
        aaSorting: [],
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{route('estimate.ajaxDataForEstimateReport')}}",
            data: datas
        },
        columns:[

            {"data": "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
            { data:'instance_name' },
            { data:'created_at'}, 
            { data:'estimate.office_name.name' },
            { data:'estimate.district.name' },
            { data: 'estimate.block.name', 
            "defaultContent": "Unknown" },
            { data: 'estimate.constituency.name', 
            "defaultContent": "Unknown" },
            { data:'estimate.loksabha.name' },
            { data: 'estimate.worktype.name', 
            "defaultContent": "Unknown" },
            { data: 'instance_last_recognize_user.name', 
            "defaultContent": " " } ,
            { data: 'estimate.estimate_cost', 
            "defaultContent": "0" },
            { data: 'current_status.name', 
            "defaultContent": "0" },

            { data: 'estimate.due_to', 
            "defaultContent": "0" },
            { data: 'estimate.reference_no', 
            "defaultContent": "0" }
        ]
        };

        let table = $('#estimateReport').DataTable(dtOverrideGlobals);

    }


function getSetectedBlocks()
    {
        var district = $("#district_id").val();
        var _token = $('input[name="_token"]').val();
        if (district > 0) {  
            $.ajax({
                url: "{{ route('getBlocksInDistrict') }}",
                method: "POST",
                data: {
                    district: district,
                    _token: _token
                },
                success: function(data) {
                    bindDdlWithData("block_id", data, "id", "name", true, "0", "Select Block");
                    $('#block_id').val("");
                    getSetectedConstituency();
                }
            });
        }
    }
    
    function getSetectedConstituency()
    {
        var district = $("#district_id").val(); 
        var _token = $('input[name="_token"]').val();
        if (district > 0) {   
            $.ajax({
                url: "{{ route('getConstituenciesInDistrict') }}",
                method: "POST",
                data: {
                    district: district,
                    _token: _token
                },
                success: function(data) {
                    bindDdlWithData("constituency_id", data, "id", "name", true, "0", "Select Constituency");
                    $('#constituency_id').val("");
                }
            });
        }
    }

</script>


@include('partials.js._dropDownJs')

@include('partials.js._makeDropDown')
@endsection
