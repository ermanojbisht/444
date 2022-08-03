@extends('layouts.type200.main')

@section('headscripts')
<style>
    .bg-success {
        background-color: #dff0d8 !important;
    }

    .bg-warning {
        background-color: #fcf8e3 !important;
    }
</style>
@endsection

@section('pagetitle')
Employee Sugam Durgam Detail
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Office Employees','active'=>true, 'route' => 'employee.office.index'],
['label'=> 'View Employee','active'=>true],
]])
@endsection

@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hrms',['active'=>'Employees'])
@endsection
@section('content')

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class=" row">
                    <div class="col-xs-6 col-md-6"> Name </div>
                    <div class="col-xs-6 col-md-6"> {{$employee->name}} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Employee code </div>
                    <div class="col-xs-6 col-md-6"> {{$employee->id}} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> current office </div>
                    <div class="col-xs-6 col-md-6">
                        {{ $employee->last_office_name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Contact no </div>
                    <div class="col-xs-6 col-md-6"> {{ $employee->phone_no }} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Date Of Birth </div>
                    <div class="col-xs-6 col-md-6">{{ ($employee->birth_date)?$employee->birth_date->format('d M Y'):'unknown' }} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Joining Date </div>
                    <div class="col-xs-6 col-md-6"> {{ ($employee->joining_date)?$employee->joining_date->format('d M Y'):'unknown' }} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Home state </div>
                    <div class="col-xs-6 col-md-6">
                        @if($homeAddress->state)
                        {{ $homeAddress->state->name }}@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Home District </div>
                    <div class="col-xs-6 col-md-6">
                        @if($homeAddress->district)
                        {{ $homeAddress->district->name }}@endif </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Home Tehsil </div>
                    <div class="col-xs-6 col-md-6">
                        @if($homeAddress->tehsil)
                        {{ $homeAddress->tehsil->name }}@endif </div>
                </div>
            </div>

            <div class="col-xs-6 col-md-6">
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Designation </div>
                    <div class="col-xs-6 col-md-6">
                        {{ $employee->designation->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> current office type </div>
                    <div class="col-xs-6 col-md-6"> {{ $employee->last_office_type?'Durgam':'Sugam' }} </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Days in current office </div>
                    <div class="col-xs-6 col-md-6"> {{ $employee->getDaysInCurrentOffice() }} days </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Sugam Period </div>
                    <div class="col-xs-6 col-md-6 bg-success"> 12 Y,9 M,21 D </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-6"> Durgam Period </div>
                    <div class="col-xs-6 col-md-6 bg-warning"> 6 Y,2 M,20 D </div>
                </div>
            </div>

        </div>

        <br />



        <div class="row-fluid">
            <h3>Employee History</h3>
        </div>
        <br />

        <div class="row">
            <div class="form-group col-md-12">
                <table class="table border mb-0 dataTable no-footer ">
                    <tr>
                        <th>
                            Office
                        </th>
                        <th>
                            Designation
                        </th>
                        <th>
                            From Date
                        </th>
                        <th>
                            To Date
                        </th>
                        <th>
                            Days
                        </th>
                        <th>
                            Office Category
                        </th>
                    </tr>

                    @foreach($employeePostings as $posting )
                    <tr>
                        <td>
                            {{ $posting->postingOffice->name }}
                        </td>
                        <td>
                            @if($posting->designation_id)
                                {{ $posting->designation->name }}
                            @else
                                Other Department Designation
                            @endif
                        </td>
                        <td>
                            {{$posting->from_date->format('d M Y')}}
                        </td>
                        <td>
                            @if($posting->to_date)
                            {{ $posting->to_date->format('d M Y') }}
                            @else
                            Till Present
                            @endif
                        </td>
                        <td>
                            
                            @if($posting->s_d || $posting->d_d)
                                @if($posting->s_d)
                                    Sugam Days -> {{ $posting->s_d }}
                                @endif

                                @if ($posting->d_d)
                                    Durgam Days ->  {{ $posting->d_d }}
                                @endif
                            @else
                                @if($posting->to_date)
                                {{ 1 +
                                (int)(Carbon\Carbon::parse($posting->from_date)->diffInDays(Carbon\Carbon::parse($posting->to_date)))
                                }}
                                @else
                                {{ 1 + (int)Carbon\Carbon::parse('2022-05-31')->diffInDays(Carbon\Carbon::parse($posting->from_date)) }}
                                {{-- {{ 1 + (int)Carbon\Carbon::today()->diffInDays(Carbon\Carbon::parse($posting->from_date)) }} --}}
                                Till 31/05/22
                                @endif
                            @endif
                        </td>
                        <td>
                            {{ $posting->postingOffice->isdurgam?'Durgam':'Sugam' }}
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
