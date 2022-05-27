<?php

namespace Database\Factories\CarModels;

use App\Models\CarModels\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'registration_number' => strtoupper($this->faker->bothify('##??##??')),
            'car_type_id' => $this->faker->numberBetween(1,3),//CarType::factory(),
            'created_by' => 1,
            'updated_by' => null
        ];
    }
}
