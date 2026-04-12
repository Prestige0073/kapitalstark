<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kapitalstark.fr'],
            [
                'name'     => 'Admin KapitalStark',
                'password' => Hash::make('Admin1234!'),
                'is_admin' => true,
                'phone'    => '+33 1 23 45 67 89',
            ]
        );

        $this->command->info('✓ Admin : admin@kapitalstark.fr / Admin1234!');
    }
}
