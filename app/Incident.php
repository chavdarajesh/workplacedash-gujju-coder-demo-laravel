<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Authenticatable
{
	//protected $connection = 'landlord';
    use SoftDeletes;
    protected $primaryKey = 'im_id';
    protected $table = 'incidents_master';    

}
