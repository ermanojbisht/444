@extends('layouts.type200.main')

@section('pagetitle')
	Training Selected by {{$employees}} Employees
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
@endsection
@section('styles')
<style type="text/css">
  .callout {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #eee;
    border-left-width: 5px;
    border-radius: 3px;
    h4 {
      margin-top: 0;
      margin-bottom: 5px;
    }
    p:last-child {
      margin-bottom: 0;
    }
    code {
      border-radius: 3px;
    }
    & + .bs-callout {
      margin-top: -5px;
    }
  }
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
</style>
@endsection
@section('content')
<div class="container-fluid ">
  <div class="row justify-content-center row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 mb-5">
    
    @foreach($training_nos as $key => $value)
      @php
        $percent = round($value*100 / $employees);
        
        if($percent >= 10){
          $color = "danger";
          $text_class = "fw-bold h3 text-danger";
        }else{
          $color = "success";
          $text_class = "fw-bold h5 text-success";
        }
        if($percent < 5){
          $color = "warning";
          $text_class = "fw-bold text-warning";
        }
      @endphp
      <a href="{{route('acr.analysis.trainningRequirementDetail',$key)}}" class="text-decoration-none"> 
         <div class="col">
            <div class="card callout callout-{{$color}} bg-white my-1 py-1">
              <div class="row">
                <p class="col-8 fw-bold" style="font-family: 'Roboto Condensed', sans-serif; color: #5499C7">
                    {{$tranings[$key]->description}}
                </p>
                <span class="col-4 text-end">
                  <p class="m-0 p-0 {{$text_class}}">{{$value}}</p>
                  <p class="m-0 p-0 fw-bold text-{{$color}} small">{{$percent}}%</p>
                </span>
              </div>
            </div>
        </div>
      </a>
    @endforeach
    
  </div>
</div>
@endsection
@section('footscripts')

@endsection
