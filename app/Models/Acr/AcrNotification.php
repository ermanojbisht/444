<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AcrNotification extends Model
{
    protected $connection='mysqlhrms';
    protected  $fillable =['employee_id', 'acr_id', 'notification_on', 'through', 'notification_type', 'notification_no'];
    public $timestamps = false;

    protected $dates = ['notification_on'];


}
