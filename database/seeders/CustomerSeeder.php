<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        \DB::transaction(function () {
            Customer::factory(49)->create();

            Customer::factory(5)->create(['deleted_at' => now()]);
        });
    }
}
