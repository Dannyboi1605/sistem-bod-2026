<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::whereNotNull('email')->get();
foreach ($users as $user) {
    echo "ID: " . $user->id . " | Email: " . $user->email . " | Role: " . $user->role . " | Pwd: " . $user->password . "\n";
}
