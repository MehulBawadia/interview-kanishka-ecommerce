<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

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
        $path = storage_path('/app/public/products');
        if (! File::exists($path)) {
            File::makeDirectory($path, 0755, false, true);
        }

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100.0, 1000.00),
            'status' => Arr::random([true, false]),
            'images' => fake()->image('public/storage/products', 750, 750, 'beauty', true, true),
        ];
    }
}
