@extends('layouts.type200.main')

@section('pagetitle')
ACR Details
@endsection

@section('styles')
@include('layouts._commonpartials.css._select2')
@endsection


@section('breadcrumbNevigationButton')

@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
[ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs','active'=>true]]])
@endsection

@section('content')
<div class="card">

	<div class="card-body">


		<form method="GET" action="{{route('office.acrs.view', ['office'=> 0])}}">

			<div class="row">

				<div class="col-md-2">
					<div class="form-group">
						{{ Form::label('officeType','Select Office Type',[ 'class'=>' required']) }}

						<select id='officeTypeId' name='officeType' required class="form-select ">
								<option value="all"> All Office ACR's </option>
								@foreach ($Officetypes as $key => $values)
									<option value="{{$key}}" > {{$values}} </option>
								@endforeach
							</select>

						</select>

						{{-- {{ Form::select('officeType',($Officetypes),old('officeType'),['placeholder'=>'Select
						Office Type','id'=>'officeTypeId','class'=>'form-select', 'required']) }} --}}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						{{ Form::label('office_id','Select Office Name',[ 'class'=>' required']) }}
						<select id="office_id" name="office_id" required class="form-select select2">
						</select>
					</div>
				</div>

				<div class="col-md-2">
					<p class="fw-bold h5"> Start Date :
						<input type="date" name="start" format="dd/mm/yyyy" class="form-control"
							value="{{old('start')}}">
					</p>
				</div>
				<div class="col-md-2">
					<p class="fw-bold h5"> End Date :
						<input type="date" name="end" format="dd/mm/yyyy" class="form-control" value="{{old('end')}}">
					</p>
				</div>
				<div class="col-md-2">
					<p class="mt-4">
						<input type="submit" class="btn btn-sm btn-success" />
					</p>
				</div>
			</div>
		</form>
		<hr>

		<div class="row">
			<div class="col-md-6">
				<p class="fw-bold h5"> Office : </p>
			</div>
			<div class="col-md-6">
				<p class="fw-bold h5"> Period : </p>
			</div>
		</div>
		<hr>

		<table class="table mb-0 table-bordered ">
			<thead class="table-light fw-bold">
				<tr class="align-middle text-center">
					<th rowspan="2">#</th>
					<th rowspan="2">Acr Id</th>
					<th rowspan="2">Employee Name</th>
					<th rowspan="2">Employee Id</th>
					<th colspan="2">Period</th>
					<th rowspan="2">Submitted on</th>
					<th colspan="2">Reported</th>
					<th colspan="2">Reviewed</th>
					<th colspan="2">Accepted</th>
				</tr>
				<tr class="align-middle text-center">
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
			<tbody style="border:1px solid #C8CBD2;">
				@foreach($acrs as $acr)
				<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
					<td>{{1+$loop->index }}</td>
					<td>
						@if($acr->accept_on)
						<a href="{{route('acr.view',['acr'=>$acr])}}"> View Acr </a>
						@elseif (!$acr->is_active)
						Rejected
						@else
						Under Process
						@endif
					</td>
					<td>{{$acr->employee->shriName }}</td>
					<td> {{$acr->employee->id }}</td>

					<td>{!! $acr->from_date->format('d&#160;M&#160;Y') !!}</td>
					<td>{!! $acr->to_date->format('d&#160;M&#160;Y') !!}</td>
					<td>{!! ($acr->submitted_at) ? $acr->submitted_at->format('d&#160;M&#160;Y') : 'New Created ' !!}
					</td>

					@if(! $acr->is_active )
					<td colspan="6">
						{!! $acr->status() !!}
					</td>
					@else

					<td>{{$acr->report_employee_id ? $acr->reportUser()->shriName : '' }} </td>
					<td> @if ($acr->submitted_at)
						{{ $acr->report_on ? Carbon\Carbon::parse($acr->report_on)->format('d M Y')
						: 'Pending since ' .
						Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->submitted_at)). ' days' }}
						@endif
					</td>
					<td>{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }} </td>
					<td> @if ($acr->report_on)
						{{ $acr->review_on ? Carbon\Carbon::parse($acr->review_on)->format('d M Y') :
						'Pending since ' .
						Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->report_on)). '
						days' }} @endif
					</td>
					<td>{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }} </td>
					<td>@if ($acr->review_on)
						{{ $acr->accept_on ? Carbon\Carbon::parse($acr->accept_on)->format('d M Y') :
						'Pending since ' .
						Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->review_on)).
						' days' }} @endif </td>

					@endif


				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</div>

@endsection



@section('footscripts')
<script src="{{ asset('../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('.select2').select2({
		});

	
		$('#officeTypeId').change(function (e) {
			e.preventDefault();
			$filterParam = $(this).val(); // or $('#officeTypeId').val();
			$.ajax
			({
				url: '{{ url('getOfficesfromOfficeType') }}/' + $filterParam,
				type: 'GET',
				success: function (data) {
					console.log(data); 
					bindDdlWithDataAndSetValue("office_id", data, "id", "name", true, "", "Select Office", "");
				}
			});
		});
    });

</script>
@include('layouts._commonpartials.js._select2')
@include('partials.js._employeeSelect2DropDownJs')
@include('partials.js._employeeDDProcessHelperJs')

@include('partials.js._makeDropDown')

@endsection