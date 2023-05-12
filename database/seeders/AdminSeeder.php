<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  $admin = User::create(
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => Hash::make('admin12345'),
        //         'status' => '1',
        //         'team_id' => '1',
        //     ]
        // );

        // $admin->assignRole('Admin');
    }
}
