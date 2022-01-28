<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tehsil
 *
 * @property int $id
 * @property int $district_id
 * @property int $block_id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Block $block
 * @property-read \App\Models\District $district
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Work[] $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tehsil whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tehsil extends Model
{
    public function district(){
        return $this->belongsTo(District::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'tahsil_id', 'id');
    }
}
