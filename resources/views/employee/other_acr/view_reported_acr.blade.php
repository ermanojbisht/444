@section('content')
<div class="card">
	<div class="card-body">

		<div class="row">
			<div class="col-md-12  ">
				<p class="fw-bold h3"> 6. Integrity Certificate : </p>
			</div>
		</div>
		<br />
		<div class="row">
			@if ($acr->report_remark)
			<div class="col-md-12">
				<label for=" integrity_yes" class="fw-bold"> The general reputation of Sri/ Ms
					<u> {{$acr->employee->name }} </u> for honesty
					is good and I certify his / her integrity. </label>
			</div>
			@else
			<div class="col-md-12">
				<label for=" integrity_no" class="fw-bold"> The general reputation of Sri/ Ms
					<u> {{$acr->employee->name }} </u>
					for honesty is not good and I withhold his / her integrity on account of the following reasons.
				</label>
				<br /><br />
				<p id="lbl_reason" class="fw-bold h5"> In Case of difference of opinion, details may be given </p>
				<p>
					{{$acr->report_remark }}
				</p>
			</div>
			@endif
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">

			</div>
		</div>
	</div>
</div>

@endsection