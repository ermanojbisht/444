<div class="header-divider"></div>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb my-0 ms-2">
            @foreach ($datas as $data)
            <li class="breadcrumb-item {{ (isset($data['active']) && $data['active']) ?'active':'' }}">
                @if((isset($data['route']) && $data['route']<>''))
                    <a href="{{ Route( $data['route'],(isset($data['routefielddata']))?$data['routefielddata']:[]
                        ) }}">
                     @include('layouts._commonpartials._ifIcon',$data)
                    </a>
                @else
                    @include('layouts._commonpartials._ifIcon',$data)
                @endif
            </li>
            @endforeach
        </ol>
    </nav>
    @yield('breadcrumbNevigationButton')
</div>


