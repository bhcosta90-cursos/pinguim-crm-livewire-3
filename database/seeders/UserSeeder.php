<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Enums\Permission\Can;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \DB::transaction(function () {
            User::factory()->withPermission([Can::BeAnAdmin, Can::Impersonate])->create([
                'name'  => 'CRM',
                'email' => 'admin@crm.com',
            ]);

            User::factory()->withPermission([Can::BeAnAdmin])->create([
                'name'  => 'User',
                'email' => 'user@crm.com',
            ]);

            User::factory(49)->unverified()->create();

            User::factory(5)->unverified()->create(['deleted_at' => now()]);
        });
    }
}
