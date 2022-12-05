<?php

namespace Database\Seeders;

use App\Models\User_Role;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User_Role::create([
            'user_id' => '1 ',
            'role_id' => '1',

        ]);
    }
}
