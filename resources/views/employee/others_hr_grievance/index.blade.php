@extends('layouts.type200.main')
@section('styles')
@include('cssbundle.datatablefor5',['button'=>true])
@endsection


@section('sidebarmenu')
@include('layouts.type200._commonpartials._sidebarmenu',['active'=>'Grivance'])
@endsection

@section('pagetitle')
{{ $employee_name}}'s Grivances
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb',
['datas'=> [
['label'=> 'Home','active'=>false, 'route'=> 'employee.dashboard'],
['label'=> 'Grivance','active'=>false],
['label'=> 'List','active'=>true],
]])
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

                @if($canCreateDefaultAnswer)
                <th> Create Default Answer</th>
                @endif
                @if($canCreateFinalAnswer)
                <th> Create Final Answer</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($grivances as $grivance)
            <tr>
                <td>{{1+$loop->index}}</td>
                <td>{{$grivance->id}}</td>
                <td>
                    <a href="{{route('office.View.hrGrivance', ['hr_grivance' => $grivance->id])}}">
                        <i class="cib-twitter"></i> {{$grivance->description}}
                    </a>
                </td>
                <td> {{$grivance->created_at->format('d M Y')}} </td>
                <td>
                    {{$grivance->currentStatus()}}
                </td>
                @if($canCreateDefaultAnswer)
                <td>
                    <a href="{{ route("office.resolve.hr_grivance.addDraftAnswer",['hr_grivance'=>$grivance->id]) }}" >
                        @if($grivance->draft_answer)
                        <i class="cib-twitter"></i> Update Draft
                        @else
                        <i class="cib-twitter"></i> Draft Grivances Answer
                        @endif
                    </a>
                </td>
                @endif
                @if($canCreateFinalAnswer)
                <td>
                    <a href="{{ route("office.resolve.hr_grivance",['hr_grivance'=>$grivance->id]) }}" >
                          <i class="cib-twitter"></i>  Resolve Grievance
                      </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{--
</div> --}}
</div>


@include('layouts._commonpartials._logoutform_foremployee')



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