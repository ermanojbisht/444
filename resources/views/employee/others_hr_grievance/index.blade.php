@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection

@section('pagetitle')
Resolve Grievances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Others Grievance','active'=>true]
]])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection

@section('content')

<div class="card">
    <div class="d-flex justify-content-end bg-transparent">
        <br />
    </div>

    <table id="tbl_Others_Grievances" class="table border mb-0">
        <thead class="table fw-bold">
            <tr class="align-middle ">
                <th>#</th>
                <th>Grievance Id</th>
                <th>Description</th>
                <th>Created on</th>
                <th>Status</th>
                <th>Resolve Grievance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grievancesL2 as $grievance)
            <tr class="{!! $grievance->status_bg_color() !!} ">
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>
                    {{-- <a href="{{route('View.hrGrievance', ['hr_grievance' => $grievance->id])}}"> </a> --}}
                    {{Str::limit($grievance->subject, 50, $end='.......')}}
                </td>
                <td> {{$grievance->created_at->format('d M Y')}} </td>
                <td>
                    {{$grievance->currentStatus()}}
                </td>
                <td>
                    <a class="btn btn-sm btn-success"
                        href="{{ route('view_hr_grievance', ['hr_grievance' => $grievance->id] ) }}">
                        Add Draft Answer
                    </a>
                </td>
            </tr>
            @endforeach


            @foreach($grievancesL1 as $grievance)
            <tr>
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>   {{Str::limit($grievance->description, 50, $end='.......')}} 
                <td> {{$grievance->created_at->format('d M Y')}} </td>
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
                            <a class="dropdown-item"
                                href="{{ route('view_hr_grievance', ['hr_grievance' => $grievance->id] ) }}">
                                Add Final Answer
                            </a>
                            @if( $grievance->draft_answer && $grievance->status_id != 4)
                            <form
                                action="{{ route('hr_grievance.revertGrievance', [ 'grievance_id'=> $grievance->id]) }}"
                                method="POST" onsubmit="return confirm('I want to revert this grievance 
                                    ( उपरोक्त शिकायत वापिस रिवर्ट करो ) ');" class="d-grid">
                                {{ csrf_field() }}
                                <input type="submit" class="dropdown-item" value="Revert Grievance" />
                            </form>
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
            $("#tbl_Others_Grievances").DataTable();
        });
</script>


@endsection