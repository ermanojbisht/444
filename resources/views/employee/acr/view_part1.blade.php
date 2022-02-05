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
					<td> </td>
				</tr>
				<tr>
					<th colspan="2">
						5. Reporting, Reviewing and Accepting Authorities
						<table style="width:100%">
							<tr>
								<td>
									<table class="table ">
										<thead>
											<tr>
												<th>
													Officer
												</th>
												<th>
													Name
												</th>
												<th>
													Designation
												</th>
												<th>
													Period
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
												
												<td> {{ $acr->report_review_Accept_officers('report')->designation->name }} </td>
												@endif
												@if( config('acr.basic.appraisalOfficerType')
												[$appraisalOfficer->pivot->appraisal_officer_type] == 'Reviewing')
												<td>
													Reviewing Authority
												</td>
												<td>{{$appraisalOfficer->name}}</td>
												<td> {{ $acr->report_review_Accept_officers('review')->designation->name }} </td>
												@endif
												@if( config('acr.basic.appraisalOfficerType')
												[$appraisalOfficer->pivot->appraisal_officer_type] == 'Accepting')
												<td>
													Accepting Authority
												</td>
												<td>{{$appraisalOfficer->name}}</td>
												<td> {{ $acr->report_review_Accept_officers('accept')->designation->name }} </td>
												@endif
												<td>{{$appraisalOfficer->pivot->from_date}} -
													{{$appraisalOfficer->pivot->to_date}}
													 ({{Carbon\Carbon::parse($appraisalOfficer->pivot->from_date)->diffInDays
													(Carbon\Carbon::parse($appraisalOfficer->pivot->to_date))}}  Days)
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