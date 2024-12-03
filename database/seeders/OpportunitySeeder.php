<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Opportunity;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    public function run(): void
    {
        \DB::transaction(function () {
            Opportunity::factory(49)->create();

            Opportunity::factory(5)->create(['deleted_at' => now()]);
        });
    }
}
