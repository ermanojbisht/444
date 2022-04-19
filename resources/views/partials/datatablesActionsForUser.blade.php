@can('user_show')
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . 'users' . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan

@can('user_edit')
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . 'users' . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan

@can('user_role_assignment')
    <a class="btn btn-xs btn-warning" href="{{ route('admin.assignUserOffices',['userid'=>$row->id]) }}">
        Edit Office-job
    </a>
@endcan

@can('user_delete')
    <form action="{{ route('admin.' . 'users' . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
