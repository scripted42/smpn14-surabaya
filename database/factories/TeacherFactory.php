<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nip' => fake()->numerify('19######## ###### # ###'),
            'position' => fake()->randomElement(['Guru Mata Pelajaran', 'Wali Kelas', 'Guru Bimbingan Konseling']),
            'subject' => fake()->randomElement(['Matematika', 'IPA', 'IPS', 'Bahasa Indonesia', 'Bahasa Inggris', 'Informatika', 'Seni Budaya', 'PJOK']),
            'bio' => fake()->paragraph(),
            'is_structural' => false,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }
}
