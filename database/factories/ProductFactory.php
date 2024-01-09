<?php

namespace IsteSitem\Products\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use IsteSitem\Products\Product;

class ProductFactory extends Factory {
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'category_id' => $this->faker->numberBetween(1, 10),
            'sku'         => Str::random(10),
            'title'       => $this->faker->words(5, true),
            'slug'        => $this->faker->slug,
            'body'        => $this->faker->text,
            'image'       => 'products/default.webp',
            'is_active'   => 1,
            'created_at'  => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
