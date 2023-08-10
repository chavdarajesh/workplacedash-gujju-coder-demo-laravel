<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'pm_id' => '1',
            'pm_name' => 'Audit',            
            ]);
        \App\Permission::create([
            'pm_id' => '2',
            'pm_name' => 'Audit Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '3',
            'pm_name' => 'Audit Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '4',
            'pm_name' => 'Audit Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '5',
            'pm_name' => 'Incident',            
            ]);
        \App\Permission::create([
            'pm_id' => '6',
            'pm_name' => 'Incident Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '7',
            'pm_name' => 'Incident Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '8',
            'pm_name' => 'Incident Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '9',
            'pm_name' => 'Permit',            
            ]);
        \App\Permission::create([
            'pm_id' => '10',
            'pm_name' => 'Permit Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '11',
            'pm_name' => 'Permit Edit ',            
            ]);
        \App\Permission::create([
            'pm_id' => '12',
            'pm_name' => 'Permit Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '13',
            'pm_name' => 'Permit Revoke',            
            ]);
        \App\Permission::create([
            'pm_id' => '14',
            'pm_name' => 'Permit Extend',            
            ]);
        \App\Permission::create([
            'pm_id' => '15',
            'pm_name' => 'Permit Close',            
            ]);
        \App\Permission::create([
            'pm_id' => '16',
            'pm_name' => 'Permit Reject',            
            ]);
        \App\Permission::create([
            'pm_id' => '17',
            'pm_name' => 'Audit Template',            
            ]);
        \App\Permission::create([
            'pm_id' => '18',
            'pm_name' => 'Audit Template Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '19',
            'pm_name' => 'Audit Template Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '20',
            'pm_name' => 'Audit Template Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '21',
            'pm_name' => 'Categories',            
            ]);
        \App\Permission::create([
            'pm_id' => '22',
            'pm_name' => 'Categories Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '23',
            'pm_name' => 'Categories Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '24',
            'pm_name' => 'Categories Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '25',
            'pm_name' => 'HIRA',            
            ]);
        \App\Permission::create([
            'pm_id' => '26',
            'pm_name' => 'HIRA Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '27',
            'pm_name' => 'HIRA Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '28',
            'pm_name' => 'HIRA Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '29',
            'pm_name' => 'Permit Templates',            
            ]);
        \App\Permission::create([
            'pm_id' => '30',
            'pm_name' => 'Permit Templates Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '31',
            'pm_name' => 'Permit Templates Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '32',
            'pm_name' => 'Permit Templates Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '33',
            'pm_name' => 'Root Cause',            
            ]);
        \App\Permission::create([
            'pm_id' => '34',
            'pm_name' => 'Root Cause Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '35',
            'pm_name' => 'Root Cause Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '36',
            'pm_name' => 'Root Cause Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '37',
            'pm_name' => 'Roles',            
            ]);
        \App\Permission::create([
            'pm_id' => '38',
            'pm_name' => 'Roles Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '39',
            'pm_name' => 'Roles Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '40',
            'pm_name' => 'Roles Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '41',
            'pm_name' => 'Sites',            
            ]);
        \App\Permission::create([
            'pm_id' => '42',
            'pm_name' => 'Sites Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '43',
            'pm_name' => 'Sites Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '44',
            'pm_name' => 'Sites Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '45',
            'pm_name' => 'User',            
            ]);
        \App\Permission::create([
            'pm_id' => '46',
            'pm_name' => 'User Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '47',
            'pm_name' => 'User Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '48',
            'pm_name' => 'User Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '49',
            'pm_name' => 'Workflows',            
            ]);
        \App\Permission::create([
            'pm_id' => '50',
            'pm_name' => 'Workflows Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '51',
            'pm_name' => 'Workflows Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '52',
            'pm_name' => 'Workflows Delete',            
            ]);

        \App\Permission::create([
            'pm_id' => '53',
            'pm_name' => 'Actions',            
            ]);
        \App\Permission::create([
            'pm_id' => '54',
            'pm_name' => 'Actions Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '55',
            'pm_name' => 'Actions Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '56',
            'pm_name' => 'Actions Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '57',
            'pm_name' => 'Observations',            
            ]);
        \App\Permission::create([
            'pm_id' => '58',
            'pm_name' => 'Observations Add',            
            ]);
        \App\Permission::create([
            'pm_id' => '59',
            'pm_name' => 'Observations Edit',            
            ]);
        \App\Permission::create([
            'pm_id' => '60',
            'pm_name' => 'Observations Delete',            
            ]);
        \App\Permission::create([
            'pm_id' => '61',
            'pm_name' => 'Observations Close',            
            ]);
        \App\Permission::create([
            'pm_id' => '62',
            'pm_name' => 'Incidents Close',            
            ]);
        \App\Permission::create([
            'pm_id' => '63',
            'pm_name' => 'Incidents Approve/Reject',            
        ]);
        \App\Permission::create([
            'pm_id' => '64',
            'pm_name' => 'Observations Risk potential',            
        ]);
        \App\Permission::create([
            'pm_id' => '65',
            'pm_name' => 'Vaccination',            
        ]);



    }
}
