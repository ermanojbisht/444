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

/**
 * App\Models\EeOffice
 *
 * @property int $id
 * @property int $se_office_id
 * @property string $name
 * @property string|null $name_h
 * @property string|null $addresss
 * @property string|null $district
 * @property int|null $contact_no
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float|null $phyper
 * @property float|null $finper
 * @property float|null $rank
 * @property int|null $is_exist
 * @property int|null $hr_office_id
 * @property Carbon|null $deleted_at
 * @property int|null $tressury_code
 * @property int|null $ddo_code
 * @property string|null $email
 * @property string|null $head_emp_code
 * @property string|null $email_2
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $all_related_users
 * @property int|null $is_pwd
 * @property int|null $period_category
 * @property int|null $div_type 0=unknown,1=civil,2=nh,3=adb,4=wb,5=pmgsy
 * @property-read Collection|Ae[] $aes
 * @property-read int|null $aes_count
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Collection|AlertProject[] $officeAlertProjects
 * @property-read int|null $office_alert_projects_count
 * @property-read Employee|null $officeHead
 * @property-read SeOffice $se_office
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice newQuery()
 * @method static Builder|EeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereAddresss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereAllRelatedUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDdoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereDivType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereEmail2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereFinper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereIsPwd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice wherePhyper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereSeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereTressuryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EeOffice whereUpdatedAt($value)
 * @method static Builder|EeOffice withTrashed()
 * @method static Builder|EeOffice withoutTrashed()
 * @mixin Eloquent
 */
class EeOffice extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'ee_offices';
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
}
