@extends('layouts.type50.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.role.name') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <td>
                            {{ $role->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.name') }}
                        </th>
                        <td>
                            {{ $role->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.permissions') }}
                        </th>
                        <td>
                            @foreach($role->permissions as $key => $permissions)
                                <span class="label label-info">{{ $permissions->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
