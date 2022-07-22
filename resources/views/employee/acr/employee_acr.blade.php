@extends('layouts.type200.main')

@section('pagetitle')
	{{$employee->shriName }}'s ACR Details
@endsection

@section('styles')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
    <style type="text/css">
    	.buttons-columnVisibility{
    		display: block;
  			width: 100%;
    	}

    </style>
@endsection

@section('headscripts')

@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'My Acrs','active'=>true]]])
	@endsection

@section('content')
<div class="card p-3 shadow-lg p-0 mb-5 bg-body rounded">
	<p class="h5"> Employee Code : {{$employee->id}} </p>
	<p class="h5"> Name : {{$employee->getShriNameAttribute()}} </p>
	<p class="h5"> Father's Name : {{$employee->father_name}} </p>
	<p class="h5"> Date fo Birth: {{$employee->birth_date->format('d M Y')}} </p>
	<p class="h5"> Current Designation : {{$employee->designation->name }} </p>
	<p class="h5"> Current Office: {{$employee->office->name}} </p>
	@include('employee.acr.form._goBackIcon')
	<hr>
	<table class="table mb-0 table-bordered " id="myTable" >
		<thead class="table-light fw-bold">
			<tr class="align-middle text-center">
				<th>#</th>
				<th>EmployeeCode</th>
				<th>Name</th>
				<th>Father's Name</th>
				<th>Date fo Birth</th>
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
					<th>Marks</th>
				@else
					@can('acr-special')
						<th>Marks</th>				
					@endcan
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($acrs as $acr)
			<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
				<td data-sort="{{ $acr->id }}">{{1+$loop->index }}</td>
				<td  class="align-middle">{{$employee->id}}</td>
				<td  class="align-middle">{{$employee->getShriNameAttribute()}}</td>
				<td  class="align-middle">{{$employee->father_name}}</td>
				<td  class="align-middle">{{$employee->birth_date->format('d M Y')}}</td>
				<td  class="align-middle">{{$acr->getFinancialYearAttribute()}}</td>
				<td>{!! $acr->from_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{!! $acr->to_date->format('d&#160;M&#160;Y') !!}</td>
				<td>{{$acr->status()}}</td>
				@if(!$acr->is_active )
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					@if($isMyAcr)
					<th></th>
					@else
						@can('acr-special')
							<th></th>				
						@endcan
					@endif
				@else

				<td>	
					@if ($acr->submitted_at)
						{{$acr->report_employee_id ? $acr->reportUser()->shriName : ''}}{{ $acr->report_on ? ' on '.Carbon\Carbon::parse($acr->report_on)->format('d M Y'):' Pending since '.Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->submitted_at)).' days' }}
					@else
						{{$acr->report_employee_id ? $acr->reportUser()->shriName : ''}}
					@endif
				</td>
				<td>
					 
					@if ($acr->report_on)
						{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }}{{ $acr->review_on ? ' on '. Carbon\Carbon::parse($acr->review_on)->format('d M Y') :' Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->report_on)) . ' days' }} 
					@else
						{{$acr->review_employee_id ? $acr->reviewUser()->shriName : '' }}
					@endif
				</td>
				<td>
					@if ($acr->review_on) 
						{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }}{{ $acr->accept_on ? ' on '.Carbon\Carbon::parse($acr->accept_on)->format('d M Y') : ' Pending since ' . Carbon\Carbon::parse(now())->diffInDays(Carbon\Carbon::parse($acr->review_on)) .' days' }} 
					@else
						{{$acr->accept_employee_id ? $acr->acceptUser()->shriName : '' }}
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
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
{{-- <script src="{{ asset('../js/jquery.table.marge.js') }}"></script> --}}
	<script type="text/javascript">
	$(document).ready(function() {
	    $('#myTable').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            {
	                extend: 'copyHtml5',
	                exportOptions: {
	                    columns: [ 0, ':visible' ]
	                }
	            },
	            {
	                extend: 'excelHtml5',
	                exportOptions: {
	                    columns: ':visible'
	                }
	            },
	            
	            'colvis'
	        ]
	    } );
	} );
	</script>
@endsection
