<?php

use Illuminate\Database\Seeder;
use App\CategoryType;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CategoryType::create([
            'ct_name' => 'Observation',
            'status' => '1',            
        ]);

        \App\CategoryType::create([
            'ct_name' => 'Incidents',
            'status' => '1',            
        ]);

        \App\CategoryType::create([
            'ct_name' => 'Classification',
            'status' => '1',            
        ]);

        \App\CategoryType::create([
            'ct_name' => 'Audits',
            'status' => '0',            
        ]);
        
    }
}
