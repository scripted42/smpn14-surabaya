<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'category_id' => Category::where('type', 'news')->inRandomOrder()->value('id') ?? Category::factory(),
            'author_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'excerpt' => fake()->paragraph(2),
            'content' => '<p>' . implode('</p><p>', fake()->paragraphs(4)) . '</p>',
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(10),
            'views_count' => fake()->numberBetween(10, 500),
        ];
    }
}
