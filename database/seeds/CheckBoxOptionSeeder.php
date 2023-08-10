<?php

use Illuminate\Database\Seeder;
use App\CheckBoxOption;
class CheckBoxOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CheckBoxOption::create([
            'aco_id' => '1',
            'aco_grpid_id' => '1',            
            'aco_name' => 'Yes',
            'optcolor' => '2',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '2',
            'aco_grpid_id' => '1',            
            'aco_name' => 'No',            
            'optcolor' => '3',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '3',
            'aco_grpid_id' => '1',            
            'aco_name' => 'N/A',            
            'optcolor' => '5',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '4',
            'aco_grpid_id' => '2',            
            'aco_name' => 'Good',            
            'optcolor' => '1',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '5',
            'aco_grpid_id' => '2',            
            'aco_name' => 'Fair',            
            'optcolor' => '4',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '6',
            'aco_grpid_id' => '2',            
            'aco_name' => 'Poor',            
            'optcolor' => '3',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '7',
            'aco_grpid_id' => '2',            
            'aco_name' => 'N/A',            
            'optcolor' => '5',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '8',
            'aco_grpid_id' => '3',            
            'aco_name' => 'Compliant',            
            'optcolor' => '2',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '9',
            'aco_grpid_id' => '3',            
            'aco_name' => 'Non-Compliant',            
            'optcolor' => '3',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '10',
            'aco_grpid_id' => '3',            
            'aco_name' => 'N/A',            
            'optcolor' => '5',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '11',
            'aco_grpid_id' => '4',            
            'aco_name' => 'Compliant',            
            'optcolor' => '2',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '12',
            'aco_grpid_id' => '4',            
            'aco_name' => 'Improvement',            
            'optcolor' => '3',                        
            ]);
        \App\CheckBoxOption::create([
            'aco_id' => '13',
            'aco_grpid_id' => '4',            
            'aco_name' => 'Minor N/C',            
            'optcolor' => '5',                        
        ]);
        \App\CheckBoxOption::create([
            'aco_id' => '14',
            'aco_grpid_id' => '4',            
            'aco_name' => 'Major N/C',  
            'optcolor' => '4',                                  
        ]);

    }
}
