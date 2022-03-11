<header class="c-header c-header-fixed px-3">
    <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="fas fa-fw fa-bars"></i>
    </button>
    <ul class="c-header-nav ml-auto">
        @if(Auth::check())
            <div class="btn-group">
              <a type="button" class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->shriName}}</a>
              <div class="dropdown-menu">
                <a  href="{{ route('profile.password.edit') }}" class="dropdown-item"> Change Password </a>
                <a  href="{{ route('profile.email.edit') }}" class="dropdown-item"> Change Email </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    Logout
                </a>
              </div>
            </div>
        @else
            <a href="{{route('login')}}">LogIn </a>
        @endif
    </ul>

</header>
