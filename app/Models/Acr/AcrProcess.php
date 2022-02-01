<?php

namespace App\Models\Acr;

use Illuminate\Database\Eloquent\Model;

class AcrProcess extends Model {
    protected $table = 'acr_process';
    protected $fillable = ['acr_id', 'report_employee_id', 'review_employee_id', 'accept_employee_id', 'report_on', 'review_on', 'accept_on', 'is_active'];
    public $timestamps = false;
}
