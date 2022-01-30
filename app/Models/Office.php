<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Office extends Model
{
    use NodeTrait;
    public $timestamps =false;
    protected $connection='mysqlmispwd';


    public function getParentIdName()
    {
        return 'parrent_id';
    }
}
