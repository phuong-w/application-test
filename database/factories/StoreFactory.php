<?php

namespace Database\Factories;

use App\Acl\Acl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::role(Acl::ROLE_CUSTOMER)->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'address' => fake()->city() . ', ' . fake()->state() . ', ' . fake()->country() . ', ' . fake()->streetAddress(),
        ];
    }
}
