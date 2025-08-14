<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

           $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            PlanSeeder::class,
        
        ]);

        $defaultPassword = Hash::make('Test@123');
        $admin = User::firstOrCreate(
        [
        'email' => 'admin@admin.com',
        ], 
        [
        'name' => 'Admin',
        'phone' => '9095467962',
        'password' => $defaultPassword, 
        'role' => 'admin'
        ]
        );
        $admin->assignRole('admin');

     
    }
}
