<?php

use Illuminate\Database\Seeder;
use App\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Shift::create([
            'sm_name' => 'First',
            'sm_status' => '1',            
        ]);

        \App\Shift::create([
            'sm_name' => 'Second',
            'sm_status' => '1',            
        ]);

        \App\Shift::create([
            'sm_name' => 'Third',
            'sm_status' => '1',            
        ]);

        \App\Shift::create([
            'sm_name' => 'General',
            'sm_status' => '1',            
        ]);

    }
}
