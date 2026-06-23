<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Superadmin (Developer Account)
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

        // 2. SITI NORHIDAYAH BINTI MUSLI (Admin & Urus Setia)
        User::updateOrCreate(
            ['email' => 'Hidayah.Musli@sabah.gov.my'],
            [
                'name' => 'SITI NORHIDAYAH BINTI MUSLI',
                'position' => 'Urus Setia / Admin',
                'agency' => 'Kementerian Kewangan',
                'roles' => ['admin', 'jawatankuasa'],
                'password' => '@Bod2026',
            ]
        );

        // 3. NUR KHAIREENA BINTI FADZLEE (Admin & Urus Setia)
        User::updateOrCreate(
            ['email' => 'khaireena.fadzlee@sabah.gov.my'],
            [
                'name' => 'NUR KHAIREENA BINTI FADZLEE',
                'position' => 'Urus Setia / Admin',
                'agency' => 'Kementerian Kewangan',
                'roles' => ['admin', 'jawatankuasa'],
                'password' => '@Bod2026',
            ]
        );

        // 4. MINA WARAH KAHAR (Urus Setia)
        User::updateOrCreate(
            ['email' => 'minawarah.kahar@sabah.gov.my'],
            [
                'name' => 'MINA WARAH KAHAR',
                'position' => 'Urus Setia',
                'agency' => 'Kementerian Kewangan',
                'roles' => ['jawatankuasa'],
                'password' => '@Bod2026',
            ]
        );
    }
}
