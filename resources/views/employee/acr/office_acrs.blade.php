@extends('layouts.type200.main')

@section('pagetitle')
    ACR List
@endsection

@section('styles')
    @include('layouts._commonpartials.css._select2')
    @include('layouts._commonpartials.css._datatable')

    <style type="text/css">
        .buttons-columnVisibility{
            display: block;
            width: 100%;
        }

    </style>
@endsection

@section('breadcrumbNevigationButton')

@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
[ 'datas'=> [
    ['label'=> 'Home','route'=> 'employee.home', 'icon'=>'home', 'active'=>false],
    ['label'=> 'ACR List','active'=>true]
    ]
])
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{route('office.acrs.view')}}">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-3">
                        <p class="fw-bold mb-0"> Office : </p>
                        <div class="form-group"> 
                            <select id='office_id' name='office_id' required class="form-select select2">
                                <option value="0" {{( $officeId=='0' ? 'selected' : '' )}} > Select Office </option>
                                <option value="2" {{( $officeId=='2' ? 'selected' : '' )}}> All</option>
                                @foreach ($offices as $office)
                                <option value="{{$office->id}}" {{( $officeId==$office->id ?
                                    'selected' : '' )}} > {{$office->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="fw-bold mb-0"> Start Date :
                            <input type="date" name="start" format="dd/mm/yyyy" class="form-control"
                                value="{{ $startDate }}">
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p class="fw-bold mb-0"> End Date :
                            <input type="date" name="end" format="dd/mm/yyyy" class="form-control" value="{{ $endDate}}">
                        </p>
                    </div>
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
                        <th>Employee Name</th>
                        <th>Employee Id</th>
                        <th>Designation</th>
                        <th>Current Office</th>
                        <th>ACR Period Office</th>
                        <th>Year</th>
                        <th>Period</th>
                        <th>Submitted on</th>
                        <th>Accepted On</th>
                        <th>Download</th>
                        @can('acr-special')<th>No</th>@endcan
                    </tr>
                </thead>
                <tbody style="border:1px solid #C8CBD2;">
                    @if($acrs)
                    @foreach($acrs as $acr)
                    <tr class="{!! $acr->status_bg_color() !!} text-center" style="--cui-bg-opacity: .25;">
                        <td>{{1+$loop->index }}</td> 
                        <td class="text-start">
                            <a class="text-decoration-none" href="{{route('employee.acr.view',['employee'=>$acr->employee_id])}}">
                                {{$acr->employee->name }}
                            </a>
                        </td>

                        <td> {{$acr->employee->id }}</td>
                        <td> {{$acr->employee->designation->name }}</td>
                        <td> {{$acr->employee->last_office_name }}</td>
                        <td> {{$acr->office->name }}</td>
                        <td> {{$acr->financialYear}}</td>
                        <td data-sort={{$acr->from_date->format('Ymd')}}>{{ $acr->from_date->format('d M Y') }} - {{ $acr->to_date->format('d M Y') }}</td>
                        <td data-sort={{$acr->submitted_at?$acr->submitted_at->format('Ymd'):''}}>{{ ($acr->submitted_at) ? $acr->submitted_at->format('d M Y') : 'New Created ' }}
                        </td>

                        <td data-sort={{$acr->accept_on?$acr->accept_on->format('Ymd'):''}}>
                            @if($acr->accept_on)
                                {{$acr->accept_on->format('d M Y')}}
                            @elseif (!$acr->is_active)
                                Rejected
                            @else
                                Under Process
                            @endif
                        </td>
                        <td>
                            @if($acr->accept_on)
                            <a href="{{route('acr.view',['acr'=>$acr])}}">
                                <svg class="icon icon-xl">
                                    <use xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-cloud-download')}}">
                                    </use>
                                </svg>
                            </a>
                            @else
                                --
                            @endif
                        </td>
                        @can('acr-special')
                        <td>{{$acr->final_no}}</td>
                        @endcan
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
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                'colvis'
            ]
            /*"order": [[ 5, "desc" ]]*/
        });
    });

</script>


@endsection
