@extends('layouts.type200.main')

@section('pagetitle')
ACR List
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
	['label'=> 'ACR List','active'=>true]
	]
])
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<form method="GET" action="{{route('office.acrs.view')}}">
			<div class="row d-flex justify-content-between">
				<div class="col-md-3">
					<p class="fw-bold mb-0"> Office : </p>
					<div class="form-group"> 
						<select id='office_id' name='office_id' required class="form-select select2">
							<option value="0" {{( $officeId==0 ? 'selected' : '' )}} disabled> Select Office </option>
							<option value="all" {{( $officeId=='all' ? 'selected' : '' )}}> All</option>
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
						<input type="submit" class="btn btn-info"  value="Search"/>
					</p>
				</div>
			</div>
		</form>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<p class="fw-bold h5"> Period : </p>
			</div>
		</div>
		<table class="table mb-0 table-bordered ">
			<thead class="table-light fw-bold">
				<tr class="align-middle text-center">
					<th rowspan="2">#</th>
					<th rowspan="2">Employee Name</th>
					<th rowspan="2">Employee Id</th>
					<th rowspan="2">Year</th>
					<th colspan="2">Period</th>
					<th rowspan="2">Submitted on</th>
					<th colspan="2">Reported</th>
					<th colspan="2">Reviewed</th>
					<th colspan="2">Accepted</th>
					<th rowspan="2">Status</th>
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
				@if($acrs)
				@foreach($acrs as $acr)
				<tr class="{!! $acr->status_bg_color() !!} text-center" style="--cui-bg-opacity: .25;">
					<td>{{1+$loop->index }}</td> 
					<td class="text-start">
						<a class="text-decoration-none" href="{{route('employee.acr.view',['employee'=>$acr->employee_id])}}">
							{{$acr->employee->shriName }}
						</a>
						
					</td>
					<td> {{$acr->employee->id }}</td>
					<td> {{$acr->getFinancialYearAttribute()}}</td>

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
						' days' }} @endif 
					</td>
					<td>
						@if($acr->accept_on)
							<a href="{{route('acr.view',['acr'=>$acr])}}">
								<svg class="icon icon-xl">
									<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-cloud-download')}}">
									</use>
								</svg>
							</a>
						@elseif (!$acr->is_active)
							Rejected
						@else
							Under Process
						@endif
					</td>

					@endif
				</tr>
				@endforeach
				@endif
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
    });

</script>
@include('layouts._commonpartials.js._select2')


@endsection