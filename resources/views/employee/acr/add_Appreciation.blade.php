@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@include('layouts._commonpartials.css._select2')
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Part 1 ( Basic Information ) <small> Appreciation / Honors </small>
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Appreciation / Honors','active'=>true]
]])
@endsection

@section('content')

<div class="card">

	<div class="card-body">

		@if(!$acr->isSubmitted())
		<div class="row">
			<div class="col-md-3">
				<input type="button" id="add_leave" class="btn btn-primary " value="Add Appreciation" />
			</div>
		</div>
		@endif
		<table class="table datatable table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Appreciation Type</th>
					<th>Brief Details</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($appreciations as $appreciation)   
				<tr>
					<td>{{1+$loop->index }}</td>
					<td>{{$appreciation->appreciation_type}}</td>  
					<td>{{$appreciation->detail}}</td>
					@if(!$acr->isSubmitted()) 
					<td>
						<form
							action="{{ route('acr.deleteAcrAppreciation', [ 'acr_id'=> $acr->id, 'appreciation_id'=>$appreciation->id]) }}"
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
					<h4 class="modal-title" id="OfficialType">
						Appreciation / Honors during the period of appraisal from the department :-
					</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="POST" action="{{route('acr.addAcrAppreciation')}}">
						@csrf
 
						<div class="row">
							<div class="col-md-4">
								{!! Form::label('appreciation_type', 'Type of Appreciation / Honors', []) !!}
							</div>
							<div class="col-md-8">
								<input type="text" name="appreciation_type" class="form-control" value="{{old('appreciation')}}" />
							</div>
						</div> 
						<br />
						<div class="row">
							<div class="col-md-4">
								{!! Form::label('detail', 'Brief Details', []) !!}
							</div>
							<div class="col-md-8">
								<textarea name="detail" class="form-control" > {{old('detail')}} </textarea>
							</div>
						</div>


						<div class="row">
							<div class="col-md-3">
								<input type="hidden" name="acr_id" value="{{$acr->id}}" />
								<input type="submit" class="btn btn-primary " value="Save" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<p class="h6"> ACR for Duration {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M Y') }} </p>
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