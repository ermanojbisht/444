<header class="c-header c-header-fixed px-3">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="fas fa-fw fa-bars"></i>
    </button>

    <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="fas fa-fw fa-bars"></i>
    </button>

    <ul class="c-header-nav ml-auto">
        @if(auth()->user())
          &#128591; {{strtoupper(auth()->user()->name)}}
          @if(strpos(auth()->user()->email, 'emp.com') !== false )
          <br>Please change your mail . Share your mail with IT cell
          @endif
        @endif
        @if(count(config('panel.available_languages', [])) > 1)
            <li class="c-header-nav-item dropdown d-md-down-none">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach(config('panel.available_languages') as $langLocale => $langName)
                        <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                    @endforeach
                </div>
            </li>
        @endif
    </ul>
</header>
