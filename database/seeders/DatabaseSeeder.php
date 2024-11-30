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
        \DB::transaction(function () {
            User::factory()->create([
                'name'  => 'CRM - Admin',
                'email' => 'admin@crm.com',
            ]);

            User::factory()->create([
                'name'  => 'CRM - User',
                'email' => 'user@crm.com',
            ]);

            User::factory(20)->create();
        });
    }
}
