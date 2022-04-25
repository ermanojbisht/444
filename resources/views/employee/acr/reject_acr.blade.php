@extends('layouts.type200.main')

@section('styles')

@endsection
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection

@section('pagetitle')
Rejection By the Authority {{Auth::user()->shriName}}
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
['label'=> 'Inbox','route'=>
'acr.others.index', 'active'=>false],
['label'=> 'Accept ACR','active'=>true]
]])

@endsection

@section('content')
<div class="card">
	<div class="card-body">

		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold"> Name of the Employee :- </p>
				</div>
				<div class="col-md-6">
					<p class="fw-semibold text-info"> {{$acr->employee->shriName }} </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<p class="fw-bold"> Date of Birth :-</p>
				</div>
				<div class="col-md-6">
					<p class="fw-semibold text-info"> {{$acr->employee->birth_date->format('d M Y')}} </p>
				</div>
			</div>
		</div>

		<form class="form-horizontal" method="POST" action="{{route('acr.others.storeReject')}}"
		onsubmit="return confirm('Above Written Details are correct to my knowledge. ( उपरोक्त दिए गए प्रपत्र एवं डाटा से में सहमत हूँ  ) ??? ');">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<p class="fw-semibold"> Reason for Rejection of the ACR ? </p>
				</div>
				<div class="col-md-3">
					{!! Form::select('rejection_type_id', config('acr.basic.acrRejectionReason'), '1',
					['id'=>'rejection_type_id','class'=>'form-select'], ) !!}
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-12">
					<p id="lbl_reason" class="fw-semibold">Remark for difference of opinion details and resaons for the
						same may be given </p>
				</div>
				<div class="col-md-12">
					<textarea type="text" id="remark" name="remark" rows="4" required class="form-control" ></textarea>
				</div>
			</div>
			<br />  
			<div class="row">
				<div class="col-md-3">					
					<input type="hidden" name="employee_id" value="{{Auth::user()->employee_id}}" />
					<input type="hidden" name="dutyType" value="{{$dutyType}}" />
					<input type="hidden" name="acr_id" value="{{$acr->id}}" />
					<input type="submit" class="btn text-white btn-danger" value="Reject ACR" />
				</div>
			</div>
			<br/><br/><br/>
			<hr/>
			<div class="col-md-3">
					<p class="fw-bold"> Rejected By :-  
					<span class="fw-semibold text-info"> {{Auth::user()->shriName}} </span> </p>
				</div>
			</div>
		</form>
	</div>


</div>


@endsection


@section('footscripts')

@endsection
