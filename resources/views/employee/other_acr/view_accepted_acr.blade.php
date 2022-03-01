@extends('layouts.type200.pdf')
@section('content')
<div class="card">
	<div class="card-body">

		<p class="fw-bold h4 text-center mb-5"> Part - IV ( Assessment by the Accepting Authority) </p>

		@if ($acr->accept_remark)

		<div class="d-flex justify-content-start">
			<p class="fw-semibold "> 1. Do you agree with the remarks of the reporting/reviewing authority ?
			</p>
			<p class="fw-semibold text-info px-5"> No </p>
		</div>
		<div class="d-flex justify-content-start">
			<p class="fw-semibold"> 2. In Case of difference of opinion details and resaons for the
				same may be given : </p>
		</div>
		<div class="justify-content-start">
			<p class="border fw-semibold  mb-5 py-3 px-5">{{$acr->accept_remark }} </p>
		</div>

		@else

		<div class="d-flex justify-content-start">
			<p class="fw-semibold"> 1. Do you agree with the remarks of the reporting/reviewing authority ?
			</p>
			<p class="fw-semibold text-info px-5"> Yes </p>
		</div>
		<div class="d-flex justify-content-start">
			<p class="fw-semibold"> 2. In Case of difference of opinion details and resaons for the
				same may be given : </p>
		</div>
		<div class="justify-content-start">
			<p class="border fw-semibold  mb-5 py-3 px-5">  </p>
		</div>

		@endif

		<div class="row">
			<div class="col-md-6">
				<div class="d-flex justify-content-start">
					<p class="fw-semibold "> 3. Overall Grade & Marks (On a score of 1 - 100)
					</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<p class="fw-semibold "> Marks : 
							@if($acr->old_accept_no)
								{{$acr->old_accept_no }} 
							@else
								{{$acr->accept_no }} 
							@endif
						</p>
					</div>
					@if(!$acr->old_accept_no)
						<div class="col-md-6">
							<p class="fw-semibold"> Grade : {{$acr->grade}} </p>
						</div>
					@endif
				</div>
			</div>
		</div>

		<hr class="m-1" style="opacity: 0.1;">
		<div class="row">
			<div class="col-md-3">
				<p class="fw-semibold"> By
					<span class="text-info"> {!! $acr->acceptUser()->shriName !!} </span>
				</p>
				<p class="fw-semibold"> Date
					<span class="text-info"> {!! $acr->accept_on->format('d&#160;M&#160;Y') !!} </span>
				</p>
			</div>
		</div>
	</div>
	@if($acr->old_accept_no)
			<p class="text-info fw-semibold">After successful representation marks and grade has been changed as below:</p>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<p class="fw-semibold "> Marks : {{$acr->accept_no }} </p>
					</div>
					<div class="col-md-6">
						<p class="fw-semibold"> Grade : {{$acr->grade}} </p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p class="fw-semibold "> Order Details : {{$acr->final_accept_remark }} </p>
					</div>
				</div>
			</div>
	@endif
</div>

@endsection
