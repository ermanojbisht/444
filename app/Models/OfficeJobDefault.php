<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OfficeJobDefault
 *
 * @property int $id
 * @property int $ee_office_id
 * @property int $job_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\EeOffice $eeOffice
 * @property-read \App\Models\OfficeJob $jobType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJobDefault whereUserId($value)
 * @mixin \Eloquent
 */
class OfficeJobDefault extends Model
{
    public $table = 'office_job_defaults';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'ee_office_id',
        'job_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    public function jobType()
    {
        return $this->belongsTo(OfficeJob::class, 'job_id');
    }
    public function eeOffice()
    {
        return $this->belongsTo(EeOffice::class, 'ee_office_id');
    }
}