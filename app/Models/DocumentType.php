<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DocumentType
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $view_lvl
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType genDocOnly($value = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereViewLvl($value)
 * @mixin \Eloquent
 */
class DocumentType extends Model
{
    public function scopeGenDocOnly($query, $value=0)
    {
        return $query->where('view_lvl', $value);
    }
}
