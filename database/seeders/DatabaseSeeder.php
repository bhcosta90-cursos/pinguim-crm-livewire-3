<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Permission\Can;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \DB::transaction(function () {
            User::factory()->withPermission([Can::BeAnAdmin, Can::Impersonate])->create([
                'name'  => 'CRM - Admin',
                'email' => 'admin@crm.com',
            ]);

            User::factory()->admin()->create([
                'name'  => 'CRM - User',
                'email' => 'user@crm.com',
            ]);

            User::factory(20)->create();
        });
    }
}
