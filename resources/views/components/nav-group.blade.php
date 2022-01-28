<li class="nav-group">
    <a class="nav-link nav-group-toggle" href="#">
        <svg class="nav-icon">
          <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-'.$icon)}}"></use>
        </svg>
        {{ $name }}
    </a>
    <ul class="nav-group-items">
        {{ $slot }}
    </ul>
</li>
