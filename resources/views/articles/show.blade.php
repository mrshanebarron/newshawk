@extends('layouts.app')
@section('title', $article->title . ' — NewsHawk')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="topbar-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('articles.index') }}">Articles</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <span style="color: var(--text-primary);">Article</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="grid-sidebar">
                <div>
                    <div class="card reveal">
                        <div class="card-body" style="padding: 2rem;">
                            <!-- Meta -->
                            <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                                @if($article->is_breaking)
                                <span class="badge badge-rose">Breaking</span>
                                @endif
                                @foreach($article->topics as $topic)
                                <a href="{{ route('topics.show', $topic) }}" class="badge badge-{{ $topic->category_color }}" style="text-decoration: none;">{{ $topic->name }}</a>
                                @endforeach
                                @if($article->sentiment_label)
                                <span class="badge badge-{{ $article->sentiment_color }}">{{ $article->sentiment_icon }} {{ ucfirst($article->sentiment_label) }}</span>
                                @endif
                            </div>

                            <h1 class="font-display" style="font-size: 1.75rem; line-height: 1.3; margin-bottom: 0.75rem;">{{ $article->title }}</h1>

                            <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-subtle);">
                                <span style="color: var(--{{ $article->source->reliability_color ?? 'slate' }}); font-weight: 500;">{{ $article->source->name }}</span>
                                @if($article->author)
                                <span>by {{ $article->author }}</span>
                                @endif
                                <span>{{ $article->published_at->format('F d, Y · H:i') }}</span>
                                <span>{{ $article->published_at->diffForHumans() }}</span>
                            </div>

                            @if($article->summary)
                            <div style="background: var(--accent-glow); border-left: 3px solid var(--accent); padding: 1rem 1.25rem; border-radius: 0 8px 8px 0; margin-bottom: 1.5rem;">
                                <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: var(--accent); margin-bottom: 0.35rem;">Summary</div>
                                <p style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6;">{{ $article->summary }}</p>
                            </div>
                            @endif

                            <div style="font-size: 0.9rem; color: var(--text-secondary); line-height: 1.9;">
                                {!! nl2br(e($article->content)) !!}
                            </div>

                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-subtle);">
                                <a href="{{ $article->url }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    View Original
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Analysis Panel -->
                    <div class="card reveal" style="margin-bottom: 1rem;">
                        <div class="card-header">
                            <h3>Analysis</h3>
                        </div>
                        <div class="card-body">
                            <div style="margin-bottom: 1rem;">
                                <div style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.35rem;">Relevance Score</div>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="flex: 1; height: 6px; background: var(--bg-elevated); border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ $article->relevance_score }}%; height: 100%; background: var(--{{ $article->relevance_color }}); border-radius: 3px;"></div>
                                    </div>
                                    <span class="font-mono" style="font-size: 0.85rem; font-weight: 600; color: var(--{{ $article->relevance_color }});">{{ number_format($article->relevance_score) }}%</span>
                                </div>
                                <div style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.25rem;">{{ $article->relevance_label }}</div>
                            </div>

                            @if($article->sentiment_score !== null)
                            <div style="margin-bottom: 1rem;">
                                <div style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.35rem;">Sentiment</div>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <span class="font-mono" style="font-size: 1.1rem; font-weight: 600; color: var(--{{ $article->sentiment_color }});">
                                        {{ $article->sentiment_icon }} {{ $article->sentiment_score > 0 ? '+' : '' }}{{ number_format($article->sentiment_score, 2) }}
                                    </span>
                                    <span class="badge badge-{{ $article->sentiment_color }}">{{ ucfirst($article->sentiment_label) }}</span>
                                </div>
                            </div>
                            @endif

                            <div>
                                <div style="font-size: 0.65rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.35rem;">Source Reliability</div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span class="font-mono" style="font-weight: 600;">{{ $article->source->reliability_score }}</span>
                                    <span style="font-size: 0.75rem; color: var(--text-muted);">/ 10</span>
                                    <span class="badge badge-{{ $article->source->reliability_color }}">{{ $article->source->reliability_label }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Source Info -->
                    <div class="card reveal" style="margin-bottom: 1rem;">
                        <div class="card-header">
                            <h3>Source</h3>
                        </div>
                        <div class="card-body">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $article->source->name }}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.5rem;">{{ $article->source->domain }}</div>
                            <div style="display: flex; gap: 0.35rem;">
                                <span class="badge badge-slate">{{ $article->source->category_label }}</span>
                                @if($article->source->country)
                                <span class="badge badge-slate">{{ $article->source->country }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Related Articles -->
                    @if($related->count())
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Related</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem 1rem;">
                            @foreach($related as $rel)
                            <a href="{{ route('articles.show', $rel) }}" style="display: block; padding: 0.65rem 0; {{ $loop->last ? '' : 'border-bottom: 1px solid var(--border-subtle);' }} text-decoration: none; color: inherit;">
                                <div style="font-size: 0.65rem; color: var(--text-muted); margin-bottom: 0.2rem;">{{ $rel->source->name }} · {{ $rel->published_at->diffForHumans() }}</div>
                                <div style="font-weight: 600; font-size: 0.82rem; line-height: 1.3;">{{ $rel->title }}</div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
