@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection

{{--
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'Grievance'])
@endsection --}}

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
    <div class="card-header">
        <form method="GET" action="#">
            <div class="row d-flex justify-content-between">
                <div class="col-md-3">
                    <p class="fw-bold mb-0"> Office : </p>
                    <div class="form-group">
                        <select id='office_id' name='office_id' required class="form-select select2">
                            <option value="0" {{( $officeId=='0' ? 'selected' : '' )}}> Select Office </option>
                            <option value="2" {{( $officeId=='2' ? 'selected' : '' )}}> All</option>
                            @foreach ($offices as $office)
                            <option value="{{$office->id}}" {{( $officeId==$office->id ?
                                'selected' : '' )}} > {{$office->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="fw-bold mb-0"> Start Date :
                        <input type="date" name="start" format="dd/mm/yyyy" class="form-control"
                            value="{{ $startDate }}">
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="fw-bold mb-0"> End Date :
                        <input type="date" name="end" format="dd/mm/yyyy" class="form-control" value="{{ $endDate}}">
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="mt-4 text-end">
                        <input type="submit" class="btn btn-info" value="Search" />
                    </p>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table border mb-0">
            <thead class="table fw-bold">
                <tr class="align-middle ">
                    <th>#</th>
                    <th>Grievance Id</th>
                    <th>Description</th>
                    <th>Created on</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grievances as $grievance)
                <tr>
                    <td> {{1+$loop->index }} </td>
                    <td>{{$grievance->id}}</td>
                    <td>
                        <a href="{{route('View.hrGrievance', ['hr_grievance' => $grievance->id])}}">
                            {{Str::limit($grievance->description, 50, $end='.......')}}
                        </a>
                    </td>
                    <td> {{$grievance->created_at->format('d M Y')}} </td>
                    <td>
                        {{$grievance->currentStatus()}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@include('layouts._commonpartials._logoutform')



@endsection

@section('footscripts')
<script src="{{ asset('../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        // Datatables Responsive
        $("#user_Request_Details").DataTable({
            responsive: true
        });
    });
</script>

@endsection