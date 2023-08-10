<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Victim extends Model
{
    protected $primaryKey = 'iv_id';
    protected $table = 'incidents_victim';    
}
