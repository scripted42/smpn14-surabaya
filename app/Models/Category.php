<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function scopeNews(Builder $query): Builder
    {
        return $query->where('type', 'news');
    }

    public function scopeAchievement(Builder $query): Builder
    {
        return $query->where('type', 'achievement');
    }
}
