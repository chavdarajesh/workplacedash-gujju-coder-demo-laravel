<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserPermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RatingsSeeder::class);
        $this->call(RootCauseItemSeeder::class);
        $this->call(RootCauseSeeder::class);
        $this->call(BodyPartSeeder::class);
        $this->call(VictimTypeSeeder::class);
        $this->call(ControlSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(CategoryTypeSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);        
        $this->call(AuditFrequency::class);
        $this->call(CheckBoxOptionSeeder::class);        
    }
}
