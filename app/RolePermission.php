<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{    
    protected $primaryKey = 'rpm_id';
    protected $table = 'role_permissions_master';
}
