@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-body">
		<div class="form-group">
			<div class="row">

				<div class="col-md-12">
					<table class="table">
						<tr>
							<td>
								<span class=" fw-bold "> Name of the officer Reported Upon :-</span>
							</td>
							<td>
								<span class="data"> {{$employee->name }} </span>
							</td>
						</tr>
						<tr>
							<td>
								<p class=" fw-bold "> Period Of Appraisal :-</p>
							</td>
							<td>
								<span class="data"> {{$acr->from_date->format('d M Y') }} - {{$acr->to_date->format('d
									M Y') }} </span>
							</td>
						</tr>
					</table>
				</div>
				</span>
			</div>

			<div class="row">
				<div class="col-md-12 text-center ">
					<span class="fw-bold h3"> Part - 1 ( Basic Information ) </span>
				</div>
			</div>

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
                                                    <tr><td>
                                                        @if( config('acr.basic.appraisalOfficerType')
                                                        [$appraisalOfficer->pivot->appraisal_officer_type] ==
                                                        'Reporting')
                                                        Reporting Authority
                                                        @endif
                                                        @if( config('acr.basic.appraisalOfficerType')
                                                        [$appraisalOfficer->pivot->appraisal_officer_type] ==
                                                        'Reviewing')Reviewing Authority
                                                        @endif
                                                        @if( config('acr.basic.appraisalOfficerType')
                                                        [$appraisalOfficer->pivot->appraisal_officer_type] ==
                                                        'Accepting')
                                                        Accepting Authority
                                                        @endif
                                                        </td>
                                                        <td>{{$appraisalOfficer->name}}</td>
                                                        <td>{{$appraisalOfficer->designation->name}}</td>
                                                        <td>
                                                            {{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->format('d
                                                            M Y')}}
                                                            -
                                                            {{Carbon\Carbon::parse($appraisalOfficer->pivot->to_date)->format('d
                                                            M Y')}}

                                                            ({{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->diffInDays
                                                            (Carbon\Carbon::parse($appraisalOfficer->pivot->to_date))}}
                                                            Days)
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
										<td>{{$leave->from_date->format('d M Y')}} - {{$leave->to_date->format('d M
											Y')}}
										</td>
									</tr>
									@empty
									<tr>
										<td colspan="5" rowspan="1" headers="">Nill</td>
									</tr>
									@endforelse
									</tbody>
								</table>
							</th>
						</tr>
						<tr>
							<th colspan="2">
								<p class=" fw-bold "> 7. Appreciation/Honors during the period of appraisal from the
									department
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
											<td colspan="3" rowspan="1" headers="">Nill</td>
										</tr>
										@endforelse
									</tbody>
								</table>
							</th>
						</tr>
						<tr>
							<th colspan="2">
								<p class=" fw-bold "> 8. Details of Performance Appraisals of Subordinates not written
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
                                @mkbdate($acr->property_filing_return_at,'d M Y')
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection


@section('footscripts')
@endsection
