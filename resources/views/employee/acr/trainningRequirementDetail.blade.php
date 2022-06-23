@extends('layouts.type200.main')

@section('pagetitle')
	List of Employee for <strong> {{$tranings[$trainingId]->description}}  </strong>  Training
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
<div class="container-fluid ">
  <table class="table table-bordered bg-white">
    <thead>
      <tr class="text-center"> 
        <th>#</th> 
        <th>ID</th> 
        <th>Name</th> 
        <th>Designation </th> 
        <th>Office</th> 
        <th>Phone</th> 
      </tr>
    </thead>
    <tbody>
      @foreach($employees as $employee)
        <tr >
          <td>{{$loop->index+1}}</td>
          <td>{{$employee->employee->id}}</td>
          <td>{{$employee->employee->name}}</td>
          <td>{{$employee->employee->designation->short_code}}</td>
          <td>{{$employee->employee->last_office_name}}</td>
          <td class="text-center">{{$employee->employee->phone_no}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>



  

  
</div>
@endsection
@section('footscripts')

@endsection
