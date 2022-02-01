@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Other's ACR to be Worked Upon
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [['label'=> Auth::User()->name . '\'s' . '
Acrs','active'=>true]]])
@endsection

@section('content')
<div class="card">



	<div class="row">

		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header"><strong> ACR's </strong><span class="small ms-1"> {{ 1 }}</span></div>
				<div class="card-body">
					<p class="text-medium-emphasis small">Add <code>.accordion-flush</code> to remove the default
						<code>background-color</code>, some borders, and some rounded corners to render accordions
						edge-to-edge with their parent container.</p>
					<div class="example">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-coreui-toggle="tab" href="#report" role="tab"
									aria-selected="false"> Acr For Reporting
									<span class="badge badge-sm bg-info ms-auto"> {{ 1 }}</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-coreui-toggle="tab" href="#review" role="tab"
									aria-selected="true"> Acr For Reviewing
									<span class="badge badge-sm bg-info ms-auto"> {{ 0 }}</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-coreui-toggle="tab" href="#accept" role="tab"
									aria-selected="true"> Acr For Accepting
									<span class="badge badge-sm bg-info ms-auto"> {{ 0 }}</span></a>
							</li>
						</ul>
						<div class="tab-content rounded-bottom">
							<div class="tab-pane p-3 active" role="tabpanel" id="report">
								tab 1 body
							</div>
							<div class="tab-pane p-3 " role="tabpanel" id="review">
								tab 2 body
							</div>
							<div class="tab-pane p-3 " role="tabpanel" id="accept">
								tab 3 body
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



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
			{{-- <td> {{$acr->creator->name}} ({{$acr->creator->designation}})</td> --}}
			@foreach($reported as $acr)
			<tr>
				<td>{{1+$loop->index }}</td>
				<td>{{ $acr->employee->name}}</td>

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
							<a class="dropdown-item" href="{{route('acr.addOfficers', ['acr' => $acr->id])}}">
								<i class="cib-twitter"></i> View ACR
							</a>



							<a class="dropdown-item" href="{{route('acr.submit', ['acr' => $acr->id])}}">
								<i class="cib-twitter"></i>Process ACR
							</a>
							{{-- ToDo: Made will be as log out form --}}


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
				<a class="dropdown-item" href="{{route('efc.show', ['acr_estimate' => $acr->estimate->id])}}">
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
				<a class="dropdown-item" href="{{route('estimate.edit', ['estimateId' => $acr->estimate->id])}}">
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
				<a class="dropdown-item" href="{{route('editEstimateStatus', ['acrId' => $acr->id])}}">
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
