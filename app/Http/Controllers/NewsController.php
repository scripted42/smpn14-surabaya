<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display a listing of published news.
     */
    public function index(Request $request): View
    {
        $categorySlug = $request->query('kategori');
        $search = $request->query('q');

        $query = News::published()
            ->with(['category', 'media', 'tags'])
            ->latest('published_at');

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(6)->withQueryString();
        $categories = \Illuminate\Support\Facades\Cache::remember('news_categories', 600, function () {
            return Category::withCount(['news' => function ($q) {
                $q->published();
            }])->get();
        });

        $currentCategory = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;

        return view('news.index', compact('news', 'categories', 'currentCategory', 'search'));
    }

    /**
     * Display the specified news article.
     */
    public function show(string $slug): View
    {
        $news = News::published()
            ->with(['category', 'media', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count
        $news->increment('views_count');

        // 3 related news in the same category
        $relatedNews = News::published()
            ->with(['category', 'media'])
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // If not enough related news in same category, fallback to latest news
        if ($relatedNews->count() < 3) {
            $moreNews = News::published()
                ->with(['category', 'media'])
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->merge($moreNews);
        }

        return view('news.show', compact('news', 'relatedNews'));
    }
}
