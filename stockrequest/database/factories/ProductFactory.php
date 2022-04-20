<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => str_pad(rand(0,1000),5,0,STR_PAD_LEFT),
            'location_id'=> function () {
                return Location::inRandomOrder()->select("id")->first()->id;
            },
            'qty' => rand(10,100),
            'unit_id'=> function () {
                return Unit::inRandomOrder()->select("id")->first()->id;
            },
            'note' => $this->faker->name()
        ];
    }
}
