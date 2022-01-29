@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection

@section('pagetitle')
 {{ $employee_name}}'s   Grivances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', 
['datas'=> [
    ['label'=> 'Home','active'=>false, 'route'=> 'employee.dashboard'],
    ['label'=> 'Grivance','active'=>false],
    ['label'=> 'List','active'=>true],
    ]])
@endsection

@section('content')

<div class="card">
    <div class="d-flex justify-content-end bg-transparent">
        <a class="btn btn-sm btn-dark m-2 " href="{{route('employee.hr_grivance.create')}}">
            <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
            </svg>
            Create New
        </a>
    </div>
    {{-- <div class="table-responsive"> --}}
        <table class="table border mb-0">
            <thead class="table-dark fw-bold">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="text-center">Grivance Id</th> 
                    <th class="text-center">Description</th> 
                    <th class="text-center">Created on</th>
                    <th>Status</th>
                    <th>Currently With</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($grivances as $grivance)
                <tr>
                    <td>{{1+$loop->index}}</td>
                    <td>{{$grivance->id}}</td>
                    <td>
                        <a href="{{route('employee.hr_grivance.show', ['hr_grivance' => $grivance->id])}}">
                            <i class="cib-twitter"></i> {{$grivance->description}}
                        </a>
                    </td>
                    <td> {{$grivance->created_at->format('d M Y')}} </td>
                    <td>
                        {{$grivance->currentStatus()}}
                    </td>
                    <td>
                        <a href="{{ route("hr_grivance.addDoc",['hr_grivance'=>$grivance->id]) }}" >
                            <i class="cib-twitter"></i> Add Document
                        </a>
                    </td>
                    <td>
                        @if (Helper::checkBackDate($grivance->created_at, false, 'hrGrivance'))
                            <a href="{{ route("employee.hr_grivance.edit",['hr_grivance'=>$grivance->id]) }}" >
                                 <i class="cib-twitter"></i> Edit
                            </a>
                        @endif
                        
                    </td>
                    <td>
                        <a href="{{ route("employee.hr_grivance.edit",['hr_grivance'=>$grivance->id]) }}" >
                            <i class="cib-twitter"></i> Action
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{--
    </div> --}}
</div>


@include('layouts._commonpartials._logoutform_foremployee')



@endsection

@section('footscripts')
<script src="{{ asset('../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function () {
            $("#success-alert").slideUp(500);
        });
    });

        document.addEventListener("DOMContentLoaded", function () {
            // Datatables Responsive
            $("#user_Request_Details").DataTable({
                responsive: true
            });
        });
</script>

@endsection

