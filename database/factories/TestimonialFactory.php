<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(['siswa', 'orang_tua', 'alumni']),
            'content' => fake()->paragraph(2),
            'status' => 'approved',
        ];
    }
}
