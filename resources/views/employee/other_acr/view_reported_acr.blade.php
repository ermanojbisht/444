@extends('layouts.type200.pdf')

@section('content')
<div class="card">
	<div class="card-body">
		<p class="fw-semibold h5 mb-4"> Integrity Certificate : </p>

		@if (!$acr->report_remark)
		<i>
			<p class="fw-semibold"> The general reputation of
				<span class="text-info"> {{$acr->employee->shriName }} </span> for honesty
				is good and I certify his / her integrity.
			</p>
		</i>

		@else

		<p class="fw-semibold"> The general reputation of
			<span class="text-info"> {{$acr->employee->shriName }} </span>
			for honesty is not good and I withhold his / her integrity on account of the following reasons.
		</p>

		<p class="border fw-semibold mb-5 py-3 px-5">
			{{$acr->report_remark }}
		</p>


		@endif

		<hr class="m-1" style="opacity: 0.1;">
		<div class="row">
			<div class="col-md-3">
				<p class="fw-semibold"> By
					<span class="text-info">
					@if($acr->integrityUser())
					 {!! $acr->integrityUser()->shriName !!} 
					@else 
					::
					@endif
					</span>
				</p>

				{{-- <p class="fw-semibold"> Date
					<span class="text-info"> {!! $acr->report_on->format('d&#160;M&#160;Y') !!} </span>
				</p> --}}
			</div>
		</div>


	</div>
</div>


@endsection
