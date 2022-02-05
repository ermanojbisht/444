@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('pagetitle')
My ACR
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'View Acr','active'=>true]
]])
@endsection

@section('content')


<hr>

<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.update')}}">
			@csrf

			<div class="form-group">
				<div class="row">

					<div class="col-md-12">
						<table class="table">
							<tr>
								<th>
									<p class=" fw-bold "> Name of the officer Reported Upon :-</p>
								</th>
								<td>
									<p class="data"> {{$employee->name }} </p>
								</td>
							</tr>
							<tr>
								<th>
									<p class=" fw-bold "> Designation Group :-</p>
								</th>
								<td>
									@foreach ($acrGroups as $key=>$name)
									@if ($acr_selected_group_type->group_id == $key )
									<p class="data"> {{$name}} </p>
									@endif
									@endforeach
								</td>
							</tr>
							<tr>
								<th>
									<p class=" fw-bold "> Period Of Appraisal :-</p>
								</th>
								<td>
									<p class="data"> {{$acr->from_date->format('d M Y') }} - {{$acr->to_date->format('d
										M Y') }} </p>
								</td>
							</tr>
						</table>
					</div>
					</p>
				</div>

			</div>

	</div>

	<div class="row">
		<div class="col-md-12 text-center ">
			<p class="fw-bold h3"> Part - 1 ( Basic Information ) </p>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">

			<table class="table">
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 1. During the Appraisal Period :- </p>
						<table style="width:100%">
							<tr>
								<th>
									1.1 Place Of Posting :-
								</th>
								<td>
									{{ $acr->office->name }}
								</td>
							</tr>
						</table>
					</th>
				</tr>
				<tr>
					<th>
						<p class=" fw-bold "> 2. Date of Birth :-</p>
					</th>
					<td>
						{{$employee->birth_date->format('d M Y')}}
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 3. Education Qualification :-</p>
						<table style="width:100%">
							@foreach ($employee->education as $education )
							@if($education->qualifiaction_type_id == 1)
							<tr>
								<th> 3.1 At the time of Joining in the Department : - </th>
								<td> {{$education->qualifiaction }} </td>
							</tr>
							@endif
							@if($education->qualifiaction_type_id == 2)
							<tr>
								<th> 3.2 Qualification acquired during service in the Department : - </th>
								<td> {{$education->qualifiaction }} </td>
							</tr>
							@endif
							@endforeach
						</table>
					</th>
				</tr>

				<tr>
					<th>
						<p class=" fw-bold "> 4. Membership of any Professional Organization : - </p>
					</th>
					<td> 
						{{ $acr->professional_org_membership }}
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 5. Reporting, Reviewing and Accepting Authorities </p>
						<table style="width:100%">
							<tr>
								<td>
									<table class="table ">
										<thead>
											<tr>
												<th>
													<p class=" fw-bold "> Officer </p>
												</th>
												<th>
													<p class=" fw-bold "> Name </p>
												</th>
												<th>
													<p class=" fw-bold "> Designation </p>
												</th>
												<th>
													<p class=" fw-bold "> Period </p>
												</th>
												<th>
													<p class=" fw-bold "> Is Due </p>
												</th>
											</tr>
										</thead>
										<tbody>
											@forelse ($appraisalOfficers as $appraisalOfficer)
											<tr>
												@if( config('acr.basic.appraisalOfficerType')
												[$appraisalOfficer->pivot->appraisal_officer_type] == 'Reporting')
												<td>
													Reporting Authority
												</td>
												<td>{{$appraisalOfficer->name}}</td>
												<td>
													@if ($appraisalOfficer)
													{{ $acr->report_review_Accept_officers('report')->designation->name
													}}
													@endif
												</td>
												@endif
												@if( config('acr.basic.appraisalOfficerType')
												[$appraisalOfficer->pivot->appraisal_officer_type] == 'Reviewing')
												<td>
													Reviewing Authority
												</td>
												<td>{{$appraisalOfficer->name}}</td>
												<td>
													@if ($appraisalOfficer)
													{{ $acr->report_review_Accept_officers('report')->designation->name
													}}
													@endif
												</td>
												@endif
												@if( config('acr.basic.appraisalOfficerType')
												[$appraisalOfficer->pivot->appraisal_officer_type] == 'Accepting')
												<td>
													Accepting Authority
												</td>
												<td>{{$appraisalOfficer->name}}</td>
												<td>
													@if ($appraisalOfficer)
													{{ $acr->report_review_Accept_officers('report')->designation->name
													}}
													@endif
												</td>
												@endif
												<td>
													{{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->format('d M Y')}}
													-
													{{Carbon\Carbon::parse($appraisalOfficer->pivot->to_date)->format('d M Y')}} 

													({{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->diffInDays
													(Carbon\Carbon::parse($appraisalOfficer->pivot->to_date))}} Days)
												</td>
												<td>
													{{config('site.yesNo')[$appraisalOfficer->pivot->is_due]}}
												</td> 
											</tr>

											@empty
											<tr>
												<td colspan="5" rowspan="1" headers="">No Data Found</td>
											</tr>
											@endforelse
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</th>
				</tr>
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 6. Leave (other then Casual Leave) or period of absence </p>
						<table class="table">
							<thead>
								<tr>
									<th>
										Type
									</th>
									<th>
										Period
									</th>
								</tr>
							</thead>
							@forelse ($leaves as $leave)
							<tr>
								<td> {{config('acr.basic.acrLeaveType')[$leave->type_id]}}
									({{Carbon\Carbon::parse($leave->from_date)->
									diffInDays(Carbon\Carbon::parse($leave->to_date))}} Days)</td>
								<td>{{$leave->from_date->format('d M Y')}} - {{$leave->to_date->format('d M Y')}} </td>
							</tr>
							@empty
							<tr>
								<td colspan="5" rowspan="1" headers="">No Data Found</td>
							</tr>
							@endforelse
							</tbody>
						</table>
					</th>
				</tr>
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 7. Appreciation/Honors during the period of appraisal from the department
						</p>
						<table class="table">
							<thead>
								<tr>
									<th>
										S No.
									</th>
									<th>
										Type of Appreciation/Honors
									</th>
									<th>
										Brief Details
									</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($appreciations as $appreciation)
								<tr>
									<td> 7.{{1+$loop->index }}</td>
									<td>{{$appreciation->appreciation_type}}</td>
									<td>{{$appreciation->detail}}</td>
								</tr>
								@empty
								<tr>
									<td colspan="3" rowspan="1" headers="">No Data Found</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</th>
				</tr>
				<tr>
					<th colspan="2">
						<p class=" fw-bold "> 8. Appreciation/Honors during the period of appraisal from the department
						</p>
					
						<table class="table border mb-0">
							<thead class="table-light  fw-bold">
								<tr class="align-middle">
									<th>S No.</th>
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
								@foreach($inbox as $acr)
								<tr>
									<td>8.{{1+$loop->index }}</td>
									<td>{{$acr->employee->name}}</td>
									<td>{{$acr->employee_id}} </td>
									<td>{{$acr->from_date}}</td>
									<td>{{$acr->to_date }}</td>
									<td>{{$acr->created_at->format('d M Y')}} </td>
								</tr>
								@endforeach

								@foreach($reviewed as $acr)
								<tr>
									<td>8.{{1+$loop->index }}</td>
									<td>{{$acr->employee->name}}</td>
									<td>{{$acr->employee_id}} </td>
									<td>{{$acr->from_date}}</td>
									<td>{{$acr->to_date }}</td>
									<td>{{$acr->created_at->format('d M Y')}} </td>
								</tr>
								@endforeach
								
								@foreach($accepted as $acr)
								<tr>
									<td>8.{{1+$loop->index }}</td>
									<td>{{$acr->employee->name}}</td>
									<td>{{$acr->employee_id}} </td>
									<td>{{$acr->from_date}}</td>
									<td>{{$acr->to_date }}</td>
									<td>{{$acr->created_at->format('d M Y')}} </td>
								</tr>
								@endforeach
							</tbody>
						</table>


					 </th> 
				</tr>
				<tr>
					<th>
						<p class=" fw-bold "> 9. Date of Filing Property Return for the Calender Year </p>
					</th>
					<td>
						{{ $acr->property_filing_return_at->format('d M Y') }}
					</td>
				</tr>
			</table>
		</div>
	</div>

</div>

</form>
</div>
</div>


@endsection


@section('footscripts')
@endsection