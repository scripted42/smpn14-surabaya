<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Testimonial extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'role',
        'photo_path',
        'content',
        'status',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->registerMediaConversions(function (?Media $media = null) {
                $this->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150)
                    ->sharpen(10);
            });
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
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
