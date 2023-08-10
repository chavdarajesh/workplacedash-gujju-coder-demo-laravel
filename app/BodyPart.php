<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyPart extends Model
{
    protected $primaryKey = 'bpm_id';
    protected $table = 'bodypart_master';    
}
