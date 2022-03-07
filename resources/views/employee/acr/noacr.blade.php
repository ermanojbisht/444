@extends('layouts.type200.main')

@section('pagetitle')
    Office:{{$office->name}}<br>
	List of Employee who have not submitted their ACR in year {{$year}}-{{$year+1}}

@endsection

@section('styles')
	@include('layouts._commonpartials.css._select2')
	@include('layouts._commonpartials.css._datatable')
@endsection

@section('breadcrumbNevigationButton')

@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
	['label'=> 'Employee List in office who have not submitted their ACR','active'=>true]
	]
])
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<form method="post" action="{{route('filter')}}">
                @csrf
				<div class="row d-flex justify-content-between">
					<div class="col-md-3">
						<p class="fw-bold mb-0"> Office : </p>
						<div class="form-group"> 
							<select id='office_id' name='office_id' required class="form-select select2">
								<option value="" {{( $office_id=='' ? 'selected' : '' )}} > Select Office </option>
								@foreach ($offices as $office)
								<option value="{{$office->id}}" {{( $office->id==$office_id ?
									'selected' : '' )}} > {{$office->name}} </option>
								@endforeach
							</select>
						</div>
					</div>
                    <div class="col-md-3">
                        <p class="fw-bold mb-0"> Year : </p>
                        <select id='year' name='year' required class="form-select">
                        @foreach (range(config('acr.basic.recordStartyear'),now()->year) as $item)
                        <option value="{{$item}}" {{( $item==$year ?
                            'selected' : '' )}} > {{$item}}-{{$item+1}} </option>
                        @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="url" value="office_id-year">
					<div class="col-md-3">
						<p class="mt-4 text-end">
							<input type="submit" class="btn btn-info"  value="Search"/>
						</p>
					</div>
				</div>
			</form>
		</div>
		<div class="card-body">
			<table id="acrTable" class="table mb-0 table-bordered" style="width:100%">
				<thead class="table-light fw-bold">
					<tr class="align-middle text-center">
						<th>#</th>
						<th>Name</th>
						<th>Id</th>
						<th>Designation</th>
						<th>last office</th>
					</tr>
				</thead>
				<tbody style="border:1px solid #C8CBD2;">
					@if($employeeList)
					@foreach($employeeList as $emp)
					<tr class="text-center" style="--cui-bg-opacity: .25;">
						<td>{{$loop->iteration }}</td>
						<td class="text-start">
							<a class="text-decoration-none" href="{{route('employee.acr.view',['employee'=>$emp->id])}}">
								{{$emp->name }}
							</a>
						</td>
						<td> {{$emp->id }}</td>
						<td> {{$emp->designation->name }}</td>
						<td> {{$emp->last_office_name }}</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
@endsection



@section('footscripts')
@include('layouts._commonpartials.js._select2')
@include('layouts._commonpartials.js._datatable')
<script type="text/javascript">
	$(document).ready(function () {
		$('.select2').select2({
		});
		$('#acrTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'pageLength','copy', 'csv',  'pdf', 'print','colvis',{
                extend: 'excelHtml5',
                exportOptions: {
                     columns: [ 0,1, ':visible' ]
                }
            },
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength:10,
		});
    });

</script>


@endsection
