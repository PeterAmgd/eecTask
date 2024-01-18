<?php

namespace Database\Factories;

use App\Models\Product;
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

    protected $model = Product::class;
    public function definition(): array
    {
        return [
            //
            'title' => $this->faker->name(),
            'description' => $this->faker->sentence,
            'image' => 'products/1ocmrXiyXeUnch1TUQ78wIV4VbY2HKOXFO2z4trH.png',
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
