<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Authenticatable
{
	//protected $connection = 'landlord';
    use SoftDeletes;
    protected $table = 'roles';  

    public function permissions() {
        return $this->belongsToMany(Permission::class,'role_permissions_master');
    }

    public function users() {
        return $this->belongsToMany(UserByTennat::class,'users_roles');
    }

}
