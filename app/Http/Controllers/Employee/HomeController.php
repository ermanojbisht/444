<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

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
}
