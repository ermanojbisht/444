<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\District
 *
 * @property int $id
 * @property string $name
 * @property string $name_h
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Block[] $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Constituency[] $constituencies
 * @property-read int|null $constituencies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tehsil[] $tehsils
 * @property-read int|null $tehsils_count
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class District extends Model
{
    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function tehsils()
    {
       return $this->hasMany(Tehsil::class);
    }

    public function constituencies()
    {
        return $this->hasMany(Constituency::class);
    }
}
