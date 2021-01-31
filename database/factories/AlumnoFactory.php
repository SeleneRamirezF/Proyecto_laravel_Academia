<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'=>$this->faker->firstName(),
            'apellidos'=>$this->faker->lastName().",".$this->faker->lastName(),
            'mail'=>$this->faker->unique()->email,
            'telefono'=>$this->faker->numberBetween($min=111111111, $max=999999999),
        ];
    }
}
