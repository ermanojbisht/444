<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\user_office
 *
 * @property int|null $user_id
 * @property string|null $user_office_type
 * @property int|null $user_office_id
 * @property int|null $import_allowed
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|user_office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office query()
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereImportAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_office whereUserOfficeType($value)
 * @mixin \Eloquent
 */
class user_office extends Model
{
    protected $fillable = [
        'user_id','user_office_type','user_office_id', 'import_allowed'
    ];
    protected $table='user_offices';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
