<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Office;
use App\Traits\OfficeTypeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class AcrReportsController extends Controller {

    use OfficeTypeTrait;

    /**
     * @var mixed
     */
    protected $user;
    protected $msg403 = 'Unauthorized action.You are not authorised to see this ACR details';

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->middleware( function ( $request, $next ) {
            //abort_if(Gate::denies('track_estimate'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $this->user = Auth::User();

            return $next( $request );
        } );
    }

    /**
     * View Employee's Acr after Entering Employee Code from Side bar
     */
    public function show( Employee $employee )
    {
        $acrs = Acr::where( 'employee_id', $employee->id )->orderBy('from_date','DESC')->get();

        return view( 'employee.acr.employee_acr', compact( 'acrs', 'employee' ) );
    }

    public function officeAcrs( Request $request )
    {
        $officeId = ( $request->has( 'office_id' ) ) ? $request->office_id : 0;

        if ( $request->has( 'start' ) && $request->has( 'end' ) )
        {
            $this->validate(
                $request,
                [
                    'start' => 'required|date',
                    'end'   => 'required|date',
                ]
            );
            $startDate = $request->start;
            $endDate = $request->end;

        } else
        {
            $endDate = Carbon::today()->toDateString();
            $startDate = Carbon::today()->subMonths( 12 )->toDateString();

        }
        $acrs = ACR::periodBetweenDates( [ $startDate, $endDate ] )->where( 'is_active', 1 );

        if ( $officeId === 2 )
        {
            $acrs = $acrs->get();
        }

        if ( $officeId === 0 )
        {
            $acrs = false;
        }

        if ( $officeId > 0 && $officeId !==2)
        {
            $acrs = $acrs->where( 'office_id', $officeId )->get();
        }

        $offices = Office::select( 'name', 'id' )->get();

        return view( 'employee.acr.office_acrs', compact( 'acrs', 'officeId', 'offices', 'startDate', 'endDate' ) );
    }

    public function officeEmployeeListWithoutAcr($office_id=false,$year=false)
    {
        $year=($year)?:Helper::currentFyYear();
        if($office_id){

            $office=Office::findOrFail($office_id);
            $offices=Office::select('id','name')->whereIsExist(1)->orderBy('name')->get();

            $employeeList=Employee::nonRetiredWithGraceMonths(0)
            ->whereIn('designation_id',Designation::classes(['A','B','C'])->get()->pluck('id'))
            ->whereDoesntHave('acrs',function($query) use ($year){
                return $query->inYear($year);
            })
            ->when($office_id,function($query) use($office_id){
                return $query->where('office_idd',$office_id);
            })->orderBy('name')->with('office')->get();
        }else{
            $employeeList=$office=[];
        }

        return view('employee.acr.noacr',compact('employeeList','office','year','offices','office_id'));

    }

}
