<style type="text/css">
    .nav-group .nav-item .nav-link::before {
        content: "\2007 \2007 \2007";
    }
</style>

<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex p-0">
        <svg class="sidebar-brand-full p-0" width="100%" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['misentry']!!}
        </svg>
        <svg class="sidebar-brand-narrow p-0" width="46" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['pwd']!!}
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-title">Track ACR</li>
        <x-nav-item icon="plus" href="{{route('acr.create')}}">Add New ACR</x-nav-item>
        <x-nav-group icon="book" name="ACR">
            <x-nav-group icon="list-rich" name="ACR List">
                <x-nav-item icon="user-plus" href="{{route('acr.myacrs')}}">My ACR</x-nav-item>
                <x-nav-item icon="envelope-letter " href="{{route('acr.others.index')}}">Inbox</x-nav-item>
            </x-nav-group>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="
                    let text;
                    let employee_code = prompt('Please enter Employee Code:', '');
                    if (employee_code == null || employee_code == '')
                    { text = 'Invalid.'; }
                    else { text='{{url('acr')}}' +'/'+ employee_code;
                            window.open(text, '_blank');
                    }">
                    <svg class="nav-icon">
                        <use
                            xlink:href="http://localhost:8080/hr/vendors/@coreui/icons/svg/free.svg#cil-user-plus"></use>
                    </svg>
                    <span> Employee's ACR </span>
                </a>
            </li>
        </x-nav-group>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
