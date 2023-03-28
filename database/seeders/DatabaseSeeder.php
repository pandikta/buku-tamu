<?php

namespace Database\Seeders;

use App\Models\StaffModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234',
            'password' => Hash::make('123456'),
        ]);

        StaffModel::create([
            'name' => 'staff',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
