<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_role = new \App\Models\Role();
        $first_role->name = \App\Enum\RoleName::CUSTOMER;
        $first_role->save();

        $second_role = new \App\Models\Role();
        $second_role->name = \App\Enum\RoleName::BANK_OPERATIVES;
        $second_role->save();
    }
}
