<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator SMPN 14',
                'email' => 'admin@smpn14-surabaya.sch.id',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Operator TU Konten',
                'email' => 'operator@smpn14-surabaya.sch.id',
                'password' => Hash::make('password'),
                'role' => 'operator',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Kepala Sekolah (Reviewer)',
                'email' => 'kepsek@smpn14-surabaya.sch.id',
                'password' => Hash::make('password'),
                'role' => 'reviewer',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
