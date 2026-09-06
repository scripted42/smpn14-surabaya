<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Facility extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'photo_path',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
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
                    ->height(225)
                    ->sharpen(10);
                $this->addMediaConversion('detail')
                    ->width(800)
                    ->height(600);
            });
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

        return asset('images/default-facility.jpg');
    }
}
