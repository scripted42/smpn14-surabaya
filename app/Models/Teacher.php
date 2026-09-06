<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Teacher extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'nip',
        'position',
        'subject',
        'photo_path',
        'bio',
        'is_structural',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_structural' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->registerMediaConversions(function (?Media $media = null) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(400)
                    ->sharpen(10);
            });
    }

    public function scopeStructural(Builder $query): Builder
    {
        return $query->where('is_structural', true)->orderBy('sort_order');
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->hasMedia('photo')) {
            return $this->getFirstMediaUrl('photo');
        }

        if ($this->photo_path) {
            return str_starts_with($this->photo_path, 'http')
                ? $this->photo_path
                : asset('storage/' . $this->photo_path);
        }

        return asset('images/default-avatar.jpg');
    }
}
