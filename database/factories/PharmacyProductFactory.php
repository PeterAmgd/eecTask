<?php

namespace Database\Factories;

use App\Models\PharmacyProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PharmacyProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = PharmacyProduct::class;
    public function definition(): array
    {
        return [
            //
            'pharmacy_id' => \App\Models\Pharmacy::factory(),
            'product_id' =>\Database\Factories\ProductFactory::new(),
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
