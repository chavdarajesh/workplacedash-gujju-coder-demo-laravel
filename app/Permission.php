<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'pm_id';
    protected $table = 'permissions_master';

    public function roles() {

   return $this->belongsToMany(Roles::class,'role_permissions_master');
       
}

public function users() {

   return $this->belongsToMany(UserByTennat::class,'users_permissions');
       
}
}
