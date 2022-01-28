<div class="sidebar-user">
    @if (Auth::guest())
    <div class="sidebar-header"><a href="{{ route('login') }}">Login</a></div>
    @else
    <div class="d-flex justify-content-center">
        <div class="flex-shrink-0">
            <img src="{{ asset('../bootstrap5/img/avatars/user.jpg') }} " class="avatar img-fluid rounded me-1" alt="{{ Auth::user()->name }}" />
        </div>
        <div class="flex-grow-1 ps-2">
            <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-start">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >Log out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                        </form>
            </div>
            <div class="sidebar-user-subtitle">{{ Auth::user()->designation }}</div>
        </div>
    </div>
    @endif
</div>