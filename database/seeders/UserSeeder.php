<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
       $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@esig.com.br',
            'password' => bcrypt('password'),
        ]);

        
        $user->assignRole('admin');

        
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@esig.com.br',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('manager');

        
        $userCommon1 = User::create([
            'name' => 'Common User',
            'email' => 'user@esig.com.br',
            'password' => bcrypt('password'),
        ]);
        $userCommon1->assignRole('user');

        $userCommon2 = User::create([
            'name' => 'Common User 2',
            'email' => 'user2@esig.com.br',
            'password' => bcrypt('password'),
        ]);
        $userCommon2->assignRole('user');
    }
}
