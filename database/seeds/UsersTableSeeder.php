<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        $users[] = [
            'name' => 'John Tech Manager',
            'email' => 'johnvoid@gmail.com',
            'role' => 'manager',
            'password' => Hash::make('123456'),
        ];
        $users[] = [
            'name' => 'Mike Tech Manager',
            'email' => 'mikegreen@gmail.com',
            'role' => 'manager',
            'password' => Hash::make('123456'),
        ];

        DB::table('users')->insert($users);
    }
}
