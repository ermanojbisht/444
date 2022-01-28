@if((isset($data['icon']) && $data['icon']<>''))
     <svg class="icon">
        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-'.$data['icon'])}}">
            {{$data['label']}}
        </use>
    </svg>
@else
    {{$data['label']}}
@endif
