@extends('layouts.type200.main')

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['instance_estimate_id'=>$instanceEstimate->id??0]) --}}
@endsection

@section('pagetitle')
    Estimate's Document
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Estimate','active'=>false],
                        ['label'=>'Estimete ID- '.$instanceEstimate->id,'active'=>false],
                        ['label'=>'Documents','active'=>true],
                    ]  
        ])
@endsection

@section('content')
<div class="container-fluid">
    <x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Estimate's Document List"
                                      toBackroutename="track.estimate.view"
                                      :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Tracking Details"/>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-auto">
                        <a href="{{ route("instance.estimate.addDoc",['instance_estimate'=>$instanceEstimate->id]) }}" class="btn btn-outline-info">Add Document</a>
                </div>
                <div class="col-auto">
                    @include('partials.search_doc',['formaction'=>'instance.estimate.searchDoc','fieldName'=>'instance_estimate_id','fieldValue'=>$instanceEstimate->id])
                </div>
            </div>
            @if($instanceEstimate->id)
            <div class="row justify-content-between text-warning fw-bold">
                <div class="col-auto">
                    Selected document Type: {{$doctypeName}}
                </div>
                <div class="col-auto">
                    Docs are editable only upto {{config('site.backdate.docUploadInWorks.allowedno')}} days.
                </div>
            </div>
            <table class="table table-bordered table-hover" id="progresstbl">
                <thead>
                    <tr>
                        <th>Sno.</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        {{-- @can('edit-document')
                        <th>Edit</th>
                        @endcan --}}
                        @can('publish-document')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @php $sno = 0 @endphp
                    @forelse($doclist as $doc)
                        <tr>
                            <td>{{ ++$sno }}</td>
                            <td>{{ $doc->id }}</td>
                            <td><a href="{{ $doc->address }}" target="_blank">{{ $doc->name }}</a></td>
                            <td>{{ $doc->description }}</td>
                            <td>
                                @if($doc->documentTypeGeneral->id == 6)
                                    <svg style="width: 24px; height: 24px;">
                                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-image')}}"></use>
                                    </svg>            
                                @elseif($doc->documentTypeGeneral->id == 15)
                                    <svg style="width: 24px; height: 24px;">
                                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-globe-alt')}}"></use>
                                    </svg> 
                                @else
                                    <svg style="width: 24px; height: 24px;">
                                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-short-text')}}"></use>
                                    </svg> 
                                @endif
                                    {{$doc->documentTypeGeneral->name}}
                            </td>
                            <td>{{ $doc->created_at->toFormattedDateString() }}</td>
                            @can('edit-document')
                                {{-- <td><a href="{{ url('editdocument').'/'.$doc->id }}"><i class="fa fa-pencil"></i></a></td> --}}
                            @endcan
                            @can('publish-document')
                                <td>
                                    @if($doc->is_active)
                                        @php $icon="fa-check"; $textclass="text-success" @endphp
                                    @else
                                        @php $icon="fa-times"; $textclass="text-danger" @endphp
                                    @endif
                                    <a href="{{ route('instance.estimate.publishdocument',['docid'=>$doc->id,'isactive'=>$doc->is_active]) }}"
                                       class="{{ $textclass }}"><i class="fa {{ $icon }}"></i></a>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No Document found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>
    </div>



    
</div>
@endsection
@section('footscript')
    <script type="text/javascript" language="javascript"
            src="{{ asset('assets/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript" language="javascript" class="init">
        var $ = jQuery.noConflict();
        $(document).ready(function () {
            $('.datatable').DataTable({
                processing: false,
                serverSide: false,
            });
        });
    </script>
@endsection
