<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_name' => $this->faker->words(2, true),
            'price' => $this->faker->numberBetween(500, 10000),
            'description' => $this->faker->sentence(),
            'item_img' => 'test-item.jpg',
            'condition' => 'good',
            'brand_name' => 'good_brand'
        ];
    }
}
