<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $usherRole = Role::firstOrCreate(['name' => 'usher']);

        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superadmin123'),
            ]
        );
        $superadmin->assignRole($superadminRole);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create usher user
        $usher = User::firstOrCreate(
            ['email' => 'usher@example.com'],
            [
                'name' => 'Usher User',
                'password' => Hash::make('usher123'),
            ]
        );
        $usher->assignRole($usherRole);
    }
}
