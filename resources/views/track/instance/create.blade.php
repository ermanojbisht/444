@extends('layouts.type200.main')

@section('styles')   
@endsection

@section('sidebarmenu')
    @include('layouts.type200._commonpartials._sidebarmenu',['active'=>'create_Instance'])
@endsection

@section('pagetitle')
     Create New Instance
@endsection

@section('breadcrumb')
    @include('layouts._commonpartials._breadcrumb',
        [   'datas'=> [
                        ['label'=>'Create New','active'=>true],
                    ]  
        ])
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-3 mb-5 bg-body rounded callout callout-info">
                <form action="{{ route('instance.store') }}" method="POST">
                    @csrf
                    <div class="row p-3">
                            <label class="col-md-2 col-form-label" for="instance_type_id" >Instance Type</label>
                            <div class="form-group col-md-6">
                                <select class="form-select" aria-label="Instance Type" id="instance_type_id" name="instance_type_id">
                                  <option selected disabled> Select</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}"> {{$type->name}} </option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">{{ $errors->first('instance_type_id') }}</div>
                                <small><span class="help-block text-info"></span></small>
                            </div>
                    </div>
                    <div class="row p-3">
                        <div class="form-group col-md-12">
                                <label for="instance_name" class="col-form-label">Description</label>
                                <textarea class="form-control" id="instance_name" name="instance_name"
                                   placeholder="Name of the Instance" required maxlength="800" rows="3"></textarea>

                                <div class="invalid-feedback">{{ $errors->first('instance_name') }}</div>
                                <small><span class="help-block text-info"></span>Please Use Unicode Font for Hindi</small>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-info px-4">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
