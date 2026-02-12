<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        $articles = $topic->articles()
            ->with('source')
            ->orderByDesc('published_at')
            ->paginate(12);

        $sentimentBreakdown = [
            'positive' => $topic->articles()->where('sentiment_label', 'positive')->count(),
            'neutral' => $topic->articles()->where('sentiment_label', 'neutral')->count(),
            'negative' => $topic->articles()->where('sentiment_label', 'negative')->count(),
        ];

        $topSourceIds = DB::table('articles')
            ->join('article_topic', 'articles.id', '=', 'article_topic.article_id')
            ->where('article_topic.topic_id', $topic->id)
            ->select('articles.source_id', DB::raw('count(*) as cnt'))
            ->groupBy('articles.source_id')
            ->orderByDesc('cnt')
            ->limit(5)
            ->get();

        $sourceModels = Source::whereIn('id', $topSourceIds->pluck('source_id'))->get()->keyBy('id');
        $topSources = $topSourceIds->map(function ($row) use ($sourceModels) {
            $row->source = $sourceModels->get($row->source_id);
            return $row;
        });

        return view('topics.show', compact('topic', 'articles', 'sentimentBreakdown', 'topSources'));
    }
}
