<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $primaryKey = 'ir_id';
    protected $table = 'incidents_rating'; 
}
