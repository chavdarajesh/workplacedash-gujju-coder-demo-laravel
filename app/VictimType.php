<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VictimType extends Model
{
    protected $primaryKey = 'vtm_id';
    protected $table = 'victimtype_master';    
}
