<?php

use Illuminate\Database\Seeder;


class AuditFrequency extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['af_name'=>'Daily'],
            ['af_name'=>'Weekly'],    
            ['af_name'=>'Monthly'],    
            ['af_name'=>'Quarterly'],    
            ['af_name'=>'Half-yearly'],    
            ['af_name'=>'Yearly'],    
            ['af_name'=>'One time'],                
        ];
        DB::table('audit_frequency')->insert($data);
    }
}
