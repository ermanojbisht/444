<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use \DateTimeInterface;

/**
 * App\Models\SeOffice
 *
 * @property int $id
 * @property int $ce_office_id
 * @property string $name
 * @property string|null $name_h
 * @property string $address
 * @property string|null $district
 * @property string|null $contact_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_exist
 * @property int|null $hr_office_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $email
 * @property string|null $head_emp_code
 * @property int|null $ddo_code
 * @property int|null $treasury_code
 * @property int|null $period_category
 * @property-read \App\Models\CeOffice $ce_office
 * @property-read \Illuminate\Database\Eloquent\Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EeOffice[] $seOfficeEeOffices
 * @property-read int|null $se_office_ee_offices_count
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice newQuery()
 * @method static \Illuminate\Database\Query\Builder|SeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereCeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDdoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereTreasuryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SeOffice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SeOffice withoutTrashed()
 * @mixin \Eloquent
 */
class SeOffice extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    public $table = 'se_offices';
    protected $connection='mysqlmispwd';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'name_h',
        'addresss',
        'district',
        'email_1',
        'email_2',
        'contact_no',
        'lat',
        'lon',
        'ce_office_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'head_emp_code'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function seOfficeEeOffices()
    {
        return $this->hasMany(EeOffice::class, 'se_office_id', 'id');
    }

    public function ce_office()
    {
        return $this->belongsTo(CeOffice::class, 'ce_office_id');
    }

    public function procurementNotice()
    {
        return $this->morphToMany(ProcurementNotice::class, 'procurement_noticeable');
    }

    public function officeHead()
    {
        return $this->belongsTo(Employee::class, 'head_emp_code');
    }
}
