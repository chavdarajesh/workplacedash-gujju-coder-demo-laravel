<?php

use Illuminate\Database\Seeder;
use App\RootCause;

class RootCauseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\RootCause::create([
            'rc_id' => '1',
            'rc_name' => 'Job Factors',
            'rc_desctiption' => '',            
            'rc_status' => '1',                                    
        ]);

        \App\RootCause::create([
            'rc_id' => '2',
            'rc_name' => 'Personal Factors',
            'rc_desctiption' => '',            
            'rc_status' => '1',                                    
        ]);
    }
}
