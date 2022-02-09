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
						<p class="fw-semibold "> Marks : {{$acr->accept_no }} </p>
					</div>
					<div class="col-md-6">
						<p class="fw-semibold"> Grade : {{$acr->grade}} </p>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>

@endsection
