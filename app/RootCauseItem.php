<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RootCauseItem extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'rci_id';
    protected $table = 'rootcause_items'; 
}
