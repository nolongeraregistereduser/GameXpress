<?php

namespace Database\Seeders;
Use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() === 0){
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => bcrypt('123456'),
            ]);
            
            // Move this line inside the conditional
            $user->assignRole('super_admin');
        }
    }
}
