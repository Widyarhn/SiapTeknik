<?php

namespace Database\Factories;

use App\Model\Instrumen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstrumenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'program_studi' => $this->faker->sentence(10),
            'file' => $this->faker->sentence(10),
            'judul' => $this->faker->sentence(10),
        ];
    }
}
