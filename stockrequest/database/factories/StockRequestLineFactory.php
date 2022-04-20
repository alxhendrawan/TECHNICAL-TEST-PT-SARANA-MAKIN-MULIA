<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockRequestHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StockRequestLineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'stock_request_header_id' => function () {
                return StockRequestHeader::inRandomOrder()->select("id")->first()->id;
            },
            'product_id' => function () {
                return Product::inRandomOrder()->select("id")->first()->id;
            },
            'qty' => 5,
            'status' => 1,
            'notes' =>$this->faker->streetName()
        ];
    }
}
