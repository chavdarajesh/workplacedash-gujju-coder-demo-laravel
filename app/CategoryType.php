<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryType extends Authenticatable
{
	//protected $connection = 'landlord';
    use SoftDeletes;
    protected $table = 'category_type';    

}
