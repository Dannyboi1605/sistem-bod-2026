<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Tan Sri Ahmad Bakri',
            'position' => 'Board Member',
            'agency' => 'Ministry of Finance',
            'is_eligible_cert' => true,
            'roles' => ['peserta'],
        ]);

        User::create([
            'name' => "Yang Berhormat Mulia Tengku Dato' Sri Haji Zafrul Bin Tengku Abdul Aziz",
            'position' => 'Minister of Investment, Trade and Industry',
            'agency' => 'MITI',
            'is_eligible_cert' => true,
            'roles' => ['peserta'],
        ]);

        User::create([
            'name' => 'Muhammad Ali',
            'position' => 'Senior Associate',
            'agency' => 'Petronas',
            'is_eligible_cert' => false,
            'roles' => ['peserta'],
        ]);

        User::create([
            'name' => 'Urus Setia BOD',
            'email' => 'urussetia@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'position' => 'Secretariat Officer',
            'agency' => 'State Government Secretariat',
            'is_eligible_cert' => false,
            'roles' => ['jawatankuasa'],
        ]);

        User::create([
            'name' => 'Super Admin BOD',
            'email' => 'admin@admin.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'position' => 'System Administrator',
            'agency' => 'State Government Secretariat',
            'is_eligible_cert' => false,
            'roles' => ['admin'],
        ]);
    }
}
