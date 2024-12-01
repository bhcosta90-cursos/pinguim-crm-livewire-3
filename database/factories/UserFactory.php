<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\Permission\Can;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withValidationCode($code = '000000'): self
    {
        return $this->unverified()->state(fn (array $attributes) => [
            'validation_code' => $code,
            'validation_at'   => now()->addHour(),
        ]);
    }

    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->givePermissionTo([Can::BeAnAdmin]);
        });
    }

    /**
     * @param Can[] $permissions
     * @return $this
     */
    public function withPermission(array $permissions = []): static
    {
        return $this->afterCreating(function (User $user) use ($permissions) {
            foreach ($permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        });
    }
}
