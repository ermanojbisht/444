<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OfficeJob
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfficeJobDefault[] $usersAndOfiices
 * @property-read int|null $users_and_ofiices_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeJob whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfficeJob extends Model
{
    public $table = 'office_jobs';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function usersAndOfiices()
    {
       return $this->hasMany(OfficeJobDefault::class, 'job_id');
    }
}
