<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Designation
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $short_code
 * @property int|null $is_active
 * @property int|null $sort_order
 * @method static Builder|Designation newModelQuery()
 * @method static Builder|Designation newQuery()
 * @method static Builder|Designation query()
 * @method static Builder|Designation whereId($value)
 * @method static Builder|Designation whereIsActive($value)
 * @method static Builder|Designation whereName($value)
 * @method static Builder|Designation whereShortCode($value)
 * @method static Builder|Designation whereSortOrder($value)
 * @mixin \Eloquent
 */
class Designation extends Model
{
	 protected $fillable = [
         'id',
		  'name',
		  'short_code',
		  'group_id',
		  'is_active'
    ];
   public $timestamps = false;
    protected $primaryKey = 'id';
}
