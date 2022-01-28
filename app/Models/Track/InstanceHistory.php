<?php

namespace App\Models\Track;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstanceHistory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'instance_id', 'from_id', 'to_id', 'emp_code', 'emp_name', 'designation', 'office', 'remarks', 'action_taken', 'isViewed'
    ];
 
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('reverse', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }
    
    public function sender() {
    	return $this->belongsTo(User::class, "from_id", "id");
    }
 
    public function receiver() {
    	return $this->belongsTo(User::class, "to_id", "id");
    }

    public function current_receiver()
    {
        if($this->action_taken == 0)
    	return $this->hasOne(User::class, "to_id", "id")->first();
    }
 
}
