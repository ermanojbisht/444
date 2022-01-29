<?php namespace App\Traits;

trait CanGetTableNameStatically
{
    public static function tableName()
    {
        //if (this->connection=='mysqlmispwd'){
            return with(new static)->getTable();
        //}

    }
}
