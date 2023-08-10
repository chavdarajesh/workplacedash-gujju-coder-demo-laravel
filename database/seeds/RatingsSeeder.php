<?php

use Illuminate\Database\Seeder;
use App\Ratings;
class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Ratings::create([
            'ir_id' => '1',
            'rating' => '1',
            'severity' => 'Very Low',            
            'likelihood' => 'Unlikely / Rare',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '2',
            'rating' => '2',
            'severity' => 'Very Low',            
            'likelihood' => 'Likely / Intermittent',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '3',
            'rating' => '3',
            'severity' => 'Very Low',            
            'likelihood' => 'Frequent / Repetitive',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '4',
            'rating' => '4',
            'severity' => 'Very Low',            
            'likelihood' => 'Almost Certain / Cyclic',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '5',
            'rating' => '2',
            'severity' => 'Minor',            
            'likelihood' => 'Unlikely / Rare',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '6',
            'rating' => '4',
            'severity' => 'Minor',            
            'likelihood' => 'Likely / Intermittent',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '7',
            'rating' => '6',
            'severity' => 'Minor',            
            'likelihood' => 'Frequent / Repetitive',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '8',
            'rating' => '8',
            'severity' => 'Minor',            
            'likelihood' => 'Almost Certain / Cyclic',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '9',
            'rating' => '3',
            'severity' => 'Serious',            
            'likelihood' => 'Unlikely / Rare',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '10',
            'rating' => '6',
            'severity' => 'Serious',            
            'likelihood' => 'Likely / Intermittent',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '11',
            'rating' => '9',
            'severity' => 'Serious',            
            'likelihood' => 'Frequent / Repetitive',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '12',
            'rating' => '12',
            'severity' => 'Serious',            
            'likelihood' => 'Almost Certain / Cyclic',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '13',
            'rating' => '4',
            'severity' => 'Fatal',            
            'likelihood' => 'Unlikely / Rare',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '14',
            'rating' => '8',
            'severity' => 'Fatal',            
            'likelihood' => 'Likely / Intermittent',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '15',
            'rating' => '12',
            'severity' => 'Fatal',            
            'likelihood' => 'Frequent / Repetitive',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '16',
            'rating' => '16',
            'severity' => 'Fatal',            
            'likelihood' => 'Almost Certain / Cyclic',                                    
            'rating_type' => '3',                                    
            'rating_text' => 'Fatal',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '17',
            'rating' => '5',
            'severity' => 'Major Hazard / Calamity',            
            'likelihood' => 'Unlikely / Rare',                                    
            'rating_type' => '1',                                    
            'rating_text' => 'Minor',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '18',
            'rating' => '10',
            'severity' => 'Major Hazard / Calamity',            
            'likelihood' => 'Likely / Intermittent',                                    
            'rating_type' => '2',                                    
            'rating_text' => 'Serious',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '19',
            'rating' => '15',
            'severity' => 'Major Hazard / Calamity',            
            'likelihood' => 'Frequent / Repetitive',                                    
            'rating_type' => '3',                                    
            'rating_text' => 'Fatal',                                    
            ]);
        \App\Ratings::create([
            'ir_id' => '20',
            'rating' => '20',
            'severity' => 'Major Hazard / Calamity',            
            'likelihood' => 'Almost Certain / Cyclic',                                    
            'rating_type' => '3',                                    
            'rating_text' => 'Fatal',                                    
            ]);
    }
}
