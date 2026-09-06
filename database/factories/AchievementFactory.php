<?php

namespace Database\Factories;

use App\Models\Achievement;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition(): array
    {
        return [
            'student_name' => fake()->name() . ' (Kelas ' . fake()->randomElement(['VII', 'VIII', 'IX']) . ')',
            'title' => fake()->randomElement(['Juara 1', 'Juara 2', 'Medali Emas', 'Medali Perak']) . ' ' . fake()->sentence(4),
            'category_id' => Category::where('type', 'achievement')->inRandomOrder()->value('id'),
            'level' => fake()->randomElement(['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional']),
            'year' => fake()->numberBetween(2023, 2026),
            'description' => fake()->sentence(12),
        ];
    }
}
