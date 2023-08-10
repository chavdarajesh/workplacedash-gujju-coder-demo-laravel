<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Auth;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Auth::user();        

        \App\User::create([
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'is_admin' => 1,
            'status' => 1,
            'database_name' => $user->database_name,
            'companyname' => $user->companyname,
            'companyid' => $user->id,
            'remember_token' => $user->remember_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,            
        ]);

        DB::table('role_log')->insert(['rl_r_id' => '1', 'rl_user_id' => 1]);
        DB::table('users_roles')->insert(['urid' => '1', 'user_by_tennat_id' => 1,'roles_id'=>1]);

    }
}
