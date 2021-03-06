@extends('layouts.type200.main')

@section('styles')
 
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])

@endsection

@section('pagetitle')
Other's ACR to be Worked Upon
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Inbox','active'=>true]]])
@endsection

@section('content')
<div class="card">

	<div class="row">
		<div class="col-12">
			<div class="card mb-4">
				<div class="card-header"><strong> ACR in Your Inbox </strong>
					<span class="badge badge-sm bg-info ms-auto"> {{ $reported->count()
						+ $reviewed->count() + $accepted->count() }} </span>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-coreui-toggle="tab" href="#report" role="tab"
								aria-selected="false"> Acr For Reporting
								<span class="badge badge-sm bg-info ms-auto"> {{ $reported->count() }}</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-coreui-toggle="tab" href="#review" role="tab" aria-selected="true">
								Acr For Reviewing
								<span class="badge badge-sm bg-info ms-auto"> {{$reviewed->count() }}</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-coreui-toggle="tab" href="#accept" role="tab" aria-selected="true">
								Acr For Accepting
								<span class="badge badge-sm bg-info ms-auto"> {{ $accepted->count() }}</span></a>
						</li>
					</ul>
					<div class="tab-content rounded-bottom">
						<div class="tab-pane p-3 active" role="tabpanel" id="report">
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
									@foreach($reported as $acr)
									<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
										<td>{{1+$loop->index }}</td>
										<td>{{ $acr->employee->name}}</td>

										<td>{{$acr->employee_id}} </td>
										<td>{{Carbon\Carbon::parse($acr->from_date)->format('d M Y')}}</td>
										<td>{{Carbon\Carbon::parse($acr->to_date)->format('d M Y')}}</td>
										<td>{{$acr->created_at->format('d M Y')}} </td>
										<td>{!! $acr->status() !!}</td>
										<td>
											<div class="dropdown dropstart">
												<button class="btn btn-transparent p-0" type="button"
													data-coreui-toggle="dropdown" aria-haspopup="true"
													aria-expanded="false">
													<svg class="icon icon-xl">
														<use
															xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}">
														</use>
													</svg>
												</button>
												<div class="dropdown-menu dropdown-menu-end">													
													@if ($acr->isFileExist())
													<a class="dropdown-item"
														href="{{route('acr.view', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i> View ACR
													</a>
													@endif
													<a class="dropdown-item   bg-info"
														href="{{route('acr.form.appraisal1', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i>Process ACR
													</a>
													@if ($acr->report_no > 0 || !$acr->is_due)
													<a class="dropdown-item text-white bg-success" style="width: 100%;"
														href="{{route('acr.others.report.submit', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i>Submit ACR
													</a>													
													@endif
													<a class="dropdown-item text-white bg-danger" style="width: 100%;"
														href="{{route('acr.others.reject', ['acr' => $acr->id, 'dutyType' => 'report'])}}">
														<i class="cib-twitter"></i>Reject ACR
													</a>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="tab-pane p-3 " role="tabpanel" id="review">

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
									@foreach($reviewed as $acr)
									<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
										<td>{{1+$loop->index }}</td>
										<td>{{ $acr->employee->name}}</td>

										<td>{{$acr->employee_id}} </td>
										<td>{{Carbon\Carbon::parse($acr->from_date)->format('d M Y')}}</td>
										<td>{{Carbon\Carbon::parse($acr->to_date)->format('d M Y')}}</td>
										<td>{{$acr->created_at->format('d M Y')}} </td>
										<td>
											{!! $acr->status() !!}
										</td>
										<td>
											<div class="dropdown dropstart">
												<button class="btn btn-transparent p-0" type="button"
													data-coreui-toggle="dropdown" aria-haspopup="true"
													aria-expanded="false">
													<svg class="icon icon-xl">
														<use
															xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}">
														</use>
													</svg>
												</button>
												<div class="dropdown-menu dropdown-menu-end">
													@if ($acr->isFileExist())
													<a class="dropdown-item"
														href="{{route('acr.view', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i> View ACR
													</a>
													@endif

													<a class="dropdown-item bg-info"
														href="{{route('acr.form.appraisal2', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i>Process ACR
													</a>
													@if ($acr->review_no > 0 || !$acr->is_due)
														@if(is_null($acr->report_integrity))
								                            <a class="dropdown-item text-white bg-warning" style="width: 100%;"
								                              href="{{route('acr.others.report.submit', ['acr' => $acr->id])}}">
								                              <i class="cib-twitter"></i>Submit ACR With Integrity
								                            </a>
								                         @else
															<a class="dropdown-item text-white bg-success" href="#">
																<form method="POST"
																	action="{{ route('acr.others.review.save') }}"
																	onsubmit="return confirm('Above Written Details are correct to my knowledge. ( ????????????????????? ????????? ?????? ????????????????????? ????????? ???????????? ?????? ????????? ???????????? ?????????  ) ??? ');">
																	{{ csrf_field() }}
																	<input type="hidden" name="acr_id" value="{{$acr->id}}" />
																	<button type="submit" style="width:100%;"
																		class="btn btn-success "> Submit ACR
																	</button>
																</form>
															</a>												
															@endif												
														@endif												
													<a class="dropdown-item text-white bg-danger" style="width: 100%;"
														href="{{route('acr.others.reject', ['acr' => $acr->id, 'dutyType' => 'review'])}}">
														<i class="cib-twitter"></i>Reject ACR
													</a>
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="tab-pane p-3 " role="tabpanel" id="accept">
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
									@foreach($accepted as $acr)
									<tr class="{!! $acr->status_bg_color() !!}" style="--cui-bg-opacity: .25;">
										<td>{{1+$loop->index }}</td>
										<td>{{ $acr->employee->shriName}}</td>
										<td>{{$acr->employee_id}} </td>
										<td>{{Carbon\Carbon::parse($acr->from_date)->format('d M Y')}}</td>
										<td>{{Carbon\Carbon::parse($acr->to_date)->format('d M Y')}}</td>
										<td>{{$acr->created_at->format('d M Y')}} </td>
										<td>{!! $acr->status() !!}</td>
										<td>
											<div class="dropdown dropstart">
												<button class="btn btn-transparent p-0" type="button"
													data-coreui-toggle="dropdown" aria-haspopup="true"
													aria-expanded="false">
													<svg class="icon icon-xl">
														<use
															xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}">
														</use>
													</svg>
												</button>
												<div class="dropdown-menu dropdown-menu-end">

													@if ($acr->isFileExist())
													<a class="dropdown-item"
														href="{{route('acr.view', ['acr' => $acr->id])}}">
														<i class="cib-twitter"></i> View ACR
													</a>
													@endif
													{{-- @if ($acr->review_no > 0 || !$acr->is_due) Condition should not be checked because only one button to act--}}
													{{-- @if ($acr->review_no > 0) --}}
													@if(is_null($acr->report_integrity))
							                            <a class="dropdown-item text-white bg-warning" style="width: 100%;"
							                              href="{{route('acr.others.report.submit', ['acr' => $acr->id])}}">
							                              <i class="cib-twitter"></i>Fill Integrity
							                            </a>
							                         @else
														<a class="dropdown-item text-white bg-success " style="width: 100%;"
															href="{{route('acr.others.accept.submit', ['acr' => $acr->id])}}">
															<i class="cib-twitter"></i> Process and Submit ACR
														</a>
													@endif


													<a class="dropdown-item text-white bg-danger" style="width: 100%;"
														href="{{route('acr.others.reject', ['acr' => $acr->id, 'dutyType' => 'accept'])}}">
														<i class="cib-twitter"></i>Reject ACR
													</a>

													{{-- @endif --}}
												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
