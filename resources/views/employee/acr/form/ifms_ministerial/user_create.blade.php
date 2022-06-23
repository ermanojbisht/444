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
			<form class="form-horizontal" method="POST" action="{{route('acr.form.storeIfmsAcr')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="acr_id" value='{{$acr->id}}'>
				<input type="hidden" name="acr_master_parameter_id" value=0>
				<div class="row mt-2">
					<div class="col-md-4">
						<p class="fw-bold required"> Service Cader (सेवा संवर्ग) :-</p>
					</div>
					<div class="col-md-4">
						<input class="form-control" type="text" name="service_cadre" required value="{{$acr->service_cadre}}" />
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-4">
						<p class="fw-bold required"> Present Pay Scale (वर्तमान वेतनमान) :-</p>
					</div>
					<div class="col-md-4">
						<input class="form-control" type="text" name="scale" required value="{{$acr->scale}}"/>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-4">
						<p class="fw-bold required"> Date of Appointment to the present post (वर्तमान पद पर नियुक्ति की तिथि):-</p>
					</div>
					<div class="col-md-4">
						<input class="form-control" type="date" name="doj_current_post" required value="{{$acr->doj_current_post}}"/>
					</div>
				</div>
				<hr>
				
					<div class="row mt-2">
						<div class="col-md-4">
							<p class="fw-bold checkbox required"> Have you undergone the prescribed medical checkup ? (क्या आपने निर्धारित स्वास्थ्य परीक्षण करा लिया है ?)</p>

						</div>
						<div class="col-md-8">
								@if(Carbon\Carbon::parse($acr->employee->birth_date)->age > 50)
									<input type="checkbox" id="has_medical_checkUp" name="has_medical_checkUp" onclick="hasMedicalCheckup()" {{$acr->medical_certificate_date?'checked':''}}>
									<label for="has_medical_checkUp" >  Check if Yes  </label>
									<p class="text-danger">Only for Employees ablove 50 Year of Age (केवल 50 वर्ष से अधिक आयु के कार्मिकों हेतु)</p>
								@else
									<span class="text-muted">Not Applicable (लागू नहीं)</span>
								@endif
						</div>
					</div>
					<div class="row mt-2">
						<div  class="col-md-4 hasMedical">
							<p class="fw-bold required">Date of Medical checkup (स्वास्थ्य परीक्षण का दिनांक)</p>
						</div>
						<div class=" hasMedical col-md-4" style="display:none">
							<div class="">
								<input class="form-control " style="display: inline-block;width: 90%!important;"  type="date" id="medical_certificate_date" name="medical_certificate_date" 
								value="{{old('medical_certificate_date')?old('medical_certificate_date'):$acr->medical_certificate_date}}"/> 					  
							</div>
						</div>
					</div>
					<div class="row mt-2">
						<div  class="col-md-4 hasMedical">
							<p class="fw-bold required">Upload a copy (pdf only) of Medical Report (रिपोर्ट की प्रति अपलोड करें)</p>
						</div>
						<div  class="hasMedical col-md-4" style="display:none">
							<p class="fw-bold">
					 		  <input type="file" name="certificate_file" />				 		  
							</p>
						</div>
					</div>
				
				<hr>
				<p class="fw-semibold">आलोच्य अवधि मे आवंटित उत्तरदायित्व व प्राप्त उपलब्धि/ कार्यों का संक्षिप्त विवरण</p>
				<table class="table table-bordered border-primary">
						<thead class="table-info fw-bold border-primary">
							<tr class="text-center align-middle">
								<th>क्रमांक</th>
								<th>समयावधि</th>
								<th>आवंटित उत्तरदायित्व</th>
								<th>अवधि के दोरान प्राप्त उपलब्धि/ कार्य का विवरण <br><small>(अधिकतम 100 शब्द)</small></th>
								{{-- <th></th> --}}
							</tr>
						</thead>
						<tbody>
							@php $n = 0; @endphp
								@foreach($filled_data as $data)
									@php $n = $n+1; @endphp
									<tr style="background-color:#F0FFF0;">
										<td >
											{{$data->row_no}}
											<input type="hidden" name="data[{{$data->row_no}}][row_no]" value='{{$data->row_no}}'>
										</td>
										<td >
											<input class="form-control" type="text" name="data[{{$data->row_no}}][col_1]" value="{{$data->col_1}}" />
										</td>
										<td>
											<textarea class="form-control"  type="text" name="data[{{$data->row_no}}][col_2]">{{$data->col_2}}</textarea>
										</td>
										<td>
											<textarea class="form-control"  type="text" name="data[{{$data->row_no}}][col_3]">{{$data->col_3}}</textarea>
										</td>
									{{-- <td>
										<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Update</button>
									</td> --}}
									</tr>
								@endforeach
								@php $n = $n+1; @endphp
								<tr>
									<td>{{$n}}</td>
									<input type="hidden" name="data[{{$n}}][row_no]" value='{{$n}}'>
									<td>
										<input class="form-control" 
											type="text"
											name="data[{{$n}}][col_1]"
										/>
									</td>
									<td>
										<textarea class="form-control"  type="text" name="data[{{$n}}][col_2]"></textarea>
									</td>
									<td>
										<textarea class="form-control"  type="text" name="data[{{$n}}][col_3]"></textarea>
									</td>
									{{-- <td>
										<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Save</button>
									</td> --}}
								</tr>
							
						</tbody>
					</table>
					<div class="text-center">
						<button type="submit" id="{{$acr->id}}" class="btn btn-outline-primary">Save All</button>
						
					</div>

			</form>
		</div>
	</div>


<script type="text/javascript">


	$(document).ready(function () {
	    hasMedicalCheckup();
	});



	function hasMedicalCheckup()
	{
		var hasMedical = $("#has_medical_checkUp").is(":checked");
		if(hasMedical) 
		{
			$(".hasMedical").css("display", "inline-block");
			$(".hasMedical").find('input').prop('required', true);			
		}else
		{
			$(".hasMedical").css("display", "none");
			$(".hasMedical").find('input').prop('required', false);
			$("#medical_certificate_date").val('');
		}
	}

</script>

@endsection