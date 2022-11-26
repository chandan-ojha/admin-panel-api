<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'position' => $this->faker->text(20),
            'age' => $this->faker->randomDigit(),
            'start_date' => $this->faker->date,
            'salary' => $this->faker->randomDigit()
        ];
    }
}
