@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection

{{--
@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'Grievance'])
@endsection --}}

@section('pagetitle')
Resolve Grievances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.home'],
['label'=> 'Others Grievance','active'=>true]
]])
@endsection



@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu_hr_gr',['active'=>'Grienvance'])
@endsection

@section('content')

<div class="card">
    <table class="table border mb-0">
        <thead class="table fw-bold">
            <tr class="align-middle ">
                <th>#</th>
                <th class="text-center">Grievance Id</th>
                <th class="text-center">Description</th>
                <th class="text-center">Created on</th>
                <th>Status</th>
                <th>Resolve Grievance</th>

            </tr>
        </thead>
        <tbody>
            @foreach($grievances as $grievance)
            <tr>
                <td>{{1+$loop->index}}</td>
                <td>{{$grievance->id}}</td>
                <td>
                    <a href="{{route('View.hrGrievance', ['hr_grievance' => $grievance->id])}}">
                        <i class="cib-twitter"></i> {{$grievance->description}}
                    </a>
                </td>
                <td> {{$grievance->created_at->format('d M Y')}} </td>
                <td>
                    {{$grievance->currentStatus()}}
                </td>
                <td>
                    <a href="{{ route('view_hr_grievance', ['hr_grievance' => $grievance->id] ) }}">
                        @if($grievance->draft_answer)
                        <i class="cib-twitter"></i> Update / Resolve Grievance
                        @else
                        <i class="cib-twitter"></i> Resolve Grievance
                        @endif
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{--
</div> --}}
</div>


@include('layouts._commonpartials._logoutform')



@endsection

@section('footscripts')
<script src="{{ asset('../plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function () {
            $("#success-alert").slideUp(500);
        });
    });

        document.addEventListener("DOMContentLoaded", function () {
            // Datatables Responsive
            $("#user_Request_Details").DataTable({
                responsive: true
            });
        });
</script>

@endsection