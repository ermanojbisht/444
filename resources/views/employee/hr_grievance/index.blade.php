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
        <thead class="table-light fw-bold">
            <tr class="align-middle">
                <th>#</th>
                <th>Grievance Id</th>
                <th>Description</th>
                <th>Created on</th>
                <th>Status</th>
                <th>Action </th>

            </tr>
        </thead>
        <tbody>
            @foreach($grievances as $grievance)

            <tr>
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>{{Str::limit($grievance->description, 50, $end='.......')}}</td>
                <td> {{$grievance->created_at ? $grievance->created_at->format('d M Y') : ''}} </td>
                <td>
                    {{$grievance->currentStatus()}}
                </td>
                <td>
                    <div class="dropdown" id="{{1+$loop->index}}">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <svg class="icon icon-xl">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            @if( $grievance->status_id == 0)
                            <a class="dropdown-item border-bottom border-1 border-info" href="#">
                                <form
                                    action="{{ route('employee.hr_grievance.submit', [ 'grievance_id'=> $grievance->id]) }}"
                                    method="POST" onsubmit="return confirm('Above Written Details are correct to my knowledge. 
                                        ( उपरोक्त दिए गए डाटा एवं प्रपत्र सही हैं तथा इनसे में सहमत हूँ) ');"
                                    class="d-grid">
                                    {{ csrf_field() }}

                                    <a  type="submit">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}">
                                            </use>
                                        </svg>
                                        Submit Grievance
                                    </a>
                                </form>
                            </a>

                            {{-- @if (Helper::checkBackDate($grievance->created_at, false, 'hrGrievance')) 
                                For reference to check data with in date eg to show for 2 days only 
                            @endif --}}

                            <a class="dropdown-item"
                                href="{{ route('employee.hr_grievance.addDoc',['hr_grievance'=>$grievance->id]) }}">
                                <svg class="icon icon-xl">
                                    <use xlink:href="{{asset('/sprites/linear.svg#cil-file-add')}}"></use>
                                </svg>
                                Add Document
                            </a>
                            <a class="dropdown-item"
                                href="{{ route('employee.hr_grievance.edit',['hr_grievance'=>$grievance->id]) }}">
                                <svg class="icon icon-xl">
                                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-file-add')}}">
                                    </use>
                                </svg>
                                Edit
                            </a>

                            @endif


                            <a class="dropdown-item"
                                href="{{route('employee.hr_grievance.show', ['hr_grievance' => $grievance->id])}}">
                                <svg class="icon icon-xl">
                                    <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                </svg>
                                View Grievance
                            </a>


                            @if( $grievance->status_id == 3)
                            <a class="dropdown-item border-bottom border-1 border-info" href="#">
                                <form
                                    action="{{ route('employee.hr_grievance.reopen', [ 'grievance_id'=> $grievance->id]) }}"
                                    method="POST" onsubmit="return confirm('Above Written Details are correct to my knowledge. 
                                        ( उपरोक्त दिए गए डाटा एवं प्रपत्र सही हैं तथा इनसे में सहमत हूँ) ');"
                                    class="d-grid">
                                    {{ csrf_field() }}

                                    <a type="submit">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}">
                                            </use>
                                        </svg>
                                        Re Open Grievance
                                    </a>
                                </form>
                            </a>

                            @endif

                        </div>
                    </div>
                </td>
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