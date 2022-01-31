<?php

namespace App\Models;

use App\Models\Procurement\ProcurementNotice;
use App\Traits\Auditable;
use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;


class EeOffice extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'ee_offices';
    public $fulltable = 'mispwd.ee_offices';
    protected $connection='mysqlmispwd';

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $fillable = [
        'name', 'name_h', 'addresss', 'district', 'email', 'email_2', 'contact_no', 'lat', 'lon', 'phyper', 'finper', 'rank', 'se_office_id', 'head_emp_code', 'ddo_code', 'tressury_code', 'hr_office_id', 'is_exist',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function se_office()
    {
        return $this->belongsTo(SeOffice::class, 'se_office_id');
    }

    public function officeAlertProjects()
    {
        return $this->hasMany(AlertProject::class, 'office_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_offices', 'user_office_id')->where('user_office_type', 'App\EeOffice');
        //return $this->hasMany(User::class,'user_offices','user_office_id')->where('user_office_type','App\EeOffice');
    }

    /**
     * [allUsersToRelatedOfficeUpdateInDB description]
     * @return [model itself updated]
     */
    public function allUsersToRelatedOfficeUpdateInDB()
    {
        $this->all_related_users = implode(",", $this->allUsersToRelatedOffice());
        $this->save();
    }

    /**
     * [allUsersToRelatedOffice description]
     * @return [array] [user id of all users related in hirearcy of this office]
     */
    public function allUsersToRelatedOffice()
    {
        $users = [];
        $allOffices = DB::table('ee_offices')
            ->join('se_offices', 'ee_offices.se_office_id', '=', 'se_offices.id')
            ->select('se_office_id', 'ce_office_id')
            ->where('ee_offices.id', $this->id)
            ->get();
        if (count($allOffices)) {
            $officeRow = $allOffices[0];
            $users = $userArray = DB::table('user_offices')
                ->distinct('user_id')->select('user_id')->orderBy('user_id')
                ->where([
                    ['user_office_id', '=', $officeRow->ce_office_id],
                    ['user_office_type', '=', 'App\CeOffice'],
                ])
                ->orWhere([
                    ['user_office_id', '=', $officeRow->se_office_id],
                    ['user_office_type', '=', 'App\SeOffice'],
                ])
                ->orWhere([
                    ['user_office_id', '=', $this->id],
                    ['user_office_type', '=', 'App\EeOffice'],
                ])
                ->get()->pluck('user_id')->toArray();
        }
        /*foreach ($allOffices as $key => $officeRow) {
            array_push($users, $userArray);
        }*/
        return $users;
    }

    public function officeHead()
    {
        return $this->belongsTo(Employee::class, 'head_emp_code');
    }

    public function aes()
    {
        return $this->hasMany(Ae::class)->select(['id as ae_id', 'unique_id', 'name', 'name_h', 'AE_ph']);
        //return $this->belongsToMany(User::class, 'user_offices','user_office_id')->where('designation','AE');
    }

    public function procurementNotice()
    {
        return $this->morphToMany(ProcurementNotice::class, 'procurement_noticeable');
    }

    public function allowedPersonEmpIdsOnBasisOfOfficeHierarchy()
    {
        //ee
        $eeOffice_id = $this->id;
        $seOffice_id = $this->se_office_id;
        $ceOffice_id = $this->se_office->ce_office_id;
        //emp of this office
        $emp_ids = DB::table( 'employees' )
            ->select( 'id' )
            //age not greater then 60
            ->whereIn( 'designation_id', config( 'mis_entry.allowed_person.forDocUploadDesignation' ) )
            ->where( function ( $query ) use ( $eeOffice_id, $seOffice_id, $ceOffice_id ) {
                $query->where( function ( $query ) use ( $eeOffice_id ) {
                    $query->where( 'office_id', $eeOffice_id );
                    $query->where( 'office_type', 3 );
                } );
                $query->orWhere( function ( $query ) use ( $seOffice_id ) {
                    $query->where( 'office_id', $seOffice_id );
                    $query->where( 'office_type', 2 );
                } );
                $query->orWhere( function ( $query ) use ( $ceOffice_id ) {
                    $query->where( 'office_id', $ceOffice_id );
                    $query->where( 'office_type', 1 );
                } );
            } )
            ->get()->pluck( 'id' )->toArray();


        return $emp_ids;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function bulkUpdateHeadEmpAsUserInJobTable()
    {
        $data= $this->select('id','head_emp_code')->whereNotNull('head_emp_code')->get();
        $data->map(function($item){
            $user=User::where('employee_id',$item->head_emp_code)->first();
            if($user){
                OfficeJobDefault::updateOrCreate(
                    ['job_id'=>3, 'office_id'=>(3000+$item->id)],
                    ['job_id'=>3, 'office_id'=>(3000+$item->id),'user_id'=>$user->id,'employee_id'=>$user->employee_id]);
            }
       });
    }
}
