@extends('layouts.type200.main')

@section('pagetitle')
	difficulties face by Employees
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
	@endsection

@section('content')
<style type="text/css">
	.grid {
	  display: grid;
	  grid-gap: 5px;
	  grid-template-columns: repeat(auto-fill, minmax(25%,1fr));
	  grid-auto-rows: 20px;
	  font-family: 'Open Sans Condensed', sans-serif;
	  font-size: 1.15em;
	  text-rendering: optimizeLegibility;
	  -webkit-font-smoothing: antialiased;
	}
	
/* Non-grid specific CSS */  
/*body {
  	margin: 10px;
	color: #374046;
	background-color: #374046;
	font-family: 'Open Sans Condensed', sans-serif;
	font-size: 1.15em;
	text-rendering: optimizeLegibility;
	-webkit-font-smoothing: antialiased;
}
*/

@media screen and (max-width:760px) {
  .grid {
  	grid-template-columns: repeat(auto-fill, minmax(50%,1fr));
  }
}

@media screen and (max-width:480px) {
  .grid {
  	grid-template-columns: repeat(auto-fill, minmax(100%,1fr));
  }
}

@media screen and (max-width:360px) {
  .grid {
  	grid-template-columns: repeat(auto-fill, minmax(100%,1fr));
  }
}

.desc{
  padding: 10px 10px 5px 10px;
}

.desc p{
  margin-bottom: 5px;
}

</style>

@foreach($acrs as $acr_id=>$records)
	<div class="card">	
		<div class="card-header d-flex justify-content-start bg-dark text-light">
			<span class="fw-semibold">{{$records->count()}}</span>&nbsp;&nbsp;<span>{{$acr_Types->find($acr_id)->description}}</span>
		</div>
		<div class="card-body row ">
			<div class="grid">
				@foreach($records as $emp_id=>$emp_acr_details)
					<div class="item blog">
					    <div class="content box">
					      <div class="desc">
							@foreach($emp_acr_details as $acr)
								@if($acr->difficultie)
									<p> &#9673;&nbsp;{{$acr->difficultie}}</p>
								@endif
							@endforeach
					      </div>
					    </div>
					  </div>
				@endforeach
			</div>
		</div>
	</div>
@endforeach

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
