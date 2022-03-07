@extends('layouts.type200.main')

@section('pagetitle')
{{$employee->shriName }}'s ACR Details
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
			<p class="fw-bold h5"> Employee Code : {{$employee->id }} </p>
		</div>
		<div class="col-md-6">
			<p class="fw-bold h5"> Designation : {{$employee->designation->name }} </p>
		</div>
	</div>
	<hr>


	<table class="table mb-0 table-bordered ">
		<thead class="table-light fw-bold">
			<tr class="align-middle text-center">
				<th rowspan="2">#</th>
				
				<th colspan="2">Period</th>
				<th rowspan="2">Status</th>
				<th colspan="2">Reported</th>
				<th colspan="2">Reviewed</th>
				<th colspan="2">Accepted</th>
				<th rowspan="2">Acr Id</th>
				<th rowspan="2">analysis</th>
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
				
				<td>{!! $acr->from_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{!! $acr->to_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{{$acr->status() }}</td>

				@if(! $acr->is_active )
				<td colspan="6">
					{!! $acr->status() !!}
				</td>
				@else

				<td>{{$acr->report_employee_id ? $acr->reportUser()->shriName : '' }} </td>
				<td> @if ($acr->submitted_at)
					{{ $acr->report_on ? Carbon\Carbon::parse($acr->report_on)->format('d M Y')
					: 'Pending since ' .
					Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->submitted_at)) . ' days' }} @endif
				</td>
				<td>{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }} </td>
				<td> @if ($acr->report_on)
					{{ $acr->review_on ? Carbon\Carbon::parse($acr->review_on)->format('d M Y') :
					'Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->report_on)) . '
					days' }} @endif
				</td>
				<td>{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }} </td>
				<td>@if ($acr->review_on)
					{{ $acr->accept_on ? Carbon\Carbon::parse($acr->accept_on)->format('d M Y') :
					'Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->review_on)) .
					' days' }} @endif </td>
				<td>
					@if(!$acr->submitted_at && !$acr->is_acknowledged)
						@can('acknowledge-acr')
							<form action="{{ route('acr.others.acknowledged') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" >
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="acr_id" value="{{ $acr->id }}">
                                <button type="submit" style="width:100%;" class="btn btn-danger "> Acknowledge ACR
                                        </button>
                            </form>
						@endcan
					@endif
					@if($acr->accept_on)
						<a href="{{route('acr.view',['acr'=>$acr])}}" class="text-decoration-none">
							<svg class="icon icon-xl">
								<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-cloud-download')}}">
								</use>
							</svg>
						</a>
						@can('acr-special')
							@if(!$acr->old_accept_no)
					        	<a href="{{route('acr.edit.alteredAcr',['acr'=>$acr])}}" class="text-decoration-none">
									<svg class="icon icon-xl">
										<use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-pencil')}}">
										</use>
									</svg>
								</a>
							@endif
				        @endcan
					@else
							--
					@endif

				</td>
				@endif
				<td>
					@if($acr->missing >1)               
                    wrong ( {{($acr->missing-1)}} ) days
                    @else
                    ok!
                    @endif
				</td>


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
