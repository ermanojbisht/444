@extends('layouts.type200.main')
@section('styles')
    @include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
    Estimate Village List
@endsection

@section('breadcrumbNevigationButton')
    @include('layouts._commonpartials._breadcrumbNavbar',
                ['instance_estimate_id'=>$instanceEstimate->id??0])
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'home','active'=>false,'route'=>'admin.home','icon'=>'home'],
                        ['label'=>'Track','active'=>false],
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimate ID- '.$instanceEstimate->id,'active'=>false],
                        ['label'=>'Villages','active'=>true],
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
            <button type="button" id="addNewVillage" class="btn btn-success">Add village</button>
        </div>

        <table class="table datatable table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Name</th>
                <th>Population</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($villages as $village)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$village->id}}</td>
                    <td>{{$village->name}}</td>
                    <td>{{$village->Tot_p}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-primary delete"
                           data-instance_estimate_id="{{$village->pivot->instance_estimate_id}}"
                           data-village_id="{{$village->id}}">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" rowspan="1" headers="">No Data Found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- boostrap model -->
    <div class="modal fade" id="village-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="villageModel"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="villageInserUpdateForm" name="villageInserUpdateForm"
                          class="form-horizontal" method="POST">
                        @csrf
                        <input type="hidden" name="instance_estimate_id" id="instance_estimate_id"
                               value="{{$instanceEstimate->id}}">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Block</label>
                            <div class="col-sm-12">
                                <select id="block_id" name="block_id" class="form-select select2" style="width: 100%"
                                        onchange="getFeatureListAsPerSelectedGroup({sourceElementId:'block_id',routeIdentifier:'block',ddlId:'village_id'})">
                                    <option value="">Select block</option>
                                    @foreach($blocks as $key=>$block)
                                        <option value="{{ $key }}" > {{ $block }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="name" class="col-sm-2 control-label">Village</label>
                            <div class="col-sm-12">
                                <select id="village_id" name="village_id" class="form-select select2"
                                        style="width: 100%"></select>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary " id="btn-save" value="addNewVillage">Save
                                changes
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
                dropdownParent: $('#village-model'),
                width: 'resolve'
            });

            $('#addNewVillage').click(function () {

                $('#villageInserUpdateForm').trigger("reset");
                $('#villageInserUpdateForm select').trigger("change");
                $('#villageModel').html("Add Village ");
                $('#village-model').modal('show');
            });
            $('body').on('click', '.delete', function () {
                if (confirm("Delete Record?") == true) {
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ route('estimate.detachvillage') }}",
                        data: {
                            village_id: $(this).data('village_id'),
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
            $('#villageInserUpdateForm').submit(function () {
                // ajax
                $.ajax({
                    type: "post",
                    url: "{{ route('estimate.attachvillage') }}",
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
