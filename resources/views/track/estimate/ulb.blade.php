@extends('layouts.type200.main')
@section('styles')
    @include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
    Estimate's Uraban Local Body List
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'','active'=>false,'route'=>'admin.home','icon'=>'home'],
                        ['label'=>'Track','active'=>false],
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimate ID- '.$instanceEstimate->id,'active'=>false],
                        ['label'=>'ULB','active'=>true]
                    ]
        ])
@endsection

@section('content')
    <div class="container-fluid">
        <x-track.instance-estimate-header :instanceEstimate="$instanceEstimate"
                                          pagetitle=""
                                          toBackroutename="track.estimate.view"
                                          :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                          routelabel="Back to Estimate Tracking Details"/>
        <div class="col-md-8 mt-1 mb-2">
            <button type="button" id="addNewUlb" class="btn btn-success">Add ULB</button>
        </div>

        <table class="table datatable table-bordered table-striped table-hover" >
            <thead>
            <tr>
                <th>#</th>
                <th>ULB Type</th>
                <th>ID</th>
                <th>Name</th>
                <th>Details</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($ulbs as $ulb)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$ulb->type_name}}</td>
                    <td>{{$ulb->id}}</td>
                    <td>{{$ulb->title}}</td>
                    <td>{{$ulb->pivot->wards}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-primary delete"
                           data-instance_estimate_id="{{$ulb->pivot->instance_estimate_id}}"
                           data-ulb_id="{{$ulb->id}}">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" rowspan="1" headers="">No Data Found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- boostrap model -->
    <div class="modal fade" id="ulb-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ulbModel"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="ulbInserUpdateForm" name="ulbInserUpdateForm"
                          class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="instance_estimate_id" id="instance_estimate_id"
                               value="{{$instanceEstimate->id}}">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Block</label>
                            <div class="col-sm-12">
                                <select id="ulb_type_id" name="ulb_type_id" class="form-select select2" style="width: 100%"
                                        onchange="getFeatureListAsPerSelectedGroup({sourceElementId:'ulb_type_id',routeIdentifier:'ulbType',ddlId:'ulb_id'})">
                                    <option value="">Select ULB Type</option>
                                    @foreach($ulbTypes as $key=>$ulbType)
                                        <option value="{{ $key }}" > {{ $ulbType }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="name" class="col-sm-2 control-label">ULB</label>
                            <div class="col-sm-12">
                                <select id="ulb_id" name="ulb_id" class="form-select select2"
                                        style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="name" class="col-sm-2 control-label">Wards</label>
                            <div class="col-sm-12">
                                <input type="text" name="wards" value="{{ old('wards', '') }}">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary " id="btn-save" value="addNewUlb">Add
                                ULB
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->
@endsection
@section('footscripts')
    <!-- Select2 JS -->
    @include('layouts._commonpartials.js._select2')
    <script type="text/javascript">


        $(document).ready(function ($) {
            $('.select2').select2({
                dropdownParent: $('#ulb-model'),
                width: 'resolve'
            });

            $('#addNewUlb').click(function () {
                $('#ulbInserUpdateForm').trigger("reset");
                $('#ulbInserUpdateForm select').trigger("change");
                $('#ulbModel').html("Add Village");
                $('#ulb-model').modal('show');
            });
            $('body').on('click', '.delete', function () {
                if (confirm("Delete Record?") == true) {
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('estimate.detachulb') }}",
                        data: {
                            ulb_id: $(this).data('ulb_id'),
                            instance_estimate_id: $(this).data('instance_estimate_id'),
                            _token: $('input[name="_token"]').val()
                        },
                        dataType: 'json',
                        success: function (res) {
                            window.location.reload();
                        }
                    });
                }
            });
            $('#ulbInserUpdateForm').submit(function () {
                // ajax
                $.ajax({
                    type: "post",
                    url: "{{ route('estimate.attachulb') }}",
                    data: $(this).serialize(), // get all form field value in
                    dataType: 'json',
                    success: function (res) {
                        window.location.reload();
                    }
                });
            });
        });
    </script>

    @include('partials.js._getFeatureListAsPerSelectedGroupJs')

    @include('partials.js._makeDropDown')
@endsection
