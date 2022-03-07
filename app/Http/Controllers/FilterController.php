<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $url=$request->has('url')?$request->url:'';
        switch ($url) {
            case 'office_id-year':
                return redirect()->route('office.employeesWithoutAcr.list',['office_id'=>$request->office_id,'year'=>$request->year]);
                break;

            default:
                return redirect()->back();
                break;
        }
    }
}
