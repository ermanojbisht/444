@extends('layouts.type200.main')

@section('pagetitle')
ACR Details
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
	<div class="d-flex justify-content-end bg-transparent">
	</div>


	<div class="row">
		<div class="col-md-6">
			<p class="fw-bold h5"> Office :  </p>
		</div>
		<div class="col-md-6">
			<p class="fw-bold h5"> Period :  </p>
		</div>
	</div>
	<hr>


	<table class="table mb-0 table-bordered ">
		<thead class="table-light fw-bold">
			<tr class="align-middle text-center">
				<th rowspan="2">#</th>
				<th rowspan="2">Acr Id</th>
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
		<tbody>
			@foreach($acrs as $acr)
			<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
				<td>{{1+$loop->index }}</td>
				<td>
					{{$acr->employee->shriName }} : {{$acr->employee->id }}<br>
					@if($acr->accept_on)
					<a href="{{route('acr.view',['acr'=>$acr])}}">{{$acr->id }}</a>
					@else
					Under Process
					@endif
				</td>
				<td>{!! $acr->from_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{!! $acr->to_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{!! ($acr->submitted_at) ?  $acr->submitted_at->format('d&#160;M&#160;Y') : 'New Created ' !!} </td>

				@if(! $acr->is_active )
				<td colspan="6">
					{!! $acr->status() !!}
				</td>
				@else

				<td>{{$acr->report_employee_id ? $acr->reportUser()->shriName : '' }} </td>
				<td> @if ($acr->submitted_at)
					{{ $acr->report_on ? Carbon\Carbon::parse($acr->report_on)->format('d M Y')
					: 'Pending since ' .
					Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->submitted_at)). ' days' }} @endif
				</td>
				<td>{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }} </td>
				<td> @if ($acr->report_on)
					{{ $acr->review_on ? Carbon\Carbon::parse($acr->review_on)->format('d M Y') :
					'Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->report_on)). '
					days' }} @endif
				</td>
				<td>{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }} </td>
				<td>@if ($acr->review_on)
					{{ $acr->accept_on ? Carbon\Carbon::parse($acr->accept_on)->format('d M Y') :
					'Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->review_on)).
					' days' }} @endif </td>

				@endif


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
