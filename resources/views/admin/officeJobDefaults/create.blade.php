@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add a user to a job for a particular office
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.office-job-defaults.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="job_id">Job Type</label>
                 <select class="form-control select2 {{ $errors->has('job_id') ? 'is-invalid' : '' }}" name="job_id" id="job_id" required>
                    @foreach($jobs as $id => $job)
                        <option value="{{ $id }}" {{ old('job_id') == $id ? 'selected' : '' }}>{{ $job }}</option>
                    @endforeach
                </select>
                @if($errors->has('job_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_id') }}
                    </div>
                @endif
                <span class="help-block">JOB ID</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_id">Office</label>
                <select class="form-control select2 {{ $errors->has('office_id') ? 'is-invalid' : '' }}" name="office_id" id="office_id" required>
                    <option value="" >Please select</option>
                    @foreach($offices as $id => $office)
                        <option value="{{ $office->id }}" {{ old('office_id') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('office_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('office_id') }}
                    </div>
                @endif
                <span class="help-block">Office</span>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    {!! Form::label('section', 'Section', []) !!}
                    {!! Form::select('section', ['All'=>'All','A'=>'A','B'=>'B','C'=>'C','D'=>'D'], 'All', ['id'=>'section','class'=>'form-control']) !!}

                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('employeeType', 'Employee Type', []) !!}
                    {!! Form::select('employeeType', ['All'=>'All','er'=>'Engineer','office'=>'Office','other'=>'Other'], 'All', ['id'=>'employeeType','class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">Name Of User</label>
                <select class="form-control select2 {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                </select>
                @if($errors->has('employee_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_id') }}
                    </div>
                @endif
                <span class="help-block">User Id</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div id="employee_detail_div"></div>
    </div>
</div>
@endsection
@section('footscripts')
    @include('partials.js._employeeSelect2DropDownJs')

<script type="text/javascript">
    $(document).ready(function() {
        let section= $( "#section" ).val();
        let employeeType= $( "#employeeType" ).val();

        $('#section').on('change', function() {
           section= this.value;
           employeeType= $( "#employeeType" ).val();
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });


        $('#employeeType').on('change', function() {
           section= $( "#section" ).val();
           employeeType= this.value;
           employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType,section);
        });



        employeeSelect2DropDown('#employee_id',minimumInputLength=3,employeeType='all',section='all');


        $('#employee_id').change(function(event) {
            $.ajax({
                url: '{{route('employee.basicData')}}',
                type: 'POST',
                //dataType: 'default',//causes error if data is not in jSON format
                data: {employee_id: $('#employee_id').val(),_token : $('meta[name="csrf-token"]').attr('content')},
                success: function (result,status,xhr) {
                    $('#employee_detail_div').html(result)
                },
                error: function (xhr,status,error) {
                    console.log("error",error,status);
                }
            });
        });

    });

</script>
@endsection

