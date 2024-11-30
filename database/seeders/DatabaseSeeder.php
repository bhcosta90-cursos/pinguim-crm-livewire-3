<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->make([
            'name'  => 'CRM Admin',
            'email' => 'admin@crm.com',
        ]);

        User::upsert($user->toArray() + ['password' => bcrypt('password')], ['email']);
    }
}
