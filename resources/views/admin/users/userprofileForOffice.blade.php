@extends('layouts.type50.admin')
@section('content')

    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{ $userInfo->name }}</h3>
                    <p class="text-muted text-center">{{ $userInfo->designation }}</p
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            Name in Hindi:{{$userInfo->name_h}}
                        </li>
                        <li class="list-group-item">
                            Email:{{$userInfo->email}}
                        </li>
                        <li class="list-group-item">
                            Contact No:{{$userInfo->contactno}}
                        </li>
                        <li class="list-group-item">
                            ID:{{$userInfo->id}}
                        </li>
                        <li class="list-group-item">
                            Telegram:{{$userInfo->chat_id}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>


            @php
                $class="col-md-4"
            @endphp
            <div class="col-md-4 border-dark bg-warning">
                <div class="box box-warning ">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-warning"></i> Already Assigned Offices</h3>
                    </div>
                    <div class="box-body">
                        <div class="row-fluid">
                            <div class="col-md-12">
                                {!! Form::open(['url'=>'/detachOffice','name'=>'detachOfficeFrm','method'=>'POST']) !!}
                                <div class="form-group">
                                    <ul class="list-group list-group-inline">
                                        @if(count($jobs))
                                            @foreach($jobs as $job)
                                                <li class="list-group-item text-left">
                                                    {!! Form::checkbox('job[]', $job->id, '', ['class'=>'minimal']) !!}
                                                    {{$job->name}} : {{$job->office_name}}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="form-group">
                                    {!! Form::hidden('id', $userInfo->id, []) !!}
                                    {{ Form::submit('Detach Office',['class'=>'btn btn-primary pull-right']) }}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($errors))
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif



            <div class="{{ $class }} border-dark">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-user"></i> Assign offices</h3>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['url'=>'/assignOfficeAndJob','name'=>'assignOfficeFrm','method'=>'POST']) !!}
                        <div class="form-group">
                            {{ Form::label('job_id','Select job Type ') }}
                            {{ Form::select('job_id',($joblist),old('job_id'),['placeholder'=>'Select Job Type','id'=>'job_id','class'=>'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('officeType','Select Office Type ') }}
                            {{ Form::select('officeType',($Officetypes),old('officeType'),['placeholder'=>'Select Office Type','id'=>'officeTypeId','class'=>'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('','',['id'=>'lbl']) }}
                            <div id="fltvaldiv"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::hidden('id', $userInfo->id, []) !!}
                            {{ Form::submit('Set Office',['class'=>'btn btn-primary pull-right']) }}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-md-12 ">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-user"></i>API Token</h3>
                        <a class="btn btn-xs btn-info" href="{{route('admin.token.create',['user'=>$userInfo->id])}}">Add Api Token</a>
                        <a class="btn btn-xs btn-info" href="{{route('admin.token.destroy',['user'=>$userInfo->id])}}">Delete Api Tokens</a>
                    </div>
                    <div class="box-body">
                        <ul>
                        @foreach($userInfo->tokens as $token)
                            <li>Name: {{$token->name}} ,
                                Abilities: @foreach($token->abilities as $ability) {{$ability}}, @endforeach
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
    </div>





@endsection


@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/adminlte/iCheck/all.css') }}">
    <script src="{{ asset('css/adminlte/iCheck/icheck.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#officeTypeId').change(function (e) {
                console.log()
                e.preventDefault();
                $filterParam = $(this).val(); // or $('#officeTypeId').val();
                $.ajax
                ({
                    url: '{{ url('fetchAOffices') }}/' + $filterParam,
                    type: 'GET',
                    success: function (data) {
                        $('#lbl').html(data['lbltxt']);
                        $('#fltvaldiv').html(data['ele']);
                    }
                });
            });
        });
    </script>
    <script>
        $('#flash-overlay-modal').modal();
        //Flat red color scheme for iCheck
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })

    </script>
    <style type="text/css">
        .list-group-inline .list-group-item {
            border: 0px;
        }

        .list-group-inline > li {
            display: inline-block;

        }

    </style>

@endsection
