<div class="card-header bg-info text-white p-1">
    <div class="d-flex bd-highlight align-items-center justify-content-between">
        <p class="m-2">
            @if($workcode!='')
                <a class="btn btn-sm btn-block btn-light" target="_blank"
                   href="{{config('site.app_url_mis').'/'.config('site.missite_workdetail_address').'/'.$workcode.$anchorifAny}}">
                    {{$workcode}}
                </a>
            @else
                <a class="btn btn-sm btn-block btn-light" href="#">Without Work</a>
            @endif
        </p>
        <p class="m-2">
            <span class="might-overflow h3">
               @if($work_name!='')
                    {{ $work_name }}
                @else
                    Aggrement Not associated with work
                @endif
            </span>
        </p>
        <p class="m-2">
            <a class="btn btn-sm btn-block btn-light" href="{{ route($toBackroutename,$routeParameter) }}">
                <b>&lt;&lt; Back to LIST</b>
            </a>
        </p>
    </div>
</div>
<p class="p-2 m-0 h3 text-primary font-weight-bold">{{ $pagetitle }}</p>
