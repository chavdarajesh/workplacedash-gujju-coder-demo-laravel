<?php

use Illuminate\Database\Seeder;
use App\VictimType;

class VictimTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\VictimType::create([
            'vtm_name' => 'Employee',
            'vtm_status' => '1',            
        ]);

        \App\VictimType::create([
            'vtm_name' => 'Contract Worker',
            'vtm_status' => '1',            
        ]);

        \App\VictimType::create([
            'vtm_name' => 'Visitor',
            'vtm_status' => '1',            
        ]);

        \App\VictimType::create([
            'vtm_name' => 'Others',
            'vtm_status' => '1',            
        ]);
    }
}
