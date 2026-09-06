<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Gallery extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_path',
        'event_date',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->registerMediaConversions(function (?Media $media = null) {
                $this->addMediaConversion('thumb')
                    ->width(400)
                    ->height(300)
                    ->sharpen(10);
            });
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(GalleryVideo::class);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->hasMedia('cover')) {
            return $this->getFirstMediaUrl('cover');
        }

        if ($this->cover_path) {
            return str_starts_with($this->cover_path, 'http')
                ? $this->cover_path
                : asset('storage/' . $this->cover_path);
        }

        return asset('images/default-gallery.jpg');
    }
}
