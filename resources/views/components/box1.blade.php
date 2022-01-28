<div {{ $attributes->merge(['class' => 'border-start border-start-4 px-3 mb-3 border-start-'.$type]) }} >
    <small class="text-medium-emphasis">
        @if($link)
        <a href="{{$link}}">
           <svg class="icon">
                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-'.$icon)}}"></use>
            </svg>
        </a>
        @endif
    {{$title}}</small>
    <div class="fs-5 fw-semibold">{{$dataDetail}}</div>
</div>


