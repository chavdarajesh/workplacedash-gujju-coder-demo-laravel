<?php

use Illuminate\Database\Seeder;
use App\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Roles::create([
            'r_name' => 'Super Admin',
            'r_status' => '1',            
        ]);

        \App\Roles::create([
            'r_name' => 'Head of Safety',
            'r_status' => '1',            
        ]);

        \App\Roles::create([
            'r_name' => 'User',
            'r_status' => '1',            
        ]);

        \App\Roles::create([
            'r_name' => 'Head of Division',
            'r_status' => '1',            
        ]);

        \App\Roles::create([
            'r_name' => 'Guest',
            'r_status' => '1',            
        ]); 

        \App\Roles::create([
            'r_name' => 'Universal User',
            'r_status' => '1',   
            'deleted_at' => '2021-05-06 04:58:28',            
        ]);        
    }
}
