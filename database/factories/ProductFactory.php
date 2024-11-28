<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->name(),
            'sku' => $this->faker->unique()->randomNumber(8),
            //0/1
            'price_group_gross' => $this->faker->boolean(),
            'price_group_price' => $this->faker->randomNumber(8),
        ];
    }
}
