@extends('layouts.type200.main')

@section('pagetitle')
	Time Taken in Process
@endsection

@section('breadcrumb')
	@include('layouts._commonpartials._breadcrumb',
	[ 'datas'=> [
	['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false]
	]])
@endsection
@section('styles')

@endsection
@section('content')
  <div class="row">
    @foreach($data as $group_name=>$days)
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <p>{{$group_name}}</p>
              @php
               // echo(array_sum(array_keys($days))/count(array_keys($days)));
              @endphp
              {{-- {{array_keys($days)}} --}}
              {{-- <?php 
                  echo (array_keys($days));

            ?> --}}
            </div>
            <div class="card-body">
              <p class="d-flex justify-content-between">
                  <span>Days</span>
                  <span>No of ACR</span>
                </p>
              <?php ksort($days) ?>
              
              @foreach($days as $day=>$acrs)
                <p class="d-flex justify-content-between">
                  @if($day == 0)
                    <span>Same Day</span>
                  @else
                    <span>{{$day}}</span>
                  @endif
                  <span>{{count($acrs)}}</span>
                </p>
              @endforeach
            </div>
          </div>
        </div>
          

    @endforeach
  </div>
@endsection
@section('footscripts')

@endsection
