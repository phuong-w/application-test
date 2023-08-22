<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $store = Store::inRandomOrder()->first();
        $name = fake()->unique()->sentence(3);

        return [
            'store_id' => $store->id,
            'user_id' => $store->user_id,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1000, 5000),
            'quantity' => fake()->numberBetween(1, 20),
        ];
    }
}
