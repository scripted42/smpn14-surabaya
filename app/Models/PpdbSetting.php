<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PpdbSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_open',
        'academic_year',
        'intro_text',
        'registration_url',
        'requirements',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(PpdbTimeline::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(PpdbFaq::class)->orderBy('sort_order');
    }

    public static function current(): ?self
    {
        return static::latest()->first();
    }
}
