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
            Customer::factory(30)->create();
        });
    }
}
