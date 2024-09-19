<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('1234@Abcd'),
        ]);
        $user->assignRole('Admin');
    }
}
