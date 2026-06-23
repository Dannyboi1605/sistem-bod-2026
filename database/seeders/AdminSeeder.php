<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'mdafiqdanial16@gmail.com'],
            [
                'name' => 'superadmin',
                'position' => 'Urus Setia / Admin',
                'agency' => 'Kementerian Kewangan',
                'roles' => ['admin', 'jawatankuasa'],
                'password' => '@Bod2026',
            ]
        );
    }
}
