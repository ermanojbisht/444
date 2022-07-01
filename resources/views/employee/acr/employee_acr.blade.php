@extends('layouts.type200.main')

@section('pagetitle')
	{{$employee->shriName }}'s ACR Details
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'My Acrs','active'=>true]]])
	@endsection

@section('content')
<div class="card p-3 shadow-lg p-0 mb-5 bg-body rounded">
	<div class="d-flex justify-content-around ">
		<p class="fw-bold h5"> Employee Code : {{$employee->id }} </p>
		<p class="fw-bold h5"> Designation : {{$employee->designation->name }} </p>
	</div>
	@include('employee.acr.form._goBackIcon')
	<table class="table mb-0 table-bordered " id="myTable">
		<thead class="table-light fw-bold">
			<tr class="align-middle text-center">
				<th>#</th>
				<th>Year</th>
				<th>From</th>
				<th>Till</th>
				<th>Status</th>
				<th>Reported By</th>
				<th>Reviewed By</th>
				<th>Accepted By</th>
				<th>Analysis</th>
				<th>Action</th>
				@if($isMyAcr)
					<th>No</th>
				@else
				@can('acr-special')
					<th>No</th>				
				@endcan
				@endif
				
			</tr>
		</thead>
		<tbody>
			@foreach($acrs as $acr)
			<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
				<td data-sort="{{ $acr->id }}">{{1+$loop->index }}</td>
				<td  class="align-middle">{{$acr->getFinancialYearAttribute()}}</td>
				<td>{!! $acr->from_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{!! $acr->to_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{{$acr->status() }}</td>

				@if(! $acr->is_active )
					<td colspan="6">
						{!! $acr->status() !!}
					</td>
				@else

				<td>	
					{{$acr->report_employee_id ? $acr->reportUser()->shriName : '' }} 
					@if ($acr->submitted_at)
						{{ $acr->report_on ? ' on '.Carbon\Carbon::parse($acr->report_on)->format('d M Y')
						: ' Pending since '.Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->submitted_at)).' days' }}
					@endif
				
				</td>
				<td>
					{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }} 
					@if ($acr->report_on)
						{{ $acr->review_on ? ' on '. Carbon\Carbon::parse($acr->review_on)->format('d M Y') :' Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->report_on)) . ' days' }} 
					@endif
				</td>
				<td>
					{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }}
					@if ($acr->review_on) 
						{{ $acr->accept_on ? ' on '.Carbon\Carbon::parse($acr->accept_on)->format('d M Y') : ' Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->review_on)) .' days' }} 
					@endif 
				</td>
				<td>
					@if($acr->missing >1)               
                    wrong ( {{($acr->missing-1)}} ) days
                    @else
                    ok!
                    @endif
				</td>
				<td class="d-flex d-flex justify-content-around">
					@if(!$acr->submitted_at && !$acr->is_acknowledged)
						@can('acknowledge-acr')
                            @if($acr->acknowladgeable())
							<form action="{{ route('acr.others.acknowledged') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" >
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="acr_id" value="{{ $acr->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Acknowledge</button>
                            </form>
                            @else
                            User Has not yet not filled his appraisal officers
                            @endif
                            <a href="{{ route('acr.others.reject',['acr'=>$acr->id,'dutyType'=>'rejectByNodal'])}}" class="btn btn-outline-danger btn-sm">Reject</a>
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
					@endif
				</td>
				@endif
				@if($isMyAcr)
					<td>{{$acr->accept_no}}</td>
				@else
				@can('acr-special')
					<td>{{$acr->accept_no}}</td>				
				@endcan
				@endif
				
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
@section('footscripts')
	<script src="{{ asset('../js/jquery.table.marge.js') }}"></script>
	<script type="text/javascript">
		$('#myTable').margetable({
		  type: 2,
		  colindex: [1]
		});
	</script>
@endsection
