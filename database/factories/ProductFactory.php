<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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
        $path = 'products';
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        $image = fake()->image(Storage::disk('public')->path($path), 750, 750, null, true);
        $imageFile = new \Illuminate\Http\File($image);

        return [
            'name' => fake()->words(3, true),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100.0, 1000.00),
            'status' => Arr::random([true, false]),
            'images' => Storage::disk('public')->putFile('products', $imageFile),
        ];
    }
}
