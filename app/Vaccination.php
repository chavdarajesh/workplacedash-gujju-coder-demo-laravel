<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
   protected $fillable = [
        'vaccinated',
        'date_administered',
        'vaccine_type',
        'picture'
   ];
}
