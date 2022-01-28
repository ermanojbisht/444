<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $WORK_code
 * @property int $doctype_id
 * @property string $name
 * @property int $version
 * @property string|null $address
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $uploaded_by
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $doe
 * @property-read \App\Models\DocumentType $documentType
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDoctypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDoe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereWORKCode($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
	protected $dates = ['created_at'];
    public function work()
    {
    	return $this->belongsTo(work::class,'work_code','WORK_code');
    }

    public function documentType()
    {
    	return $this->belongsTo(DocumentType::class,'doctype_id','id');
    }
    public function documentTypeGeneral()
	{
	   return $this->documentType()->genDocOnly(0);
	   
	}
}
