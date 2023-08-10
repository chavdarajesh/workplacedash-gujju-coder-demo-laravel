<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckBoxOption extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'aco_id';
    protected $table = 'audit_checkbox_optoin';    
}
