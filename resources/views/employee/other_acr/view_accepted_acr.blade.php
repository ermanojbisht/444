@section('content')
<div class="card">
	<div class="card-body">


		<div class="form-group">
			
			@if ($acr->accept_remark)

<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Do you agree with the remarks of the reporting/reviewing authority ? </p>
				</div>
				<div class="col-md-2">
					<p class="fw-bold "> No </p> 
				</div>
			</div>
			<br />
			<br />
			<div class="row">
				<div class="col-md-12">
					<p id="lbl_reason" class="fw-bold h5"> In Case of difference of opinion details and resaons for the
						same may be
						given </p>
				</div>
				<div class="col-md-12">
					<p class="fw-bold "> {{$acr->accept_remark }} </p> 
				</div>
			</div>
			<br />
			<br />

			@endif
			
			
			<div class="row">
				<div class="col-md-6">
					<p class="fw-bold h5"> Overall Grade & Marks (On a score of 1 - 100) </p>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-6">
							<p class="fw-bold h5"> Marks </p>
						</div>
						<div class="col-md-6">
							<p class="fw-bold "> {{$acr->accept_no }} </p>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-6">
							<p class="fw-bold h5"> Grade </p>
						</div>
						<div class="col-md-6">
							<label class="fw-bold h5" id="grades"> </label>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	@endsection

	
@section('footscripts')
<script type="text/javascript">
	$(document).ready(function () { 
		findGrades();
	});

	function findGrades()
	{
		let marks = {{$acr->accept_no }};
		if(marks < 0)
		{
			alert("Marks can't be less then Zero. ");
			$("#marks").val('');
		}			
		else if(marks > 100)
		{
			alert("Marks can't be greater then 100. ");
			$("#marks").val('');
		}
		else
		{
			switch (true)
			{
				case (marks > 80.0) :
				{
					$("#grades").html('Out Standing');
					break;
				} 
				case (marks > 60.0 &&  marks <= 80.0) :
				{
					$("#grades").html('Very Good');
					break;
				} 
				case (marks > 40.0 &&  marks <= 60.0) :
				{
					$("#grades").html('Good');
					break;
				} 
				case (marks > 20.0 &&  marks <= 40.0) :
				{
					$("#grades").html('Satisfactory');
					break;
				} 
				case (marks <= 20.0) :
				{
					$("#grades").html('Unsatisfactory');
					break;
				} 
				default : 
				{
					$("#grades").html('');
					break;
				}

			}
			
						
			}
		}	
</script>

@endsection