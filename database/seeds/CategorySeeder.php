<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Category::create([
            'id' => '1',
            'category_name' => 'Unsafe Act',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '2',
            'category_name' => 'Not wearing PPE',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '3',
            'category_name' => 'Not following SOP',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '4',
            'category_name' => 'Over confidence / Over excited',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '5',
            'category_name' => 'Violation / Abuse',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '6',
            'category_name' => 'Horseplay',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '7',
            'category_name' => 'Behavioural',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '8',
            'category_name' => 'Incorrect Position',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '9',
            'category_name' => 'Others ( Unsafe Act )',
            'parent_id' => '1',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '10',
            'category_name' => 'Unsafe Condition',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '11',
            'category_name' => 'House keeping',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '12',
            'category_name' => 'No warning / Safety signs',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '13',
            'category_name' => 'No ventilation / Illumination',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '14',
            'category_name' => 'Hazardous chemicals',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '15',
            'category_name' => 'Radiation',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '16',
            'category_name' => 'Extreme high / Low temperature',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '17',
            'category_name' => 'Extreme noise / Dust',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '18',
            'category_name' => 'Defective equipment / Materials',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '19',
            'category_name' => 'Others ( Unsafe Condition )',
            'parent_id' => '10',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '20',
            'category_name' => 'Best Practice',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '21',
            'category_name' => 'Safety initiative',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '22',
            'category_name' => 'Quality improvement',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '23',
            'category_name' => 'Cost-Cutting',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '24',
            'category_name' => 'Fatigue reduction',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '25',
            'category_name' => 'Productivity',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '26',
            'category_name' => 'Sustainability',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '27',
            'category_name' => 'Others ( Best Practice )',
            'parent_id' => '20',
            'type_id' => '1',
            ]);
        \App\Category::create([
            'id' => '28',
            'category_name' => 'Near Miss',
            'parent_id' => '28',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '29',
            'category_name' => 'Lost Time Injury',
            'parent_id' => '29',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '30',
            'category_name' => 'Fatality',
            'parent_id' => '29',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '31',
            'category_name' => 'Reportable Accident',
            'parent_id' => '29',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '32',
            'category_name' => 'Medical Treatment Case',
            'parent_id' => '29',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '33',
            'category_name' => 'Restricted Work Case',
            'parent_id' => '29',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '34',
            'category_name' => 'First Aid Case',
            'parent_id' => '34',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '35',
            'category_name' => 'Non-Reportable Accident',
            'parent_id' => '35',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '36',
            'category_name' => 'Fire Hazard',
            'parent_id' => '36',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '37',
            'category_name' => 'Environmental',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '38',
            'category_name' => 'Harmful discharge to Air',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '39',
            'category_name' => 'Harmful discharge to Land',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '40',
            'category_name' => 'Harmful discharge to Water',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '41',
            'category_name' => 'Harmful to Flora and Fauna',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '42',
            'category_name' => 'Natural Calamity',
            'parent_id' => '37',
            'type_id' => '2',
            ]);
        \App\Category::create([
            'id' => '43',
            'category_name' => 'Environmental',
            'parent_id' => '43',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '44',
            'category_name' => 'Operational',
            'parent_id' => '44',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '45',
            'category_name' => 'Chemical',
            'parent_id' => '45',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '46',
            'category_name' => 'Health',
            'parent_id' => '46',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '47',
            'category_name' => 'Safety',
            'parent_id' => '47',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '48',
            'category_name' => 'Inherent',
            'parent_id' => '48',
            'type_id' => '3',
            ]);
        \App\Category::create([
            'id' => '49',
            'category_name' => 'Internal Audit',
            'parent_id' => '49',
            'type_id' => '4',
            ]);
        \App\Category::create([
            'id' => '50',
            'category_name' => 'External Audit',
            'parent_id' => '50',
            'type_id' => '4',
            ]);
        \App\Category::create([
            'id' => '51',
            'category_name' => 'Surprise Audit',
            'parent_id' => '51',
            'type_id' => '4',
            ]);
        \App\Category::create([
            'id' => '52',
            'category_name' => 'Inspection',
            'parent_id' => '52',
            'type_id' => '4',
            ]);
        \App\Category::create([
            'id' => '53',
            'category_name' => 'Checklist',
            'parent_id' => '53',
            'type_id' => '4',
            ]);
    }
}
