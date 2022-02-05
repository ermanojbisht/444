@extends('layouts.type200.main')

@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')

My ACR Appraisal Officers for Duration {{ $acr->from_date->format('d M Y') }} to {{ $acr->to_date->format('d M Y') }}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
['label'=> 'Add Leave or Absence ','active'=>true]
]]) 
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" method="POST" action="{{route('acr.addAcrLeaves')}}">
			@csrf
			<p class="h4"> Leave (Other that casual leave) or Period of absence :- </p>
			<br />

			<div class="row">
				<div class="col-md-4">
					{!! Form::label('leave_absence', 'Leave or Absence ', []) !!}
					<select name="type_id" class="form-select" >
						<option value="1"> Leave</option>
						<option value="0"> Absence</option>
					</select>
				</div>
				<div class="col-md-4">
					{!! Form::label('from_date', 'From Date', []) !!}
					<input type="date" name="from_date" class="form-control" />
				</div>
				<div class="col-md-4">
					{!! Form::label('till_date', 'Till Date', []) !!}
					<input type="date" name="till_date" class="form-control" />
				</div>
				 
			</div>
			<br />
			<div class="row">
				<div class="col-md-3">
					<input type="hidden" name="acr_id" value="{{$acr->id}}" />
					<input type="submit" class="btn btn-primary " value="Save" />
				</div>
			</div>
		</form>
	</div>
</div>


@endsection


@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () {

        });
</script>

@endsection