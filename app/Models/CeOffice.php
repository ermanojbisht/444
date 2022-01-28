<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\CeOffice
 *
 * @property int $id
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
 * @property int|null $period_category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeOffice[] $SeOffices
 * @property-read int|null $se_offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SeOffice[] $ceOfficeSeOffices
 * @property-read int|null $ce_office_se_offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EeOffice[] $eeOffices
 * @property-read int|null $ee_offices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice newQuery()
 * @method static \Illuminate\Database\Query\Builder|CeOffice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice query()
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereContactNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereHeadEmpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereHrOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereIsExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice wherePeriodCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CeOffice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CeOffice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CeOffice withoutTrashed()
 * @mixin \Eloquent
 */
class CeOffice extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'ce_offices';
    protected $connection='mysqlmispwd';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'name_h',
        'address',
        'district',
        'email_1',
        'contact_no',
        'email_2',
        'lat',
        'lon',
        'created_at',
        'updated_at',
        'deleted_at',
        'head_emp_code'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function ceOfficeSeOffices()
    {
        return $this->hasMany(SeOffice::class, 'ce_office_id', 'id');
    }
    public function SeOffices()
    {
        return $this->hasMany(SeOffice::class, 'ce_office_id', 'id');
    }

    public function eeOffices()
    {
        return $this->hasManyThrough(EeOffice::class, SeOffice::class);
    }

    public function users()
    {
        return $this->morphToMany(User::class,'user_office');
    }

    public function officeHead()
    {
        return $this->belongsTo(Employee::class, 'head_emp_code');
    }
}
