<?php

// Script untuk reset password departemen admin2@simagang.id
// Jalankan dengan: php reset_password.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'admin2@simagang.id';
$newPassword = 'password123';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User dengan email {$email} tidak ditemukan!\n";
    exit(1);
}

$user->password = Hash::make($newPassword);
$user->save();

echo "✅ Password berhasil direset!\n";
echo "📧 Email: {$email}\n";
echo "🔑 Password: {$newPassword}\n";
