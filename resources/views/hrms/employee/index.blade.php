@extends('layouts.type200.main')

@section('styles')
@include('layouts._commonpartials.css._datatable')
@endsection

@section('sidebarmenu')

@endsection

@section('pagetitle')
{{Auth::User()->shriName}}'s
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'New Created Employees','active'=>true],
]])
@endsection

@section('content')

<div class="card">
    <div class="d-flex justify-content-end bg-transparent">
        <a class="btn btn-sm btn-dark m-2 " href="{{route('employee.create')}}">
            <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
            </svg>
            Create New
        </a>
    </div>
    <table id="tbl_NewAddedEmployees" class="table border mb-0">
        <thead class="fw-bold">
            <tr class="align-middle">
                <th>#</th>
                <th>Id</th>
                <th>Name </th>
                <th>Father's Name</th>
                <th>Date Of Birth</th>
                <th>Status -> Created on</th>
                <th style="width:10%">Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach($newAddedEmployees as $employee)
            <tr class="{!! $employee->status_bg_color() !!} ">
                <td>{{1+$loop->index}}</td>
                <td>{{$employee->id}}</td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->father_name}}</td>
                <td>{{$employee->birth_date ? $employee->birth_date->format('d M Y') : ''}} </td>
                <td>{{-- {{$employee->currentStatus()}} on --}}
                    {{$employee->created_at ? $employee->created_at->format('d M Y') : ''}} </td>
                <td>
                    <div class="dropdown" id="{{1+$loop->index}}">
                        <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <svg class="icon icon-xl">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            @if( $employee->lock_level == 0)
                            <form
                                action="{{ route('employee.lockEmployee', ['employee'=> $employee->id,'lock_level'=> 1]) }}"
                                method="POST" onsubmit="return confirm('All Details are correct to my knowledge. 
                                        (????????????????????? ????????? ?????? ???????????? ????????? ????????????????????? ????????? ????????? |)');" class="d-grid">
                                {{ csrf_field() }}

                                <input class="dropdown-item" type="submit" value="Save Employee Data" />
                            </form>
                            <a class="dropdown-item" href="{{ route('employee.edit',['employee'=>$employee->id]) }}">
                                Edit
                            </a>
                            @elseif( $employee->lock_level == 1)

                            <a class="dropdown-item" href="{{ route('employee.office.view',['employee'=>$employee->id]) }}">
                                View Employee
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
        $("#tbl_NewAddedEmployees").DataTable();
    });
</script>

@endsection