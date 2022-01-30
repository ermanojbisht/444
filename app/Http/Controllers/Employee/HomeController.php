<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Log;

class HomeController extends Controller
{
    /**
     * redirect admin after login
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('employee.home');
    }

    /**
     * @param Request $request
     */
    public function employeeBasicData(Request $request)
    {
        return Employee::findOrFail($request->employee_id)->detailAsHtml();
    }
}
