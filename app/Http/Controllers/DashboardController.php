<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Topic;
use App\Models\Alert;
use App\Models\Scan;
use App\Models\Source;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $topics = Topic::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->get();

        $breakingNews = Article::with(['source', 'topics'])
            ->where('is_breaking', true)
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        $latestArticles = Article::with(['source', 'topics'])
            ->orderByDesc('published_at')
            ->limit(12)
            ->get();

        $recentAlerts = Alert::with(['topic', 'article'])
            ->where('is_read', false)
            ->orderByDesc('triggered_at')
            ->limit(8)
            ->get();

        $recentScans = Scan::with('topic')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $totalArticles = Article::count();
        $todayArticles = Article::whereDate('published_at', today())->count();
        $activeSources = Source::where('is_active', true)->count();
        $unreadAlerts = Alert::where('is_read', false)->count();
        $avgSentiment = Article::whereNotNull('sentiment_score')->avg('sentiment_score');

        $topSources = Source::withCount('articles')
            ->orderByDesc('articles_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'topics', 'breakingNews', 'latestArticles', 'recentAlerts',
            'recentScans', 'totalArticles', 'todayArticles', 'activeSources',
            'unreadAlerts', 'avgSentiment', 'topSources'
        ));
    }
}
