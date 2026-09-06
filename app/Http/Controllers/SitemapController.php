<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic sitemap.xml for search engines.
     */
    public function index(): Response
    {
        $news = News::published()
            ->latest('published_at')
            ->get();

        $pages = Page::where('is_published', true)->get();
        $galleries = Gallery::latest('event_date')->get();

        $xml = view('sitemap', compact('news', 'pages', 'galleries'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
