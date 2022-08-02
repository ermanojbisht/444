<?php

namespace App\Http\Controllers\Hrms;


use App\Http\Controllers\Controller;
use App\Models\Acr\Leave;
use App\Models\HRMS\Address;
// use App\Models\HRMS\Appointment;
use App\Models\HRMS\Education;
use App\Models\HRMS\Employee;
use App\Models\HRMS\Family;
use App\Models\HRMS\Posting;

use App\Models\Office;
use App\Models\Hrms\OtherOffice;
use App\Models\Hrms\OfficeHeadQuarter;
use App\Models\Hrms\OfficeSugamDurgam;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class MigrationController extends Controller
{

    public function index()
    {
        $EmployeeCount = Employee::count();
        $AddressCount = Address::count();
        $FamillyCount = Family::count();
        $HistoryCount = Posting::count();
        $Education = Education::count();
        return view('hrms.migration.migrateData', compact(
            'Education',
            'EmployeeCount',
            'AddressCount',
            'FamillyCount',
            'HistoryCount'
        ));
    }

    public function migrateEmployeeTable()
    {
        $all_employees = DB::connection('sqlsrv')->select('select  distinct isnull(om.mis_code,0) as Office_id, isnull(am.id, 0) as appointTypeId, app.ap_order, app.ap_orderdt, ed.voterCard_No, emp.isPrabhari, ed.is_lock_by_CAO, 
        emp.emp_Code, emp.Name, ed.emp_fname,emp.DOB,emp.DOJ,emp.DOR, ed.gender, rm.id as m_religions_id, catcast.id as cast_id,
        sub_cat.id as benifit_id, ea.c_mobile, ea.c_email, ed.pan, ed.aadhar, ed.emp_height, ed.emp_idy, 
        ed.emp_martial, ed.blood_Group, 
         isnull(emp.Designation_id, 0) as Designation_id, emp.update_Date, emp.[User_Id], 
        emp.t_order_Date, isnull(emp.office_head,0) as is_office_head  from  [dbo].[all_div_emp_list_Pankaj_sir] emp
        left outer join emp_details ed on ed.emp_code = emp.emp_Code
        left outer join emp_address ea on ea.emp_code = emp.emp_Code
        left outer join religion_mas rm on rm.religion = ed.religion
        left outer join category_mas  catcast on catcast.category = ed.category 
        left outer join subcategory_mas sub_cat on sub_cat.subcategory = ed.subcategory
        left outer join office_master om on om.office_id =  emp.Office_id
        left outer join emp_appointment app on app.emp_Code = emp.emp_Code
        left outer join appoint_type_mas am on (am.app_type = app.ap_type) order by emp.emp_Code');


        foreach ($all_employees as $emp) {

            $employee = new Employee();

            $isEmployeeExist = Employee::find($emp->emp_Code);
            if ($isEmployeeExist)
                continue;


            $employee->id = $emp->emp_Code;
            $employee->name = $emp->Name;
            $employee->birth_date = $emp->DOB;
            $employee->joining_date = $emp->DOJ;
            $employee->retirement_date = $emp->DOR;

            if ($emp->emp_fname != null)
                $employee->father_name = $emp->emp_fname;


            $gender_id = 0;
            if ($emp->emp_fname != null) {
                if (strtoupper($emp->gender) == 'MALE')
                    $gender_id = 1;
                else
                    $gender_id = 2;
            }

            $employee->gender_id =  $gender_id;

            if ($emp->m_religions_id != null)
                $employee->religion_id =  $emp->m_religions_id;

            $employee->cast_id = $emp->cast_id;

            $employee->benifit_category_id = $emp->benifit_id;

            $employee->is_married  = 0;
            if ($emp->emp_martial != null) {
                if (strtoupper($emp->emp_martial) == 'MARRIED')
                    $employee->is_married = 1;
                else
                    $employee->is_married = 0;
            }

            $blood_group = isset($emp->blood_Group) ?: 0;

            if ($blood_group != 0) {
                switch (Str::upper($blood_group)) {
                    case "O-":
                        $employee->blood_group_id = "1";
                        break;

                    case "O+":
                        $employee->blood_group_id = "2";
                        break;

                    case "A-":
                        $employee->blood_group_id = "3";
                        break;

                    case "A+":
                        $employee->blood_group_id = "4";
                        break;

                    case "B-":
                        $employee->blood_group_id = "5";
                        break;

                    case "B+":
                        $employee->blood_group_id = "6";
                        break;

                    case "AB-":
                        $employee->blood_group_id = "7";
                        break;

                    case "AB+":
                        $employee->blood_group_id = "8";
                        break;

                    default:
                        $employee->blood_group_id = "0";
                        break;
                }
            }

            $employee->phone_no =  $emp->c_mobile;
            // 'phone_no1',

            $employee->email = $emp->c_email;
            $employee->pan = $emp->pan;

            if ($emp->aadhar != '' && $emp->aadhar != null)
                $employee->aadhar = $emp->aadhar;


            if ($emp->emp_height != '' && $emp->emp_height != null)
                $employee->height =  $emp->emp_height;

            $employee->identity_mark =  $emp->emp_idy;
            $employee->office_idd = $emp->Office_id;
            $employee->designation_id =  $emp->Designation_id;


            $employee->informed_by_employee_id = $emp->User_Id;
            $employee->transfer_order_date = $emp->t_order_Date;

            $employee->is_office_head = $emp->is_office_head;

            $employee->appointed_through = $emp->appointTypeId;

            if ($emp->ap_order != null)
                $employee->appointment_order_no = $emp->ap_order;

            if ($emp->ap_orderdt != null)
                $employee->appointment_order_at = $emp->ap_orderdt;


            if ($emp->voterCard_No != null)
                $employee->voter_card_id = $emp->voterCard_No;


            $employee->regular_incharge = $emp->isPrabhari;

            $employee->lock_status = ($emp->is_lock_by_CAO == 1 ? 2 : 0);
            $employee->lock_level = 1;

            // 'avatar',
            // 'created_at',
            // 'updated_at'

            $employee->save();
        }
        return "All Set Imported";
    }

    public function migrateEmployeesFamilyTable()
    {
        $all_employees = Employee::all();
        $ank =  "";
        foreach ($all_employees as $employee) {

            $isEmployeeFamilyExist = Family::where('employee_id', '=', $employee->id)->count();
            if ($isEmployeeFamilyExist > 0) {
                $ank = $ank . " Family exist for emp " . $employee->id;
                continue;
            }

            $emp_family = DB::connection('sqlsrv')->select("select isnull(rt.id,0) as relation_id, case when fm.nominee = 'Y' then 100 else 0 end as percentage,  fm.* from emp_family fm 
            left join relation_mas rt on fm.rel_type=rt.rel_type where emp_code = ?", [$employee->id]);
            if ($emp_family) {
                foreach ($emp_family as $familyMembers) {
                    if (strtoupper($emp_family[0]->nominee) == 'Y')
                        $nomineePercentage = 100;
                    else
                        $nomineePercentage =  0;

                    if ($familyMembers->rel_dt) {
                        $dob = Carbon::createFromFormat('d/m/Y', $familyMembers->rel_dt)->format('Y-m-d');

                        $employee_family_Details = Family::Create([
                            'employee_id' => $familyMembers->emp_code,
                            'relation_id' => $familyMembers->relation_id,
                            'name' => $familyMembers->rel_nm,
                            'birth_date' => $dob,
                            'nominee_percentage' => $nomineePercentage,
                            'updated_by' => 'admin'
                        ]);
                    } else {

                        $employee_family_Details = Family::Create([
                            'employee_id' => $familyMembers->emp_code,
                            'relation_id' => isset($familyMembers->m_relation_id) ?: 0,
                            'name' => $familyMembers->rel_nm,
                            //'birth_date' => $dob,
                            'nominee_percentage' => $nomineePercentage,
                            'updated_by' => 'admin'
                        ]);
                    }

                    // $allfamilyMembers = $familyMembers->rel_nm . " " .  $allfamilyMembers;
                }
            } else {
                $ank = $ank . " " .  $employee->id . " has No  Family Data.";
            }
        }
        return $ank;
    }

    public function migrateEmployeesAddresses()
    {
        $all_employees = Employee::all(); //take(10)->get();
        $ank =  "";

        foreach ($all_employees as $employee) {

            // $isEmployeeAddressExist = Address::where('employee_id', $employee->id)->get();
            // if ($isEmployeeAddressExist)
            //     continue;

            $emp_address = DB::connection('sqlsrv')->select("select ea.emp_code, 
            ea.c_add, isnull(ct.id,0) as c_tehsil_id, case when cs.id  = 1 then '5' else '0' end c_state_id, isnull(cd.mis_id,0) as c_district_id,  
            ea.p_add, isnull(pt.id,0) as p_tehsil_id, case when ps.id  = 1 then '5' else '0' end p_state_id, isnull(pd.mis_id,0) as p_district_id, 
            isnull(ht.id,0) as h_tehsil_id, case when hs.state_nm  = 'Uttarakhand' then '5' else '0' end h_state_id, isnull(hd.mis_id,0) as h_district_id,   
            isnull(hv.ConstituencyId,0) as h_vidhansabha from emp_address ea 
            left outer join Master_District cd on cd.DistrictName = ea.c_district 
            left outer join Master_state cs on cs.state_nm = ea.c_state
            left outer join tehsil_mas ct on ct.tehsil = ea.c_town
            left outer join Master_District pd on pd.DistrictName = ea.p_district 
            left outer join Master_state ps on ps.state_nm = ea.p_state
            left outer join tehsil_mas pt on pt.tehsil = ea.p_town
            left outer join Master_District hd on hd.DistrictName = ea.h_district 
            left outer join Master_state hs on hs.state_nm = ea.h_State
            left outer join tehsil_mas ht on ht.tehsil = ea.h_Tehsil
            left outer join tblConstituency hv on hv.Constituency = ea.h_Vidhan_Sabha where ea.emp_code= ?", [$employee->id]);
            if ($emp_address) {



                $employee_current_address = Address::Create([
                    'employee_id' => $emp_address[0]->emp_code,
                    'address1' => $emp_address[0]->c_add,
                    'address_type_id' => "1",
                    'state_id' => $emp_address[0]->c_state_id,
                    'district_id' => $emp_address[0]->c_district_id,
                    'tehsil_id' => $emp_address[0]->c_tehsil_id,
                    'vidhansabha_id' => 0,
                    'updated_by' => 'admin'
                ]);

                $employee_permanent_address = Address::Create([
                    'employee_id' => $emp_address[0]->emp_code,
                    'address1' => $emp_address[0]->p_add,
                    'address_type_id' => "2",
                    'state_id' =>   $emp_address[0]->p_state_id,
                    'district_id' =>   $emp_address[0]->p_district_id,
                    'tehsil_id' =>   $emp_address[0]->p_tehsil_id,
                    'vidhansabha_id' => 0,
                    'updated_by' => 'admin'
                ]);

                $employee_home_address = Address::Create([
                    'employee_id' => $emp_address[0]->emp_code,
                    //'address1' => null,
                    'address_type_id' => "3",
                    'state_id' =>  $emp_address[0]->h_state_id,
                    'district_id' =>  $emp_address[0]->h_district_id,
                    'tehsil_id' =>  $emp_address[0]->h_tehsil_id,
                    'vidhansabha_id' =>  $emp_address[0]->h_vidhansabha,
                    'updated_by' => 'admin'
                ]);
            } else {

                $ank = $ank . " " .  $employee->id . " no data found   ";
            }
        }
        return $ank;
    }

    public function migrateEmployeesEducationTable()
    {
        $all_employees = Employee::all();
        $ank =  "";
        $education_typ = 0;
        foreach ($all_employees as $employee) {

            $isEmployeeEducationExist = Education::where('employee_id', '=', $employee->id)->count();
            if ($isEmployeeEducationExist > 0) {
                $ank = $ank . " Education exist for emp " . $employee->id;
                continue;
            }

            $emp_educations = DB::connection('sqlsrv')->select("select top 10 emp_code, emp_type,  
            emp_qual, emp_year from empedu_detail where emp_code = ?", [$employee->id]);
            if ($emp_educations) {
                foreach ($emp_educations as $emp_education) {
                    if (strtoupper($emp_education->emp_type)  == 'ADDITIONAL')
                        $education_type = 2;
                    else
                        $education_type = 1;

                    $employee_family_Details = Education::Create([
                        'employee_id' => $emp_education->emp_code,
                        'qualification_type_id' =>  $education_type,
                        'qualification_id'  => 0,
                        'qualification' => $emp_education->emp_qual,
                        'year' => $emp_education->emp_year,
                        'updated_by' => 'admin'
                    ]);
                }
            } else {
                $ank = $ank . " " .  $employee->id . " has No  Education Data.";
            }
        }
        return $ank;
    }

    public function migrateEmployeesHistoryTable()
    {
        $all_employees = Employee::all();

        foreach ($all_employees as $emp) {
            $employeeHistory = DB::connection('sqlsrv')->select("select case when (otherOff.office_type is null) 
            then '0' else otherOff.id end as other_head_quarter,
            case when (otherOff.office_type is null and otherOff.office_id is not null) then otherOff.id  
            else '0'  end as other_office_id,
            case when (om.mis_code is null ) then '0' else om.mis_code end as office_id, 
            isnull(mode.id,0) as mode_id, isnull(ds.Designation_id,0) Designation_id, eh.* 
            from emp_history eh
            left join all_div_emp_Desig_treasury ds on eh.promotion_post=ds.Designation
            left join m_mode mode on eh.mode = mode.mode 
            left join office_master om on om.office_id = eh.frm_post_office_id
            left join Office_Master_Other otherOff on otherOff.office_id = eh.frm_post_office_id
            where emp_code = ? order by eh.sno", [$emp->id]);

            foreach ($employeeHistory as $employee) {

                $transferDetail =   Posting::Create([
                    'employee_id' => $employee->emp_code,
                    'order_no' => $employee->order_no,
                    'order_at' => $employee->orderdt,
                    'office_id' => $employee->office_id,
                    'other_office_id' => $employee->other_office_id,
                    'head_quarter' => $employee->other_head_quarter,
                    'from_date' => $employee->pre_date_join,
                    'to_date' => $employee->date_rel,
                    'mode_id' => $employee->mode_id,
                    'designation_id' => $employee->Designation_id,
                    'islocked' => $employee->islocked,
                    'row_confirm' => 0
                ]);
            }
        }
        return "All History Data Migrated for Employee ";
    }

    public function migrateEmployeesCurrentStatusTable()
    {

        $employeeHistory = DB::connection('sqlsrv')->select("select us.office_id,om.mis_code,emp_code,case when (us.mode like 'T' or us.mode like 'U') then '1' when (us.mode like 'RS') then '9' 
        when (us.mode like 'S') then '8' when (us.mode like 'D') then '5' when (us.mode like 'P') then '3' else '0' end as mode_id,
        case when (om.mis_code is null) then '0' else om.mis_code end as office_id,
        case when (otherOff.office_type is null)  then '0' else otherOff.id end as other_head_quarter,
        case when (otherOff.office_type is null and otherOff.office_id is not null) then otherOff.id  else '0'  end as other_office_id,
        isnull(us.designation_id,0) Designation_id, us.emp_joindt from emp_updated_status us
        left join office_master om on om.office_id = us.office_id
        left join Office_Master_Other otherOff on otherOff.office_id = us.office_id
        where  us.emp_code in (select emp_code from all_div_emp_list_Pankaj_sir)");

        foreach ($employeeHistory as $employee) {
            $postingDetail =   Posting::Create([
                'employee_id' => $employee->emp_code,
                // 'order_no' => $employee->order_no,
                // 'order_at' => $employee->,
                'office_id' => $employee->office_id,
                'other_office_id' => $employee->other_office_id,
                'head_quarter' => $employee->other_head_quarter,
                'from_date' => $employee->emp_joindt,
                // 'to_date' => $employee->date_rel,
                'mode_id' => $employee->mode_id,
                'designation_id' => $employee->Designation_id,
                'islocked' => 0,
                'row_confirm' => 0
            ]);
        }

        return "All History Data Migrated for Employee ";
    }




    public function import_leaves_data()
    {
        $all_employees_leaves = DB::connection('sqlsrv')->select(' ');


        foreach ($all_employees_leaves as $leave) {



            // 'employee_id',
            // 'leave_type_id',
            // 'from_date',
            // 'to_date',
            // 'office_id',


        }
    }


    public function office_update_with_Factors()
    {

        $hr_offices = Office::all();
        foreach ($hr_offices as $office) {

            $hrms_office = DB::connection('sqlsrv')->select("select parent_id,office_id,office_name,isdurgam,duration_factor,isPWD,isNH,isPMGSY,isADB,isWB,Latitude,Longitude,office_head_emp_code,
            office_head_designation,mis_code,acc_emp_code,office_type,Treasury_Code,DDO_Code,Email,login_name 
            FROM HRMS.dbo.office_master where mis_code =  ? ", [$office->id]);

            if ($hrms_office) {

                $office->update([
                    'isdurgam' => $hrms_office[0]->isdurgam,
                    'duration_factor' =>  $hrms_office[0]->duration_factor,
                    'Treasury_Code' => $hrms_office[0]->Treasury_Code,
                    'DDO_Code' => $hrms_office[0]->DDO_Code
                ]);
            }
        }

        return "All Office found are Updated ";
    }


    public function import_other_offices()
    {

        $hrms_office_HQ = DB::connection('sqlsrv')->select("select id,office_id,office_name,isdurgam,duration_factor,isPWD,isNH,isPMGSY,isADB,isWB,Latitude,Longitude,office_head_emp_code,
        office_head_designation,mis_code,acc_emp_code,office_type,Treasury_Code,DDO_Code,Email,login_name 
        from [dbo].[Office_Master_Other] where office_name like '%HQ%' ");

        foreach ($hrms_office_HQ as $office) {

            $hr_office_HQ_exist = OfficeHeadQuarter::find($office->id);
            if ($hr_office_HQ_exist)
                continue;

            $insert_Office_Head_Quarter = OfficeHeadQuarter::create([
                'id' => $office->id,
                'name'  => $office->office_name,
                'hr_office_id'  => $office->office_id,
                'isdurgam'  => $office->isdurgam,
                'duration_factor' => $office->duration_factor,
            ]);
        }


        $hrms_offices = DB::connection('sqlsrv')->select("select id,office_id,office_name,isdurgam,duration_factor,isPWD,isNH,isPMGSY,isADB,isWB,Latitude,Longitude,office_head_emp_code,
        office_head_designation,mis_code,acc_emp_code,office_type,Treasury_Code,DDO_Code,Email,login_name 
        from [dbo].[Office_Master_Other] where office_name not like '%HQ%' ");

        foreach ($hrms_offices as $office) {

            $hr_office_exist = OtherOffice::find($office->id);
            if ($hr_office_exist)
                continue;

            $insert_other_Office = OtherOffice::create([
                'id' => $office->id,
                'name'  => $office->office_name,
                'hr_office_id'  => $office->office_id,
                'isdurgam'  => $office->isdurgam,
                'duration_factor' => $office->duration_factor,
            ]);
        }


        return "All Other Office Sync";
    }

    public function import_Office_Hq_others()
    {
        // $offices = Office::all();
        // foreach($offices as $office)
        // {
        //     $office_sugam_durgam = OfficeSugamDurgam::create([
        //         'office_id' =>  $office->id,
        //         'table_name' => 'mispwd.offices',
        //         'doe' => '1980/01/01',
        //         'isdurgam' =>  $office->isdurgam,
        //         'duration_factor' => $office->duration_factor,
        //         'hr_office_id' => $office->hr_office_id
        //     ]);
        // }

        // $offices = OtherOffice::all();
        // foreach($offices as $office)
        // {
        //    // return $office;

        //     $office_sugam_durgam = OfficeSugamDurgam::create([
        //         'office_id' =>  $office->id,
        //         'table_name' => 'other_offices',
        //         'doe' => '1980/01/01',
        //         'isdurgam' =>  $office->isdurgam,
        //         'duration_factor' => $office->duration_factor,
        //         'hr_office_id' => $office->hr_office_id
        //     ]);
        // }


        // $offices = OfficeHeadQuarter::all();
        // foreach($offices as $office)
        // {
        //   // return $office;

        //     $office_sugam_durgam = OfficeSugamDurgam::create([
        //         'office_id' =>  $office->id,
        //         'table_name' => 'office_head_quarters',
        //         'doe' => '1980/01/01',
        //         'isdurgam' =>  $office->isdurgam,
        //         'duration_factor' => $office->duration_factor,
        //         'hr_office_id' => $office->hr_office_id
        //     ]);
        // }

        return "All Ofices Imported.";
    }

    public function setPosting_isDurgam_with_duration()
    {
        $ank = "";
        $all_postings = Posting::where("employee_id", '010096004')->get();

        foreach ($all_postings as $posting) {

            return $ank = $ank .  " *********** \n   " . $posting->from_date . ' - ' . $posting->to_date . "  =>  days -> " .
                $posting->set_durgam_sugam();

            // $posting->set_durgam_sugam()['y'] . " Years " .
            // $posting->set_durgam_sugam()['m'] . " Months" .
            // $posting->set_durgam_sugam()['d'] .  " Days ";

            // Carbon::parse($posting->set_durgam_sugam()->from_date)->format('d M Y');

        };



        return $ank;

        /*  foreach ($all_postings as $postings) {

            $isdurgam = 0;

            if ($postings->head_quarter > 0) {

                $office = OfficeHeadQuarter::where("id", $postings->head_quarter)->first();
                $duration = $office->duration_factor;
                $isdurgam = $office->isdurgam;
            }

            if ($postings->other_office_id > 0) {

                $office = OtherOffice::where("id", $postings->other_office_id)->first();
                $duration = $office->duration_factor;
                $isdurgam = $office->isdurgam;
            }


            if ($postings->office_id > 0) {

                $office = Office::where("id", $postings->office_id)->first();
                $duration = $office->duration_factor;
                $isdurgam = $office->isdurgam;
            }


            if ($postings->to_date) {


                $actual_days_in_office = (int)(Carbon::parse($postings->from_date)->diffInDays(Carbon::parse($postings->to_date)));
                $calculated_days =  $duration * $actual_days_in_office;
                $days_in_office = ($calculated_days + 1);


                return "actual_days_in_office => " . $actual_days_in_office . 
                " calculated_days => " . $days_in_office .                 
                " isdurgam => " . $isdurgam . " duration => " . $duration .
                " days_in_office => " . $days_in_office;


                
                
                // $postings->update([
                //     'days_in_office' => $days_in_office
                // ]);
            }
            //else {
            // $days_in_office =  $duration * (int)Carbon::today()->diffInDays(Carbon::parse($postings->from_date));
            //}


        } */
        return "All done";
    }




    // public function migrateEmployeesAppointmentTable()
    // {
    //     $all_employees = DB::connection('sqlsrv')->select('select dam.Designation_id designation_id, isnull(am.id, 0) as appointTypeId,ea.* from emp_appointment ea
    //     left outer join appoint_type_mas am on (am.app_type = ea.ap_frm or  am.app_type = ea.ap_type)
    //     left outer join all_div_emp_Desig_treasury dam on (dam.Designation = ea.ap_post)');
    //     foreach ($all_employees as $emp) {
    //         $employee = new Appointment();
    //         $employee->employee_id = $emp->emp_code;
    //         if ($emp->ap_order)
    //             $employee->order_no = $emp->ap_order;
    //         if ($emp->ap_orderdt)
    //             $employee->order_date =  Carbon::createFromFormat('Y-m-d', $emp->ap_orderdt)->format('Y-m-d');
    //         $employee->joining_date = $emp->ap_joindt;
    //         $employee->designation_id = $emp->designation_id;
    //         $employee->office_id = $emp->office_Code;
    //         //$employee->basic_pay =   0;
    //         $employee->save();
    //     }
    //     return "All Set Imported";
    // }



}
