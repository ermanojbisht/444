@extends('layouts.type200.main')
@section('sidebarmenu')
	@include('layouts.type200._commonpartials._sidebarmenu_acr',['active'=>'arc'])
@endsection
@section('pagetitle')
	Part -II Self-Appraisal
@endsection
@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', [ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'My Acrs', 'route'=>'acr.myacrs' ,'active'=>false],
	['label'=> 'Assessment of Performance','active'=>true]
	]])
@endsection

@section('content')
	{{-- @include('employee.acr.form._formHeader',['acr'=>$acr]) --}}
	<div class="card">
		<div class="card-body">
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeSinglePageAcr')}}">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<div class="form-group">
					<label for="good_work" class="fw-bold h5">
					  	स्वयं द्वारा किए गए कार्यों के संबंध मे विवरण व स्वयं का विश्लेषण (अधिकतम 300 शब्दों मे)
					</label>
					<textarea class="form-control rounded-0" id="good_work"  name="good_work" rows="10"
					  	@if(!empty($acr->good_work))
							style="background-color:#F0FFF0;"
						@endif
					>{{$acr->good_work??''}}</textarea>
				</div>
				<div class="form-group mt-2 text-end">
			        <button type="submit" class="btn btn-primary">Save
			    </div>
			</form>
		</div>
	</div>
@endsection