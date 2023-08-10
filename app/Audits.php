<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audits extends Model
{
    //protected $connection = 'landlord';
    use SoftDeletes;
    protected $primaryKey = 'adm_id';
    protected $table = 'audit_master';    

}
