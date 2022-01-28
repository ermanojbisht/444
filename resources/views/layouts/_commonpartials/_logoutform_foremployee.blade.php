<form id="logoutform" action="{{ route('employee.logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
