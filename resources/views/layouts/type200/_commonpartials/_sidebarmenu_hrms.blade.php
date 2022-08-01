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
        <li class="nav-title">HRMS</li>

        @can('create_employee')
        <x-nav-group icon="user-plus" name="Employees">
            <x-nav-item icon="description" href="{{route('employee.index')}}">New Employees List</x-nav-item>
            <x-nav-item icon="plus" href="{{route('employee.create')}}">Add New Employee </x-nav-item>
        </x-nav-group>
        @endcan

        @can('employee_edit_hq')
            <x-nav-item icon="chat-bubble" href="{{route('employee.updateEmployee')}}">HQ Level Info Update </x-nav-item>
        @endcan
        @can('edit_employee')
        <x-nav-item icon="user-plus" href="{{route('employee.office.index')}}">Employees List</x-nav-item>
        @endcan
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)" onclick="
                let text;
                let employee_code = prompt('Please enter Employee Code:', '');
                if (employee_code == null || employee_code == '')
                { text = 'Invalid.'; }
                else { text='{{url('viewEmpDetail')}}' +'/'+ employee_code;
                        window.open(text, '_blank');
                }">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-user')}}">
                    </use>
                </svg>
                <span> Employee's Sugam <br>Durgam Details </span>
            </a>
        </li>


        {{--
        <x-nav-group icon="applications" name="Report">
            <x-nav-item icon="user-plus" href="{{route('resolve_hr_grievance')}}">View Other Grievances</x-nav-item>
        </x-nav-group>
        --}}

    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
