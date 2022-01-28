<li class="nav-item">
    <a class="nav-link" href="{{ $href }}">
        <svg class="nav-icon">
          <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-'.$icon)}}"></use>
        </svg>
         {{ $slot }}
    </a>
</li>
