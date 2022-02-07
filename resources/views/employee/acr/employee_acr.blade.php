@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
{{Auth::User()->name}} ACR Details
@endsection

@section('breadcrumbNevigationButton')

@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
[ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=>  'My Acrs','active'=>true]]])
@endsection

@section('content')
<div class="card">
	<div class="d-flex justify-content-end bg-transparent">
	</div>


	<div class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Employee Code :- </p>
				</div>
				<div class="col-md-6">
					<p class="fw-bold h5 text-info"> {{$employee->id }} </p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<p class="fw-bold h5"> Name :-</p>
				</div>
				<div class="col-md-9">
					<p class="fw-bold h5 text-info"> {{$employee->name }} </p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-5">
					<p class="fw-bold h5"> Designation :-</p>
				</div>
				<div class="col-md-7">
					<p class="fw-bold h5 text-info"> {{$employee->designation->name }} </p>
				</div>
			</div>
		</div>
	</div>
	<hr>


	<table class="table border mb-0">
		<thead class="table-light  fw-bold">
			<tr style="border:1px solid grey" class="align-middle text-center">
				<th rowspan="2">#</th>
				<th colspan="2">Period</th>
				<th rowspan="2">Submitted on</th>
				<th colspan="2">Reported</th>
				<th colspan="2">Reviewed</th>
				<th colspan="2">Accepted</th>
			</tr>
			<tr style="border:1px solid grey" >
				<th>From </th>
				<th>To </th>
				<th>By </th>
				<th>on Date </th>
				<th>By </th>
				<th>on Date </th>
				<th>By </th>
				<th>on Date </th>
			</tr>
		</thead>
		<tbody>
			@foreach($acrs as $acr)
			<tr>
				<td>{{1+$loop->index }}</td>
				<td>{{$acr->from_date->format('d M Y')}}</td>
				<td>{{$acr->to_date->format('d M Y')}}</td>
				<td>{{$acr->created_at->format('d M Y')}} </td>

				<td>{{$acr->report_employee_id}} </td>
				<td>{{$acr->report_on}} </td>

				<td>{{$acr->review_employee_id}} </td>
				<td>{{$acr->review_on}} </td>

				<td>{{$acr->accept_employee_id}} </td>
				<td>{{$acr->accept_on}} </td>
				{{-- <td>
					<div class="dropdown dropstart">
						<button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<svg class="icon icon-xl">
								<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
							</svg>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							@if ($acr->isFileExist())
							<a class="dropdown-item" href="{{route('acr.view', ['acr' => $acr->id])}}">
								<i class="cib-twitter"></i> View ACR
							</a>
							@endif
						</div>
					</div>
				</td> --}}
			</tr>


			@endforeach
		</tbody>
	</table>
</div>

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