@isset($viewGate)
@can($viewGate)
    <a class="btn btn-outline-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{-- {{ trans('global.view') }} --}}
        Entry >>
    </a>
@endcan
@endisset

@isset($editGate)
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@endisset
@isset($editOtherInfoGate)
@can($editOtherInfoGate)
    <a class="btn btn-xs btn-success" href="{{ route('admin.'. $crudRoutePart . '.editotherinfo', $row->id) }}">Edit Other Info</a>
@endcan
@endisset
@isset($deleteGate)
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
@endisset


@isset($phyProgressGate)
@can($phyProgressGate)
    <a href="{{ route('admin.progress', $row->id) }}" class="btn btn-xs btn-primary">Physical Progress</a>
@endcan
@endisset

@isset($financialProgressGate)
@can($financialProgressGate)
    <a href="{{ route('admin.financialprogress.index', $row->id) }}" class="btn btn-xs btn-success">Financial Progress</a>
@endcan
@endisset
@isset($annualPhysicalTargetAchievementGate)
@can($annualPhysicalTargetAchievementGate)
    <a href="{{route('admin.annualphysicaltargetachievement.index', $row->id)}}" class="btn btn-xs btn-warning">Physical Target/Achievement</a>

@endcan
@endisset


@isset($assignWorkToAe)
@can($assignWorkToAe)
    <a href="{{ route('admin.'. $crudRoutePart. '.assignworktoae', $row->id )}}" class="btn btn-xs btn-success">Assign AE</a>
@endcan
@endisset
@isset($phyProgressGate)
@can($phyProgressGate)
    <a href="btn btn-xs btn-primary" href="{{ route('admin.'.$crudRoutePart.'.progress', $row->id)}}">
    </a>
@endcan
@endisset
