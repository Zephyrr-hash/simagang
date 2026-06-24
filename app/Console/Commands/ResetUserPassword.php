<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password {email} {password=password123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password untuk user berdasarkan email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info("Mencari user dengan email: {$email}");
        
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User dengan email {$email} tidak ditemukan!");
            $this->newLine();
            $this->info("📋 Daftar email user yang ada:");
            $users = User::select('id', 'name', 'email', 'role_id')->get();
            $this->table(['ID', 'Nama', 'Email', 'Role ID'], $users->map(function($u) {
                return [$u->id, $u->name, $u->email, $u->role_id];
            })->toArray());
            return 1;
        }

        $this->info("✅ User ditemukan:");
        $this->info("   ID: {$user->id}");
        $this->info("   Nama: {$user->name}");
        $this->info("   Email: {$user->email}");
        $this->info("   Role ID: {$user->role_id}");
        $this->newLine();

        if ($this->confirm("Reset password untuk user ini?", true)) {
            $user->password = Hash::make($password);
            $user->save();

            $this->newLine();
            $this->info("✅ Password berhasil direset!");
            $this->info("📧 Email: {$email}");
            $this->info("🔑 Password: {$password}");
            $this->newLine();
            $this->info("Silakan login dengan kredensial di atas.");
            
            return 0;
        } else {
            $this->warn("❌ Reset password dibatalkan.");
            return 1;
        }
    }
}
