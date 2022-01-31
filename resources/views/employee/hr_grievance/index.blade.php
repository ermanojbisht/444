@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection

@section('pagetitle')
{{ $employee_name}}'s Grievances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Grievance','active'=>false],
['label'=> 'List','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection



@section('content')

<div class="card">
    <div class="d-flex justify-content-end bg-transparent">
        <a class="btn btn-sm btn-dark m-2 " href="{{route('employee.hr_grievance.create')}}">
            <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
            </svg>
            Create New
        </a>
    </div>
    <table class="table border mb-0">
        <thead class="table-dark fw-bold">
            <tr class="align-middle">
                <th>#</th>
                <th class="text-center">Grievance Id</th>
                <th class="text-center">Description</th>
                <th class="text-center">Created on</th>
                <th>Status</th>
                <th>Currently With</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($grievances as $grievance)

            <tr>
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>
                    <a href="{{route('employee.hr_grievance.show', ['hr_grievance' => $grievance->id])}}">
                        <i class="cib-twitter"></i>
                        {{Str::limit($grievance->description, 50, $end='.......')}}

                    </a>
                </td>
                <td> {{$grievance->created_at ? $grievance->created_at->format('d M Y') : ''}} </td>
                <td>
                    {{$grievance->currentStatus()}}
                </td>
                <td>
                    <a href="{{ route(" employee.hr_grievance.addDoc",['hr_grievance'=>$grievance->id]) }}" >
                        <i class="cib-twitter"></i> Add Document
                    </a>
                </td>
                <td>
                    @if (Helper::checkBackDate($grievance->created_at, false, 'hrGrievance'))
                    <a href="{{ route(" employee.hr_grievance.edit",['hr_grievance'=>$grievance->id]) }}" >
                        <i class="cib-twitter"></i> Edit
                    </a>
                    @endif

                </td>
                {{-- <td>
                    <a href="{{ route(" employee.hr_grievance.edit",['hr_grievance'=>$grievance->id]) }}" >
                        <i class="cib-twitter"></i> Action
                    </a>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('layouts._commonpartials._logoutform')

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