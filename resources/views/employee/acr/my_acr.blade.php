@extends('layouts.type200.main')

@section('styles')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
{{Auth::User()->shriName}}'s ACR
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
					<th>Year</th>
					<th>Period</th>
					<th>Created on</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{{-- <td> {{$acr->creator->shriName}} ({{$acr->creator->designation}})</td> --}}
				@foreach($acrs as $acr)
				<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
					<td>{{1+$loop->index }}</td>
					<td>{{$acr->getFinancialYearAttribute()}}</td>
					<td>{{$acr->from_date->format('d M Y')}} to {{$acr->to_date->format('d M Y')}}</td>
					<td>{{$acr->created_at->format('d M Y')}} </td>
					<td>{!! $acr->status() !!} </td>
					<td>
						<div class="dropdown dropstart">
							<button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<svg class="icon icon-xl">
									<use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
								</svg>
							</button>
							<div class="dropdown-menu dropdown-menu-end">

								@if (!$acr->submitted_at && ! $acr->is_byhr)
								<a class="dropdown-item" href="{{route('acr.edit', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Edit Basic Detail
								</a>
								@if(!$acr->is_acknowledged )
									<a class="dropdown-item" href="{{route('acr.addOfficers', ['acr' => $acr->id])}}">
										<i class="cib-twitter"></i>Add Officers For Report / Review / Accept ACR
									</a>
								@endif
								<a class="dropdown-item" href="{{route('acr.addLeaves', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Add Leaves / Absence
								</a>
								<a class="dropdown-item" href="{{route('acr.addAppreciation', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Add Appreciation / Honors
								</a>
								<a class="dropdown-item" href="{{route('acr.form.create1', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i>Add Part -II Self-Appraisal
								</a>
								@if(!$acr->is_acknowledged )
	                                <a class="dropdown-item" href="#">
	                                    <form action="{{ route('acr.destroy') }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" >
	                                        <input type="hidden" name="_method" value="POST">
	                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                        <input type="hidden" name="acr_id" value="{{ $acr->id }}">
	                                        <button type="submit" style="width:100%;" class="btn btn-danger "> Delete ACR
	                                                </button>
	                                    </form>
	                                </a>
                                @endif

								@if($acr->hasAppraisalOfficer(1) && $acr->hasAppraisalOfficer(2))
									@if($acr->isTwoStep || $acr->hasAppraisalOfficer(3))
										<a class="dropdown-item" href="#">
											<form action="{{ route('acr.submit', [ 'acr_id'=> $acr->id]) }}" method="POST"
												onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त दिए गए प्रपत्र एवं डाटा से में सहमत हूँ  ) ??? ');">
												{{ csrf_field() }}
												<button type="submit" style="width:100%;" class="btn btn-success "> Submit ACR
												</button>
											</form>
										</a>
									@endif
								@endif

								@endif  
								@if ($acr->accept_on || (!$acr->report_on && !$acr->review_on))
								@if ($acr->isFileExist())
								<a class="dropdown-item" href="{{route('acr.view', ['acr' => $acr->id])}}">
									<i class="cib-twitter"></i> View ACR
								</a>
								@endif
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
					<a class="dropdown-item" href="{{route('efc.show', ['acr_estimate' => $acr->estimate->id])}}">
						<i class="cib-twitter"></i>EFC
					</a>
					@endif
					@if(($acr->user_id == Auth::id()) ||
					($acr->lastHistory() && $acr->lastHistory()->to_id
					&& $acr->lastHistory()->to_id == Auth::id()))

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
						href="{{route('movement', ['acrId' => $acr->id,'senderId' => Auth::id()])}}">
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
