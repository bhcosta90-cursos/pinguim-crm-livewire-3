<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        $userName = $this->faker->userName();

        return [
            'name'      => $this->faker->name(),
            'email'     => $this->faker->unique()->freeEmail(),
            'phone'     => $this->faker->phoneNumber(),
            'linkedin'  => "https://www.linkedin.com/in/{$userName}",
            'facebook'  => "https://www.facebook.com/{$userName}",
            'twitter'   => "https://www.twitter.com/{$userName}",
            'instagram' => "https://www.instagram.com/{$userName}",

            'address' => $this->faker->address,
            'city'    => $this->faker->city,
            'state'   => $this->faker->state,
            'country' => $this->faker->country,
            'zip'     => $this->faker->postcode,

            'birthday' => $this->faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d'),
            'gender'   => $this->faker->randomElement(['male', 'female', 'other']),

            'company'  => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
        ];
    }

    public function deleted(): self
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
