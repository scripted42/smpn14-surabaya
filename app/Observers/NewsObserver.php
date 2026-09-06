<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Cache;

class NewsObserver
{
    /**
     * Clear news cache keys.
     */
    protected function clearCache(): void
    {
        Cache::forget('homepage_news');
        Cache::forget('news_categories');
        Cache::forget('homepage_stats');
    }

    /**
     * Handle the News "saved" event.
     */
    public function saved(News $news): void
    {
        $this->clearCache();
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        $this->clearCache();
    }

    /**
     * Handle the News "restored" event.
     */
    public function restored(News $news): void
    {
        $this->clearCache();
    }

    /**
     * Handle the News "forceDeleted" event.
     */
    public function forceDeleted(News $news): void
    {
        $this->clearCache();
    }
}
