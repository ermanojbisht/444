@extends('layouts.type200.main')

@section('pagetitle')
Confidential Report
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
	@endsection

@section('content')
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Employee Code</th>
			<th>Father's Name</th>
			<th>Date fo Birth</th>
			<th>Current Designation</th>
			<th>Current Office</th>
			<th>ACR Office</th>
			<th>ACR Type</th>
			<th>ACR Office</th>
			<th>ACR To</th>
			<th>ACR Submitted On</th>
			<th>ACR Accepted On</th>
			<th>Integrity</th>
			<th>ACR Final Marks</th>
		</tr>
	</thead>
	<tbody>
		
	@php $n=0; @endphp
	@foreach($employees as $employee)
				@php $n= $n+1; @endphp
			@forelse($employee->activeAcrs()->get() as $acr)
			    	<tr class="{{($employee->getIsRetiredAttribute())?'bg-warning':''}}">
							<td>{{$n.'.'.$loop->index+1}}</td>
							<td>{{$employee->getShriNameAttribute()}}</td>
							<td>{{$employee->id}}</td>
							<td>{{$employee->father_name}}</td>
							<td>{{$employee->birth_date->format('d M Y')}}</td>
							<td>{{$employee->designation->short_code}}</td>
							<td>{{$employee->office_idd}}</td>
							<td>{{$acr->getTypeNameAttribute()}} </td>
							<td>{{$acr->office->name}} </td>
							<td>{{$acr->from_date->format('d M Y')}} </td>
							<td>{{$acr->to_date->format('d M Y')}} </td>
							<td>{{$acr->submitted_at?$acr->submitted_at->format('d M Y'):'not submitted'}} </td>
							<td>{{$acr->accept_on?$acr->accept_on->format('d M Y'):'not accepted'}} </td>
							<td>{{$acr->accept_on?$acr->report_integrity:'--'}}</td>
							<td>{{$acr->accept_on?$acr->final_no:'--'}}</td> 
						</tr>
			@empty
					<tr class="{{($employee->getIsRetiredAttribute())?'bg-warning':''}}">
							<td>{{$n}}</td>
							<td>{{$employee->getShriNameAttribute()}}</td>
							<td>{{$employee->id}}</td>
							<td>{{$employee->father_name}}</td>
							<td>{{$employee->birth_date->format('d M Y')}}</td>
							<td>{{$employee->designation->short_code}}</td>
							<td>{{$employee->office_idd}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td> 
					</tr>
			@endforelse
	</tbody>
@endforeach

</table>

@endsection
@section('footscripts')
<script type="text/javascript">
// You could easily add more colors to this array.
var colors = ['#E7F4D7', '#F4F2D7','#F4DFD7','#D7F4ED','#D8D7F4','#F4D7E1','#D7F1F4'];
var boxes = document.querySelectorAll(".box");
for (i = 0; i < boxes.length; i++) {
  boxes[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
}


function resizeGridItem(item){
  grid = document.getElementsByClassName("grid")[0];
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height+rowGap)/(rowHeight+rowGap));
    item.style.gridRowEnd = "span "+rowSpan;
}

function resizeAllGridItems(){
  allItems = document.getElementsByClassName("item");
  for(x=0;x<allItems.length;x++){
    resizeGridItem(allItems[x]);
  }
}

function resizeInstance(instance){
	item = instance.elements[0];
  resizeGridItem(item);
}

window.onload = resizeAllGridItems();
window.addEventListener("resize", resizeAllGridItems);

allItems = document.getElementsByClassName("item");
for(x=0;x<allItems.length;x++){
  imagesLoaded( allItems[x], resizeInstance);
}
</script>
@endsection
