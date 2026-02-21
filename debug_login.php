<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Check user exist
$user = User::where('email', 'admin@gmail.com')->first();
if ($user) {
    echo "✓ User admin@gmail.com ditemukan\n";
    echo "  - ID: " . $user->id . "\n";
    echo "  - Name: " . $user->name . "\n";
    echo "  - Role: " . $user->role . "\n";
    
    // Test password
    if (password_verify('admin123', $user->password)) {
        echo "✓ Password 'admin123' cocok\n";
    } else {
        echo "✗ Password TIDAK cocok! Password stored: " . $user->password . "\n";
    }
} else {
    echo "✗ User admin@gmail.com TIDAK ditemukan\n";
}

// List all users
echo "\n--- All Users in Database ---\n";
$users = User::all();
foreach ($users as $u) {
    echo "Email: " . $u->email . ", Role: " . $u->role . "\n";
}
