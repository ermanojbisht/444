<?php

namespace App\Http\Controllers\Employee\Acr;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Acr\Acr;
use App\Models\Acr\AcrType;
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
        $acrs = Acr::where( 'employee_id', $employee->id )->where('is_active',1)->orderBy('from_date','DESC')->get();
        $isMyAcr=false;
        if($this->user){
            $isMyAcr= $this->user->employee_id==$employee->id;
        }

        return view( 'employee.acr.employee_acr', compact( 'acrs', 'employee','isMyAcr' ) );
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

        $acrs = ACR::periodBetweenDates( [ $startDate, $endDate ] )->with('office')->where( 'is_active', 1 );

        if ( $officeId == 2 )
        {
           $acrs = $acrs->get();
        }

        if ( $officeId === 0 )
        {
            $acrs = false;
        }

        if ( $officeId > 0 && $officeId != 2)
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

            $allEmployeesQuery=Employee::nonRetiredWithGraceMonths(0)
            ->whereIn('designation_id',Designation::classes(['A','B','C'])->get()->pluck('id'))
            ->when($office_id,function($query) use($office_id){
                return $query->where('office_idd',$office_id);
            });

            $totalEmployees=$allEmployeesQuery->count();

            $employeeWithFilledAcr= $allEmployeesQuery->whereHas('acrs',function($query) use ($year){
                return $query->inYear($year);
            })->with('acrs',function($query) use ($year){
                return $query->inYear($year);
            })->get();

            $daysInSelectedYear=Helper::daysBetweenDate($dates=[$year.'-04-01',($year+1).'-03-31'],true);
            //Log::info("daysInSelectedYear = ".print_r($daysInSelectedYear,true));
            $noOfemployeefilledAcr=$employeeWithFilledAcr->count();
            $employeeWithFilledAcr=$employeeWithFilledAcr->filter(function($employee) use($daysInSelectedYear){
                $days=$employee->acrs->sum(function($acr){
                    return $acr->from_date->diffInDays($acr->to_date)+1;
                });                
               return $days==$daysInSelectedYear;
            }); 

            $noOfemployeeWithcompleteAcr=$employeeWithFilledAcr->count();





            $employeeList=Employee::nonRetiredWithGraceMonths(0)
            ->whereIn('designation_id',Designation::classes(['A','B','C'])->get()->pluck('id'))
            ->when($office_id,function($query) use($office_id){
                return $query->where('office_idd',$office_id);
            })
            ->whereDoesntHave('acrs',function($query) use ($year){
                return $query->inYear($year);
            })
            ->orderBy('name')->with('office')->get();
            
        }else{
            $employeeList=$office=[];
        }

        return view('employee.acr.noacr',
            compact('employeeList','office','year','offices','office_id','totalEmployees','noOfemployeeWithcompleteAcr','noOfemployeefilledAcr'));

    }

    public function difficulties()
    {
       $acr_Types = AcrType::all();
       $acrs = Acr::select('employee_id','acr_type_id','office_id','from_date','to_date','difficultie')->whereRaw('LENGTH(difficultie) > ?', [10])->get()->groupBy(['acr_type_id','employee_id']);
       foreach($acrs as $acr_id=>$records){
            foreach($records as $emp_id=>$emp_acr_details){
                $difficulty_text = '';
                foreach($emp_acr_details as $acr){
                    $sim = similar_text($acr->difficultie, $difficulty_text, $perc);
                    if($perc < 85 ){
                        $difficulty_text = $acr->difficultie;
                    }else{
                        $acr->difficultie = '';
                    }
                    if(stripos($acr->difficultie,'--------') !== false){
                        $acr->difficultie = '';
                    }
                    if(stripos($acr->difficultie,'.......') !== false){
                        $acr->difficultie = '';
                    }
                }
            }
       }
        return view( 'employee.acr.difficulties', compact( 'acrs','acr_Types') );
    }
    
    public function confidential($designationId = 20)
    {
        $employees = Employee::where('designation_id',$designationId)->with('activeAcrs')->get();

        //$acrs = ACR::select( 'id','employee_id','acr_type_id','office_id','from_date','to_date','accept_on','is_active','report_integrity','accept_no','accept_remark','final_no' )->with('employee')->where('employee.designationId',$designationId)->get()->groupBy('employee_id');
        return view( 'employee.acr.confidentialReport', compact( 'employees') );
    }

}
