<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $primaryKey = 'upd_id';
    protected $table = 'users_permissions';
}
