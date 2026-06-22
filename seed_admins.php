<?php
// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admins = [
    ['name' => 'SITI NORHIDAYAH BINTI MUSLI', 'email' => 'Hidayah.Musli@sabah.gov.my', 'role' => 'admin'],
    ['name' => 'NUR KHAIREENA BINTI FADZLEE', 'email' => 'khaireena.fadzlee@sabah.gov.my', 'role' => 'admin'],
];

$urusSetia = [
    // Hidayah and Khaireena are already admins, so we just add Minawarah as jawatankuasa
    ['name' => 'Mina Warah Kahar', 'email' => 'minawarah.kahar@sabah.gov.my', 'role' => 'jawatankuasa'],
];

foreach (array_merge($admins, $urusSetia) as $userData) {
    User::updateOrCreate(
        ['email' => $userData['email']],
        [
            'name' => $userData['name'],
            'position' => 'Sekretariat',
            'agency' => 'Kementerian Kewangan',
            'role' => $userData['role'],
            'password' => Hash::make('password123'),
        ]
    );
    echo "Seeded user: " . $userData['email'] . "\n";
}
