@extends('layouts.type200.main')
  
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
 My ACR 
@endsection

@section('breadcrumbNevigationButton')
{{-- <div class="btn-group" role="group" aria-label="Basic example">
	<a class="btn btn-outline-dark" href="{{route('index')}}" data-coreui-toggle="tooltip" data-coreui-html="true"
		data-coreui-placement="bottom" title="<h6>All Estimate</h6>">
		<svg class="icon icon-lg">
			<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
		</svg>
	</a>
	<a class="btn btn-outline-dark" href="{{route('myAcr')}}" data-coreui-toggle="tooltip" data-coreui-html="true"
		data-coreui-placement="bottom" title="<h6> My Estimate</h6>">
		<svg class="icon icon-lg">
			<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-user-plus')}}"></use>
		</svg>
	</a>
</div> --}}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [['label'=> Auth::User()->name . '\'s' . ' Acrs','active'=>true]]])
@endsection

@section('content')
<div class="card">
	<div class="d-flex justify-content-end bg-transparent">
		{{-- $estimate->id --}}
		{{-- <a class="btn btn-sm btn-dark m-2 " href="{{route('create', ['acr' => 1 ])}}">  
			
			<svg class="icon">
				<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
			</svg>
			Create New
		</a> --}}
	</div>
	{{-- <div class="table-responsive"> --}}
		
		<table class="table border mb-0">
			<thead class="table-light  fw-bold">
				<tr class="align-middle">
					<th>#</th>
					<th>Employee Name</th>
					<th>Employee Id</th>
					<th>From Date</th>
					<th>To Date</th>
					<th>Created on</th>
					<th>Status</th> 
					<th></th>
				</tr>
			</thead>
			<tbody>
				{{--   <td> {{$acr->creator->name}} ({{$acr->creator->designation}})</td> --}}
				@foreach($acrs as $acr)
				<tr>
					<td>{{1+$loop->index  }}</td>
					<td>{{ $acr->getEmployeeData->name}}</td>
					
					<td>{{$acr->employee_id}} </td>
					<td>{{$acr->from_date}}</td>  
					<td>{{$acr->to_date }}</td>
					<td>{{$acr->created_at->format('d M Y')}} </td>
					<td>
						<div class="dropdown dropstart">
							<button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<svg class="icon icon-xl">
									<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
								</svg>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item"
									href="{{route('acr.addOfficers', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Add Officers For Report / Review / Accept ACR
								</a>

								<a class="dropdown-item"
									href="{{route('acr.addAcrForm', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Add ACR Form
								</a>

								<a class="dropdown-item"
									href="{{route('acr.submit', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Submit ACR
								</a>
								{{-- will be as log out form  --}}


								@if($acr->estimate)
								<a class="dropdown-item"
									href="{{route('track.estimate.view', ['acr_estimate' => $acr->estimate->id])}}">
									<i class="cib-twitter"></i>View
								</a>
								<a class="dropdown-item"
									href="{{route('efc.show', ['acr_estimate' => $acr->estimate->id])}}">
									<i class="cib-twitter"></i>EFC
								</a>
								@endif
							</div>

						</div>
					</td>
				</tr>

				
				@endforeach

				{{-- <div class="dropdown-menu dropdown-menu-end">
								@if($acr->estimate)
								<a class="dropdown-item"
									href="{{route('track.estimate.view', ['acr_estimate' => $acr->estimate->id])}}">
									<i class="cib-twitter"></i>View
								</a>
								<a class="dropdown-item"
									href="{{route('efc.show', ['acr_estimate' => $acr->estimate->id])}}">
									<i class="cib-twitter"></i>EFC
								</a>
								@endif
								@if(($acr->user_id == Auth::user()->id) ||
								($acr->lastHistory() && $acr->lastHistory()->to_id
								&& $acr->lastHistory()->to_id == Auth::user()->id))

								@if(! $acr->estimate)
								<a class="dropdown-item" href="{{route('estimate.create', ['id' => $acr->id])}}">
									Add Estimate
								</a>
								@else
								<a class="dropdown-item"
									href="{{route('estimate.edit', ['estimateId' => $acr->estimate->id])}}">
									Edit Estimate
								</a>
								<a class="dropdown-item"
									href="{{route('estimate.editDetails', ['acr_estimate' => $acr->estimate->id])}}">
									Edit Estimate Details
								</a>
								<a class="dropdown-item"
									href="{{route('movement', ['acrId' => $acr->id,'senderId' => Auth::user()->id])}}">
									Move acr
								</a>
								<a class="dropdown-item"
									href="{{route('editEstimateStatus', ['acrId' => $acr->id])}}">
									Update acr
								</a>
								@endif
								@endif
							</div> --}}
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