@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._datatable')
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection

@section('pagetitle')
{{Auth::User()->shriName}}'s Grievances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Grievance','active'=>false],
['label'=> 'List','active'=>true],
]])
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
    <table id="tbl_MyGrievance" class="table border mb-0">
        <thead class="fw-bold">
            <tr  class="align-middle">
                <th>#</th>
                <th>Grievance Id</th>
                <th>Subject</th>
                <th>Created on</th>
                <th>Status</th>
                <th style="width:10%">Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach($grievances as $grievance)
            <tr class="{!! $grievance->status_bg_color() !!} ">
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>{{Str::limit($grievance->subject, 50, $end='.......')}}</td>
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
                            <form action="{{ route('employee.hr_grievance.submit', [ 'grievance_id'=> $grievance->id]) }}"
                                class="d-grid" method="POST" 
                                onsubmit="return confirm('Above Written Details are correct to my knowledge.  ( उपरोक्त दिए गए डाटा एवं प्रपत्र सही हैं तथा इनसे में सहमत हूँ) ');" >
                                {{ csrf_field() }}
                                {!! Form::submit('Submit Grievance', ['class'=> 'dropdown-item']) !!}
                            </form>
                            <a class="dropdown-item"
                                href="{{ route('employee.hr_grievance.addDoc',['hr_grievance'=>$grievance->id]) }}">
                                Add Document
                            </a>
                            <a class="dropdown-item"
                                href="{{ route('employee.hr_grievance.edit',['hr_grievance'=>$grievance->id]) }}">
                                Edit
                            </a>
                            @endif
                            <a class="dropdown-item"
                                href="{{route('employee.hr_grievance.show', ['hr_grievance' => $grievance->id])}}">
                                View Grievance
                            </a>
                            @if( $grievance->status_id == 3) 
                                <form action="{{ route('employee.hr_grievance.reopen', [ 'grievance_id'=> $grievance->id]) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('I want to reopen my grievance. ( मैं शिकायत दुबारा ओपन करना चाहता हूँ )');" class="d-grid">
                                    {{ csrf_field() }}
                                    <input class="dropdown-item" type="submit" value="Re Open Grievance">
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
        $("#tbl_MyGrievance").DataTable();
    });
</script>

@endsection