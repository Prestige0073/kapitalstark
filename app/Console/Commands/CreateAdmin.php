<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature   = 'admin:create {--name= : Nom complet} {--email= : Adresse e-mail} {--password= : Mot de passe}';
    protected $description = 'Créer ou promouvoir un utilisateur en administrateur';

    public function handle(): int
    {
        $name     = $this->option('name')     ?? $this->ask('Nom complet');
        $email    = $this->option('email')    ?? $this->ask('Adresse e-mail');
        $password = $this->option('password') ?? $this->secret('Mot de passe (laisser vide pour ne pas modifier si l\'utilisateur existe)');

        // Validate email
        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email']
        );

        if ($validator->fails()) {
            $this->error('Adresse e-mail invalide.');
            return self::FAILURE;
        }

        $existing = User::where('email', $email)->first();

        if ($existing) {
            $existing->is_admin = true;
            $existing->name     = $name;
            if ($password) {
                $existing->password = Hash::make($password);
            }
            $existing->save();

            $this->info("✓ L'utilisateur {$email} a été promu administrateur.");
        } else {
            if (!$password) {
                $this->error('Un mot de passe est requis pour créer un nouveau compte.');
                return self::FAILURE;
            }

            User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);

            $this->info("✓ Administrateur créé : {$email}");
        }

        $this->line('  Accès : <fg=cyan>' . url('/admin') . '</>');

        return self::SUCCESS;
    }
}
