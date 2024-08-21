<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'registration_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'user_id' => \App\Models\User::factory(),
            
        ];
    }
}
