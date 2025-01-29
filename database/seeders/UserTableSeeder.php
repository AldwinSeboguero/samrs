<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $users = [
        //     [
        //         // 'id' => 1,
        //         'name' => 'Admin',
        //         'email' => 'admin@admin.com',
        //         'password' => bcrypt('password'),
        //         'remember_token' => null,
        //     ],
        //     [
        //         // 'id' => 2,
        //         'name' => 'User',
        //         'email' => 'user@user.com',
        //         'password' => bcrypt('password'),
        //         'remember_token' => null,
        //     ],
        // ];

        // User::insert($users);

        $Admin = User::create([
            'name' => 'Maria Korina Enriquez',
            'email' => 'mariakorina.enriquez@parsu.edu.ph',
            'password' => Hash::make('GAPPa55')
        ]);
        $Admin->assignRole('Admin');

        $Admin1 = User::create([
            'name' => 'April Jane Sibulo',
            'email' => 'apriljane.sibulo@parsu.edu.ph',
            'password' => Hash::make('GAPPa55')
        ]);
        $Admin1->assignRole('Admin');

        $Admin2 = User::create([
            'name' => 'Kimberly Prado',
            'email' => 'kimberly.prado@parsu.edu.ph',
            'password' => Hash::make('GAPPa55')
        ]);
        $Admin2->assignRole('Admin');
    }
}
