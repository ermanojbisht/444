@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Part 1 ( Basic Information ) <small> Leaves </small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Leaves','active'=>true]
]])
@endsection

@section('content')

<div class="card">

	<div class="card-body">

		@if(!$acr->isSubmitted() && false)
		<div class="row">
			<div class="col-md-3">
				<input type="button" id="add_leave" class="btn btn-primary " value="Add Leaves" />
			</div>
		</div>
		@endif
		<table class="table datatable table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Leave Type </th>
					<th>From Date</th>
					<th>To Date</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($leaves as $leave)
				<tr>
					<td>{{$loop->iteration }}</td>
					<td> {{config('acr.basic.acrLeaveType')[$leave->type_id]}}
						({{$leave->from_date->
						diffInDays($leave->to_date) +1 }} Days)</td>
					<td>{{$leave->from_date->format('d M Y')}}</td>
					<td>{{$leave->to_date->format('d M Y')}}
					</td>
					@if(!$acr->isSubmitted() && false)
					<td>
						<form
							action="{{ route('acr.deleteAcrLeaves', [ 'acr_id'=> $acr->id, 'leave_id'=>$leave->id]) }}"
							method="POST">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-danger "> Delete </button>
						</form>
					</td>
					@endif
				</tr>
				@empty
				<tr>
					<td colspan="5" rowspan="1" headers="">No Data Found</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
<div>
	<!-- boostrap model -->

	<div class="modal fade lg" id="show-model" aria-hidden="true" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="OfficialType"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="POST" action="{{route('acr.storeLeaves')}}">
						@csrf
						<p class="h4"> Leave (Other that casual leave) or Period of absence :- </p>

						<br />

						<div class="row">
							<div class="col-md-4">
								{!! Form::label('leave_absence', 'Leave or Absence ', []) !!}
							</div>
							<div class="col-md-8">
								{{ Form::select('type_id',(config('acr.basic.acrLeaveType')),old('type_id'),
								['id'=>'type_id','class'=>'form-select', 'required']) }}
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-md-4">
								{!! Form::label('from_date', 'From Date', []) !!}
							</div>
							<div class="col-md-8">
								<input type="date" name="from_date" class="form-control" />
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-md-4">
								{!! Form::label('to_date', 'To Date', []) !!}
							</div>
							<div class="col-md-8">
								<input type="date" name="to_date" class="form-control" />
							</div>
						</div>


						<div class="row">
							<div class="col-md-3">
								<input type="hidden" name="employee_id" value="{{$acr->employee_id}}" />
                                <input type="hidden" name="acr_id" value="{{$acr->id}}" />
								<input type="submit" class="btn btn-primary " value="Save" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<p class="h4"> ACR Duration {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M
						Y') }} </p>
				</div>
			</div>
		</div>
	</div>
	<!-- end bootstrap model -->
</div>

@endsection


@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () {
		$('#add_leave').click(function () {
			$('#show-model').modal('show');
		});
		findDateDiff();
	});
 
	function findDateDiff()
	{
		var from_date = new Date($("#from_date").val());
		var to_date = new Date($("#to_date").val());
		if(from_date != "" && to_date != "")
		{
			const diffTime = Math.abs(to_date - from_date);
			const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
			 

			$("#days_in_number").html("Your Period of Appraisal  is for " + diffDays + " Days");
		}
	}
</script>
@endsection
