{{-- <style type="text/css">
.nav-link:hover{
    background-color: powderblue!important;
    font-weight: bold;
    color: #fff!important;
}
   
</style> --}}
<div class="sidebar sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex p-2">
        <svg class="sidebar-brand-full p-0" width="100%" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['acrs']!!}
        </svg>
        <svg class="sidebar-brand-narrow p-0" width="46" height="46" alt="PWD Logo" style="fill:powderblue;">
            {!!config('mis_entry.svgIcon')['pwd']!!}
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @if(!Auth::user()->fromShashan())
        <x-nav-item icon="plus" href="{{route('acr.create')}}">Add New ACR</x-nav-item>
        <x-nav-item icon="user-plus" href="{{route('acr.myacrs')}}">My ACR</x-nav-item>
        @endif
        <x-nav-item icon="envelope-letter " href="{{route('acr.others.index')}}">Inbox</x-nav-item>

        @if(Auth::user()->hasAccess(['create-others-acr']))
        <x-nav-item icon="user-plus" href="{{route('acr.others.defaulters')}}">Initiate Others ACR</x-nav-item>
        <x-nav-item icon="user-plus" href="{{route('acr.others.legacy',['office_id' => 0])}}">Legacy ACR</x-nav-item>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)" onclick="
                let text;
                let employee_code = prompt('Please enter Employee Code:', '');
                if (employee_code == null || employee_code == '')
                { text = 'Invalid.'; }
                else { text='{{url('acrs')}}' +'/'+ employee_code;
                        window.open(text, '_blank');
                }">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{url('vendors/@coreui/icons/svg/free.svg#cil-user')}}">
                    </use>
                </svg>
                <span> Employee's ACR </span>
            </a>
        </li>
        <x-nav-item icon="spreadsheet" href="{{route('office.acrs.view',['office_id' => Auth::user()->employee->office_idd])}}">Report</x-nav-item>
        <x-nav-item icon="spreadsheet" href="{{route('office.employeesWithoutAcr.list',['office_id' => Auth::user()->employee->office_idd,'year'=>0])}}">Critical Report</x-nav-item>
        <x-nav-item icon="spreadsheet" href="{{route('office.acrs.difficulties')}}">Difficulties Report</x-nav-item>
        <x-nav-item icon="spreadsheet" href="{{route('acr.analysis.marksChart')}}">Marks Statistics</x-nav-item>
        <x-nav-item icon="spreadsheet" href="{{route('acr.analysis.trainningRequirementChart')}}">Training Required</x-nav-item>
        <x-nav-item icon="spreadsheet" href="{{route('acr.analysis.daysChart')}}">Process Time</x-nav-item>
        {{-- At Bottom --}}
        <li class="nav-title mt-auto">Tools For Hindi Typing</li>
        <li class="nav-item ">
            <x-nav-item icon="language" href="{{url('../Font.html')}}" target="_blank" >KurtiDev to Unicode</x-nav-item>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://www.google.com/intl/hi/inputtools/try/" target="_blank">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{url('vendors/@coreui/icons/svg/brand.svg#cib-google')}}">
                    </use>
                </svg>
                <span>Google Hindi Input</span>
            </a>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
