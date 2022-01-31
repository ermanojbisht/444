@extends('layouts.type200.main')

@section('sidebarmenu')
    {{-- @include('layouts.type200._commonpartials._sidebarmenu',['hr_grievance'=>$hr_grievance_id??0]) --}}
@endsection

@section('pagetitle')
    Grievance Id -> {{$hr_grievance_id}}  Documents
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', 
['datas'=> [
    ['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
    ['label'=> 'Grievance','active'=>false],
    ['label'=> 'List','active'=>false, 'route' => 'employee.hr_grievance'],
    ['label'=> 'View Document for Grievance Id -> ' . $hr_grievance_id  ,'active'=>true],
    ]])
@endsection

@section('content')
<div class="container-fluid">
    {{-- <x-track.instance-estimate-header :instanceEstimate="$instanceEstimate" pagetitle="Estimate's Document List"
                                      toBackroutename="track.estimate.view"
                                      :routeParameter="['instance_estimate'=>$instanceEstimate->id]"
                                      routelabel="Back to Estimate Tracking Details"/> --}}

    @if($hr_grievance_id)
        Docs are editable only for {{config('site.backdate.hrGrievance.allowedno')}} days.   
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route("employee.hr_grievance.addDoc",['hr_grievance'=>$hr_grievance_id]) }}"
                                   class="btn btn-primary btn-flat pull-right mt-2 mr-2">Add Document</a>
                            </div>
                        </div>
                        <table class="table datatable table-bordered table-striped table-hover" id="progresstbl">
                            <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>  
                                <th>Date</th>  
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
                                    <td>{{ $doc->created_at->toFormattedDateString() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Document found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
