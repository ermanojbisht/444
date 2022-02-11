@extends('layouts.type200.pdf')

@section('content')

<div class="card">
	<div class="card-body">
		<p class="fw-semibold fs-5 text-center text-info my-0">PUBLIC WORKS DEPARTMENT, UTTARAKHAND</p>
		<p class="fw-semibold fs-5 text-center text-info my-0">APERFORMANCE APPRAISAL REPORT FOR <span class="text-danger">(Type Will Be added Here)</span></p>
		<p>
			 <span class="text-info">  </span>
		</p>
		<p>
			 <span class="text-info">  </span>
		</p>
		<table class="table table-bordered table-sm">
			<tr>
				<td class="fw-bold"> Name of the officer Reported Upon :- </td>
				<td class="fw-semibold fs-5"> {{$employee->name }} </td>
			</tr>
			<tr>
				<td class="fw-bold"> Designation :- </td>
				<td class="fw-semibold fs-5"><span class="text-danger"> ID {{$employee->designation_id }} ( to be added)</span></td>
			</tr>
			<tr>
				<td class="fw-bold"> Period Of Appraisal :-</td>
				<td class="fw-semibold fs-5"> 
					{{$acr->from_date->format('d M Y') }} - {{$acr->to_date->format('d M Y') }} 
				</td>
			</tr>
		</table>
		<p class="fw-semibold text-center text-info my-0">Part - 1 (Basic Information)</p>
		<table class="table table-sm">
			<tr>
				<td>1. Place Of Posting During the Appraisal Period :</td>
				<td>
					@if($acr->office->id < 2000)
						{{ $acr->office->name }}
					@elseif($acr->office->id > 2000 && $acr->office->id < 3000)
						<p>1.1 Circle : {{ $acr->office->name }}</span></p>
						<p>1.2 Zone :- </p>
					@elseif($acr->office->id > 3000)
						 <p>1.1 Division : {{ $acr->office->name }}</p>
						 <p>1.2 Circle : </p>
						 <p>1.3 Zone :- </p>
					@endif
				</td>
			</tr>
			<tr>
				<td>2. Date of Birth : </td>
				<td> {{$employee->birth_date->format('d M Y')}} </td>
			</tr>
			<tr>
				<td>3. Education Qualification : </td>
				<td> 
				</td>
			</tr>
			<tr>
				<td><p class="ps-3 m-0">3.1 At the time of Joining in the Department : </p></td>
				<td> 
					@foreach ($employee->education as $education )
						@if($education->qualifiaction_type_id == 1)
							<p> {{$education->qualifiaction }} </p>
						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td><p class="ps-3 m-0">3.2 Qualification acquired during service in the Department : </p></td>
				<td> 
					@foreach ($employee->education as $education )
						@if($education->qualifiaction_type_id == 2)
							<p> {{$education->qualifiaction }} </p>
						@endif
					@endforeach
				</td>
			</tr>
			<tr>
				<td>4. Membership of any Professional Organization :</td>
				<td> 
					{{ $acr->professional_org_membership }}
				</td>
			</tr>
		</table>
		<p> 5. Reporting, Reviewing and Accepting Authorities </p>
		<table class="table table-sm table-bordered">
			<thead class="align-middle text-center">
				<tr class="small">
					<th>Officer</th>
					<th>Name</th>
					<th>Designation</th>
					<th>Period</th>
					<th>Is Due</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($appraisalOfficers as $appraisalOfficer)
	            <tr class="small">
	            	<td>
	            		{{config('acr.basic.appraisalOfficerType')[$appraisalOfficer->pivot->appraisal_officer_type]??'----'}} Authority
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
	                <td colspan="5" rowspan="1" headers="">Data Not Filled</td>
	            </tr>
	            @endforelse
			</tbody>
		</table>
		<p> 6. Leave (other then Casual Leave) or period of absence </p>
		<table class="table table-sm table-bordered">
			<thead>
				<tr class="small text-center">
					<th> Type </th>
					<th> Period </th>
				</tr>
			</thead>
			<tbody>
				@forelse ($leaves as $leave)
					<tr class="small text-center">
						<td>
							{{config('acr.basic.acrLeaveType')[$leave->type_id]}}
						</td>
						<td> 
							{{$leave->from_date->format('d M Y')}} - {{$leave->to_date->format('d M Y')}}
							({{Carbon\Carbon::parse($leave->from_date)->diffInDays(Carbon\Carbon::parse($leave->to_date))}} Days)
						</td>
					</tr>
				@empty
					<tr class="small text-center">
						<td > --- </td>
						<td > --- </td>
					</tr>
				@endforelse
			</tbody>
		</table>
		<p>7. Appreciation/Honors during the period of appraisal from the department</p>
		<table class="table table-sm table-bordered">
			<thead>
				<tr class="small text-center">
					<th> Sl. No. </th>
					<th> Type of Appreciation/Honors </th>
					<th> Brief Details </th>
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
					<tr class="text-center">
						<td colspan="3" rowspan="1" headers="">Nill</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		<p>8. Details of Performance Appraisals of Subordinates not written</p>
		<table class="table table-sm table-bordered">
			<thead class="small text-center">
				<tr>
					<th>S No.</th>
					<th>Employee Name</th>
					<th>Employee Id</th>
					<th>From Date</th>
					<th>To Date</th>
					<th>Created on</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@php $n = 0 @endphp
				@foreach($inbox as $acr)
					@php $n = $n + 1; @endphp
				<tr>
					<td>8.{{1+$loop->index }}</td>
					<td>{{$acr->employee->name}}</td>
					<td>{{$acr->employee_id}} </td>
					<td>{{$acr->from_date}}</td>
					<td>{{$acr->to_date }}</td>
					<td>{{$acr->created_at->format('d M Y')}} </td>
					<td>Status to be added</td>
				</tr>
				@endforeach

				@foreach($reviewed as $acr)
					@php $n = $n + 1; @endphp
				<tr>
					<td>8.{{1+$loop->index }}</td>
					<td>{{$acr->employee->name}}</td>
					<td>{{$acr->employee_id}} </td>
					<td>{{$acr->from_date}}</td>
					<td>{{$acr->to_date }}</td>
					<td>{{$acr->created_at->format('d M Y')}} </td>
					<td>Status to be added</td>
				</tr>
				@endforeach

				@foreach($accepted as $acr)
					@php $n = $n + 1; @endphp
				<tr>
					<td>8.{{1+$loop->index }}</td>
					<td>{{$acr->employee->name}}</td>
					<td>{{$acr->employee_id}} </td>
					<td>{{$acr->from_date}}</td>
					<td>{{$acr->to_date }}</td>
					<td>{{$acr->created_at->format('d M Y')}} </td>
					<td>Status to be added</td>
				</tr>
				@endforeach
				@if($n == 0 )
					<tr class="text-center">
						<td> -- </td>
						<td> -- </td>
						<td> -- </td>
						<td> -- </td>
						<td> -- </td>
						<td> -- </td>
						<td><span class="text-danger">Status to be added</span></td>
					</tr>
				@endif
			</tbody>
		</table>
		<p> 
			9. Date of Filing Property Return for the Calender Year :  @mkbdate($acr->property_filing_return_at,'d M Y')
		</p>
	</div>
</div>
@endsection
