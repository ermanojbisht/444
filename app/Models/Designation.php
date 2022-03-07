<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysqlmispwd';
    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name',  'short_code', 'group_id', 'is_active', 'section'];
    /**
     * @var mixed
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public function scopeClasses($query,array $serviceGroup)
    {
        return $query->select('id')->whereIn('section',$serviceGroup);
    }
}
