@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add a token for User {{$user->name}}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.token.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="form-group col-md-6">
                    {!! Form::label('token_type', 'Token Type', []) !!}
                    {!! Form::select('token_type', $optionsArray, '', ['id'=>'token_type','class'=>'form-control ']) !!}

                </div>

            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Create Token
                </button>
            </div>
            <input id="user_id" type="hidden" name="user_id" value="{{$user->id}}" />
        </form>
    </div>

</div>
@endsection
