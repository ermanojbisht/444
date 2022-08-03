<div class="card">
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold"> Employee Code :</span>
                <span> {{$employee->id }}</span>

                <input class="form-control" type="hidden" name="id" id="id"
                    value="{{ $employee->id == '' ? '' : $employee->id }}">

                <input class="form-control" type="hidden" name="employee_id" id="employee_id"
                    value="{{ $employee->id == '' ? '' : $employee->id }}">
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold"> Name :</span>
                <span> {{$employee->name }}</span>

                <input class="form-control" type="hidden" name="name" id="name"
                    value="{{ $employee->name == '' ? '' : $employee->name }}">
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold"> Gender :</span>
                @if($employee->gender_id)
                <span> {{ config('hrms.masters.gender')[$employee->gender_id] }}</span>
                <input class="form-control" type="hidden" name="gender_id" id="gender_id"
                    value="{{ $employee->gender_id == '' ? '' : $employee->gender_id }}">
                @endif
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold"> Date of Birth :</span>
                <span> {{$employee->birth_date->format('d M Y') }}</span>

                <input class="form-control" type="hidden" name="birth_date" id="birth_date"
                    value="{{ $employee->birth_date == '' ? '' : $employee->birth_date }}">
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="fw-bold"> Joining Date :</span>
                <span> {{ $employee->joining_date->format('d M Y') }} </span>
            </li>
        </ul>

        <br />
        <span class="fw-bold"> Current Details :</span>
        <br />

        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>
                    <b> Designation</b>:
                    @if ($employee->designation_id)
                    {{ $employee->designation->name }}
                    <br />
                    @if ($employee->regular_incharge != 0) (Incharge) @endif
                    @endif
                </span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span> <b> Office</b>: {{ $employee->officeName->name }} </span>
            </li>
        </ul>

    </div>
</div>
