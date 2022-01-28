<?php

namespace App\Models\Track;

use App\Models\Track\InstanceEstimate;
use App\Models\Track\MInstanceStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model {
    use HasFactory;

    protected $fillable = [
        'instance_name',  'status_master_id' ,  'instance_type_id',    'user_id',];


    public static function boot() {
        parent::boot();
        self::deleting(function($instance) { // before delete() method call this
            if($instance->estimate){
             $instance->estimate->delete();
            }

             $instance->history()->each(function($history) {
                $history->delete(); //
             });
             // do the rest of the cleanup...
        });
    }

    public function scopeEstimateType( $query )
    {
        return $query->where('instance_type_id',1);
    }

    public function updateFirstMovementStatus()
    {
        if($this->status_master_id == 1 && $this->history())
        {
            $this->status_master_id = 2;
            $this->timestamps = false;
            $this->save(); 
        }
    }
     
    public function estimate() {
        return $this->belongsTo(InstanceEstimate::class, 'id', 'instance_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function currentStatus() {
        return $this->belongsTo(MInstanceStatus::class, "status_master_id", "id");
    }

    public function type() {
        return $this->belongsTo(InstanceType::class, "instance_type_id", "id");
    }

    public function history()
    {
         return $this->hasMany(InstanceHistory::class, "instance_id", "id");
    }

    public function lastHistory()
    {
         return $this->history()->get()->first();
    }

    public function savePendingWithRecognizeUser(){
        $history =  $this->history()->where("to_id", "<>", "0")->first();
        if($history){
            $this->instance_pending_with_user_id = $history->to_id;
            $this->timestamps = false;
            $this->save();
        } 
    }

    public function instanceLastRecognizeUser() {
        return $this->belongsTo(User::class, "instance_pending_with_user_id", "id");
    }

    public function blocks(){
         return $this->hasMany(InstanceBlock::class);
    }

    public function constituency(){
         return $this->hasMany(InstanceConstituency::class);
    }

    public function CheckMovemtPermission($user_id){
        $permissionflag=false;
        if($this->user_id==$user_id){
             $permissionflag=true;
        }
        $history = $this->history()->get();
        if($history->count()>0)
        { 
            $userWhoHasInstance=$history->where('action_taken', 0)->pluck('to_id'); 
            if(!$permissionflag)  {
                if(in_array($user_id,$userWhoHasInstance->toArray())){
                    $permissionflag=true;
                }
            }
        }
        return $permissionflag;
    }

    

    
    
}
