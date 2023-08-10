<?php

use Illuminate\Database\Seeder;
use App\RootCauseItem;

class RootCauseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\RootCauseItem::create([
            'rci_id' => '1',
            'rci_rc_id' => '1',
            'rci_parent_id' => '1',            
            'rci_name' => 'Abuse or Misuse',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '17',
            'rci_rc_id' => '1',
            'rci_parent_id' => '1',            
            'rci_name' => 'Improper intentional conduct that is condoned',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '18',
            'rci_rc_id' => '1',
            'rci_parent_id' => '1',            
            'rci_name' => 'Improper intentional conduct that is not condoned',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '19',
            'rci_rc_id' => '1',
            'rci_parent_id' => '1',            
            'rci_name' => 'Improper unintentional conduct that is condoned',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '20',
            'rci_rc_id' => '1',
            'rci_parent_id' => '1',            
            'rci_name' => 'Improper unintentional conduct that is not condoned',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '2',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Excessive Wear and Tear',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '21',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Improper extension of service life',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '22',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Improper loading or rate of use',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '23',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Inadequate inspection and/or monitoring',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '24',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Inadequate maintenance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '25',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Inadequate planning of use',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '26',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Use by unqualified or untrained people',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '27',
            'rci_rc_id' => '1',
            'rci_parent_id' => '2',            
            'rci_name' => 'Use for wrong purposes',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '3',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate Engineering',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '28',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate assessment of loss exposures',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '29',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate assessment of operation readiness',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '30',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate consideration of human factors/ergonomics',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '31',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate evaluation of changes',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '32',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate monitoring or construction',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '33',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate monitoring or initial operation readiness',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '34',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate or improper controls',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '35',
            'rci_rc_id' => '1',
            'rci_parent_id' => '3',            
            'rci_name' => 'Inadequate standards, specifications and/or design criteria',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '4',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate Leadership and/or Supervision',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '36',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Giving inadequate policy, Procedure, Practices or guidelines',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '37',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Giving objectives, goals or standards that conflict',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '38',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Improper or insufficient delegation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '39',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate identification and evaluation of loss exposures',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '40',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate instructions, orientation and/or training',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '41',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate or incorrect performance feedback',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '42',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate or incorrect performance measurement and evaluation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '43',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate performance measurement and evaluation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '44',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Inadequate work planning or programming',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '45',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Lack of supervisory/management job knowledge',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '46',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Providing inadequate reference documents, directives and guidance publications',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '47',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Unclear or conflicting assignment of responsibility',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '48',
            'rci_rc_id' => '1',
            'rci_parent_id' => '4',            
            'rci_name' => 'Unclear or conflicting reporting relationships',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '5',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate Maintenance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '49',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate adjustment/assembly',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '50',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate assessment of needs',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '51',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate cleaning or resurfacing',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '52',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate communication of repair needs',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '53',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate examination of repair units',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '54',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate lubrication and servicing',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '55',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate schedule of repair work',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '56',
            'rci_rc_id' => '1',
            'rci_parent_id' => '5',            
            'rci_name' => 'Inadequate substitution of parts during repair',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '6',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate Purchasing',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '57',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Improper handling of materials',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '58',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Improper salvages and/or waste disposal',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '59',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Improper storage of materials',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '60',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Improper transporting of materials',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '61',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate communication of safety and health data',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '62',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate contractor selection',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '63',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate identification of hazardous materials',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '64',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate mode or route of shipment',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '65',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate receiving inspection and acceptance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '66',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate research on materials/equipment',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '67',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate specifications on requisitions',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '68',
            'rci_rc_id' => '1',
            'rci_parent_id' => '6',            
            'rci_name' => 'Inadequate specifications to vendors',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '7',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate Tools and Equipment',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '69',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate adjustment/repair/maintenance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '70',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate assessment of needs and risks',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '71',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate availability',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '72',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate human factors/ergonomics considerations',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '73',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate removal and replacement of unsuitable items',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '74',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate salvage and reclamation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '75',
            'rci_rc_id' => '1',
            'rci_parent_id' => '7',            
            'rci_name' => 'Inadequate standards or specifications',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '8',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate Work Standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '76',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate communication of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '77',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate employee involvement in development of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '78',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate monitoring of compliance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '79',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate monitoring of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '80',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate procedures / practices / rules in development of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '81',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate reinforcement of standards through signs, color codes and job-aids',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '82',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate standards for inventory and evaluation of exposure',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '83',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate standards for process design',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '84',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate tracking of workflow',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '85',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate training of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '86',
            'rci_rc_id' => '1',
            'rci_parent_id' => '8',            
            'rci_name' => 'Inadequate updation of standards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '10',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper Motivation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '87',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Excessive frustration',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '88',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper attempt to avoid discomfort',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '89',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper attempt to gain attention',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '90',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper attempt to save time or effort',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '91',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper performance is rewarded',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '92',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper production incentives',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '93',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Improper supervisory example',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '94',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Inadequate discipline',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '95',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Inadequate performance feedback',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '96',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Inadequate reinforcement of proper behaviour',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '97',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Inappropriate aggression',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '98',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Inappropriate peer pressure',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '99',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Lack of incentives',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '100',
            'rci_rc_id' => '2',
            'rci_parent_id' => '10',            
            'rci_name' => 'Proper performance is punished',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '11',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Inadequate Mental/Psychological Capability',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '101',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Emotional disturbance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '102',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Fears and phobias',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '103',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Inability to comprehend',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '104',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Intelligence level',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '105',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Low learning aptitude',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '106',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Low mechanical aptitude',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '107',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Memory failure',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '108',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Mental Illness',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '109',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Poor coordination',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '110',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Poor judgment',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '111',
            'rci_rc_id' => '2',
            'rci_parent_id' => '11',            
            'rci_name' => 'Slow reaction time',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '12',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Inadequate Physical/Physiological Capability',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '112',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Hearing deficiency',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '113',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Inappropriate height, weight, size, strength, reach',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '114',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Limited ability to sustain body positions',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '115',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Other permanent physical capabilities',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '116',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Other sensor deficiency (touch, taste, smell, balance)',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '117',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Respiratory incapacity',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '118',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Restricted range of body movement',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '119',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Sensitives to sensor extremes (temperature, sound)',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '120',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Substance sensitives or allergies',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '121',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Temporary disabilities',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '122',
            'rci_rc_id' => '2',
            'rci_parent_id' => '12',            
            'rci_name' => 'Vision deficiency',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '14',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Lack of Skill',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '123',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Inadequate practices',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '124',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Inadequate review instruction',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '125',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Infrequent performance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '126',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Lack of coaching/training',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '127',
            'rci_rc_id' => '2',
            'rci_parent_id' => '14',            
            'rci_name' => 'Lack of Knowledge/Experience',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '15',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Mental or Physiological',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '128',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Conflicting demands/directions',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '129',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Confusing directions/demands',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '130',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Emotional over load',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '131',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Extreme concentration/perception demands',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '132',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Extreme judgment/decision demands',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '133',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Fatigue due to mental task load or speed',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '134',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Meaningless or degrading activities',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '135',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Mental illness',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '136',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Preoccupation with problems frustration',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '137',
            'rci_rc_id' => '2',
            'rci_parent_id' => '15',            
            'rci_name' => 'Routine, monotony, demand for uneventful vigilance',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '16',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Physical or Physiological Stress',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '138',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Atmospheric pressure variation',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '139',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Blood sugar insufficiency',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '140',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Constrained movement',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '141',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Drugs',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '142',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Exposure to health hazards',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '143',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Exposure to temperature extremes',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '144',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Fatigue due to lack of rest',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '145',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Fatigue due to sensory overload',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '146',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Fatigue due to task load or duration',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '147',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Injury or illness',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
        \App\RootCauseItem::create([
            'rci_id' => '148',
            'rci_rc_id' => '2',
            'rci_parent_id' => '16',            
            'rci_name' => 'Oxygen deficiency',
            'rci_desctiption' => '',                                    
            'rci_status' => '1',                                    
        ]);
    }
}
