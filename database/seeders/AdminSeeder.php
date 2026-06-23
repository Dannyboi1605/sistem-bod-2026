<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Both Hidayah and Khaireena are Admin + Urus Setia
        $admins = [
            ['name' => 'SITI NORHIDAYAH BINTI MUSLI', 'email' => 'Hidayah.Musli@sabah.gov.my', 'roles' => ['admin', 'jawatankuasa']],
            ['name' => 'NUR KHAIREENA BINTI FADZLEE', 'email' => 'khaireena.fadzlee@sabah.gov.my', 'roles' => ['admin', 'jawatankuasa']],
            ['name' => 'SUPERADMIN', 'email' => 'mdafiqdanial16@gmail.com', 'roles' => ['admin', 'jawatankuasa']]
        ];

        // Mina is only Urus Setia
        $urusSetia = [
            ['name' => 'Mina Warah Kahar', 'email' => 'minawarah.kahar@sabah.gov.my', 'roles' => ['jawatankuasa']],
        ];

        foreach (array_merge($admins, $urusSetia) as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'position' => 'Urus Setia / Admin',
                    'agency' => 'Kementerian Kewangan',
                    'roles' => $userData['roles'],
                    // Since the User model has a 'hashed' cast for password, 
                    // assigning a raw string here will correctly hash it once.
                    'password' => 'Password123',
                ]
            );
        }
    }
}
