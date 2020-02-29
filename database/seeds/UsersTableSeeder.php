<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = \App\Models\Role::where('name', \App\Enum\RoleName::BANK_OPERATIVES)->first();
        $user = new \App\Models\User();
        $user->name = 'Admin Admin';
        $user->email = 'test@admin.com';
        $user->password = 'password';
        $user->role_id = $role->id;
        $user->save();
    }
}
