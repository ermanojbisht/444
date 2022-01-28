<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ae
 *
 * @property int|null $ee_office_id
 * @property string|null $id
 * @property string|null $name
 * @property string|null $name_h
 * @property string|null $AE_Add
 * @property string|null $AE_ph
 * @property int $unique_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Work[] $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ae newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereAEAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereAEPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereEeOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereNameH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ae whereUniqueId($value)
 * @mixin \Eloquent
 */
class Ae extends Model {

	protected $primaryKey = 'id';
	protected $keyType = 'string';

	public $incrementing = false;
	public $timestamps = false;
	protected $fillable = [
		'id',
		'ee_office_id',
		'name',
		'AE_ph'
	];
	public function liveWorks() {
		return $this->belongsToMany(Work::class, 'ae_work', 'AE_code', 'WORK_code')->withPivot('id', 'doj', 'doe', 'updated_at', 'created_at')->whereNull('ae_work.doe');
	}

    public function works() {
        return $this->belongsToMany(Work::class, 'ae_work', 'AE_code', 'WORK_code')->withPivot('id', 'doj', 'doe', 'updated_at', 'created_at');
    }

    public function employee() //not checked
    {
        return $this->belongsTo(Employee::class, 'id', 'id',);
    }

     public function eeOffice()
    {
        return $this->belongsTo(EeOffice::class, 'ee_office_id', 'id',);
    }
}
