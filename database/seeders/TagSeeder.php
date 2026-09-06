<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Kurikulum Merdeka', 'slug' => 'kurikulum-merdeka'],
            ['name' => 'P5', 'slug' => 'p5'],
            ['name' => 'Adiwiyata', 'slug' => 'adiwiyata'],
            ['name' => 'OSN SMP', 'slug' => 'osn-smp'],
            ['name' => 'FLS2N', 'slug' => 'fls2n'],
            ['name' => 'Pramuka', 'slug' => 'pramuka'],
            ['name' => 'Literasi', 'slug' => 'literasi'],
            ['name' => 'Surabaya Hebat', 'slug' => 'surabaya-hebat'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
