<?php

use Illuminate\Database\Seeder;
use App\Control;
class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Control::create([
            'cm_name' => 'Elimination',
            'cm_status' => '1',            
        ]);

        \App\Control::create([
            'cm_name' => 'Substitution',
            'cm_status' => '1',            
        ]);

        \App\Control::create([
            'cm_name' => 'Engineering',
            'cm_status' => '1',            
        ]);

        \App\Control::create([
            'cm_name' => 'Administrative',
            'cm_status' => '1',            
        ]);
    }
}
