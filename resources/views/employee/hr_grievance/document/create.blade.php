{{-- @extends('layouts.type100.main') --}}
@extends('layouts.type200.main')
@section('styles')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('pagetitle')
    Add Document
@endsection

@section('breadcrumb')
@include('layouts._commonpartials._breadcrumb', 
['datas'=> [
    ['label'=> 'Home','active'=>false, 'route'=> 'employee.dashboard'],
    ['label'=> 'Grievance','active'=>false],
    ['label'=> 'List','active'=>false, 'route' => 'employee.hr_grivance'],
    ['label'=> 'Add Document for Grievance Id -> ' . $hr_grivance_id  ,'active'=>true],
    ]])
@endsection


@section('side_menu')
{{-- @include('layouts.type200.partials.side_menu',['hr_grivance_id'=>$hr_grivance_id]) --}}
@endsection

@section('content')

<div class="container-fluid">
    {{-- todo:: grivance Header --}}
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body card-block">
                {{-- form --}}
                <form action="{{ route('employee.hr_grievance.storeDocInHrGrievance') }}" method="post"
                    enctype="multipart/form-data" class="">
                    {{ csrf_field() }}
                    <input type="hidden" name="hr_grivance_id" value="{{ $hr_grivance_id }}">
                    <div class="row">

                        {{-- doctitle --}}
                        <div class="form-group col-md-6 {{ $errors->has('doctitle') ? ' has-error' : '' }}">
                            <label class="required">Title</label>
                            <span class="help-block text-success pull-right">
                                <small>* Title should be short and unique for this work</small>
                            </span>
                            <input type="text" name="doctitle" class="form-control required"
                                value="{{ old('doctitle') }} ">
                            @if ($errors->has('doctitle'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('doctitle') }}</strong>
                            </span>
                            @endif
                        </div>

                        {{-- uploaded_file --}}
                        <div class="form-group col-md-6  {{ $errors->has('uploaded_file') ? ' has-error' : '' }}">
                            <label for="uploaded_file">Upload File</label>
                            <input id="uploaded_file" type="file" class="form-control" name="uploaded_file">
                            @if ($errors->has('uploaded_file'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('uploaded_file') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    {{-- description --}}
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="saveBtn" class="btn btn-flat btn-primary pull-right">Save Document</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js ">
</script>
<script>
    $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom',
            })
        });

</script>
@endsection