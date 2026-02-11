@extends('layouts.app')
@section('title', 'Dashboard — NewsHawk')

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
                    <span style="color: var(--text-primary); font-weight: 600;">Command Center</span>
                </div>
            </div>
            <div style="font-size: 0.7rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace;">
                {{ now()->format('M d, Y H:i') }} UTC
            </div>
        </div>

        <div class="content-area">
            <!-- Stats Row -->
            <div class="stats-row reveal">
                <div class="stat-card stat-card-accent">
                    <div class="stat-label">Total Articles</div>
                    <div class="stat-value">{{ number_format($totalArticles) }}</div>
                    <div class="stat-sub">Across all topics</div>
                </div>
                <div class="stat-card stat-card-emerald">
                    <div class="stat-label">Today's Scan</div>
                    <div class="stat-value">{{ $todayArticles }}</div>
                    <div class="stat-sub">New articles today</div>
                </div>
                <div class="stat-card stat-card-cyan">
                    <div class="stat-label">Active Sources</div>
                    <div class="stat-value">{{ $activeSources }}</div>
                    <div class="stat-sub">Monitored feeds</div>
                </div>
                <div class="stat-card stat-card-amber">
                    <div class="stat-label">Unread Alerts</div>
                    <div class="stat-value" style="color: {{ $unreadAlerts > 0 ? 'var(--amber)' : 'var(--text-primary)' }};">{{ $unreadAlerts }}</div>
                    <div class="stat-sub">Pending review</div>
                </div>
                <div class="stat-card stat-card-{{ $avgSentiment > 0.1 ? 'emerald' : ($avgSentiment < -0.1 ? 'rose' : 'amber') }}">
                    <div class="stat-label">Avg Sentiment</div>
                    <div class="stat-value font-mono" style="color: var(--{{ $avgSentiment > 0.1 ? 'emerald' : ($avgSentiment < -0.1 ? 'rose' : 'amber') }});">
                        {{ $avgSentiment > 0 ? '+' : '' }}{{ number_format($avgSentiment ?? 0, 2) }}
                    </div>
                    <div class="stat-sub">Market mood</div>
                </div>
            </div>

            <!-- Breaking News -->
            @if($breakingNews->count())
            <div class="breaking-banner reveal">
                <div class="breaking-badge">
                    <span class="breaking-dot"></span>
                    Breaking
                </div>
                @foreach($breakingNews->take(2) as $breaking)
                <a href="{{ route('articles.show', $breaking) }}" style="display: block; text-decoration: none; color: inherit; {{ $loop->first ? '' : 'margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid rgba(244,63,94,0.15);' }}">
                    <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.25rem;">{{ $breaking->title }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                        {{ $breaking->source->name }} · {{ $breaking->published_at->diffForHumans() }}
                        @foreach($breaking->topics as $topic)
                        <span class="badge badge-{{ $topic->category_color }}" style="margin-left: 0.5rem;">{{ $topic->name }}</span>
                        @endforeach
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            <div class="grid-sidebar">
                <!-- Main Feed -->
                <div>
                    <div class="card reveal" style="margin-bottom: 1.5rem;">
                        <div class="card-header">
                            <h3>Latest Intelligence</h3>
                            <a href="{{ route('articles.index') }}" class="btn btn-ghost btn-sm">View All</a>
                        </div>
                        <div class="card-body" style="padding: 0.25rem 1.25rem;">
                            @foreach($latestArticles as $article)
                            <a href="{{ route('articles.show', $article) }}" class="article-card">
                                <div class="article-meta">
                                    <span style="color: var(--{{ $article->source->reliability_color ?? 'slate' }});">{{ $article->source->name }}</span>
                                    <span>·</span>
                                    <span>{{ $article->published_at->diffForHumans() }}</span>
                                    @if($article->sentiment_score)
                                    <span>·</span>
                                    <span style="color: var(--{{ $article->sentiment_color }});">{{ $article->sentiment_icon }} {{ $article->sentiment_label }}</span>
                                    @endif
                                </div>
                                <div class="article-title">
                                    @if($article->is_breaking)<span style="color: var(--rose);">● </span>@endif
                                    {{ $article->title }}
                                </div>
                                <div class="article-excerpt">{{ Str::limit($article->summary ?? $article->content, 140) }}</div>
                                <div style="display: flex; gap: 0.35rem; margin-top: 0.4rem;">
                                    @foreach($article->topics as $topic)
                                    <span class="badge badge-{{ $topic->category_color }}">{{ $topic->name }}</span>
                                    @endforeach
                                    @if($article->relevance_score >= 60)
                                    <span class="badge badge-{{ $article->relevance_color }}" style="margin-left: auto;">
                                        {{ $article->relevance_label }} · {{ number_format($article->relevance_score) }}%
                                    </span>
                                    @endif
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div>
                    <!-- Alerts -->
                    @if($recentAlerts->count())
                    <div class="card reveal" style="margin-bottom: 1rem;">
                        <div class="card-header">
                            <h3>Active Alerts</h3>
                            <a href="{{ route('alerts.index') }}" class="btn btn-ghost btn-sm">All</a>
                        </div>
                        <div class="card-body" style="padding: 0.25rem 1rem;">
                            @foreach($recentAlerts->take(5) as $alert)
                            <div class="alert-item">
                                <div class="alert-icon alert-icon-{{ $alert->severity_color }}">
                                    {{ $alert->severity_icon }}
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; font-size: 0.8rem; margin-bottom: 0.15rem;">{{ $alert->title }}</div>
                                    <div style="font-size: 0.7rem; color: var(--text-muted);">
                                        {{ $alert->topic->name }} · {{ $alert->triggered_at->diffForHumans() }}
                                    </div>
                                </div>
                                <span class="badge badge-{{ $alert->severity_color }}">{{ $alert->severity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Top Sources -->
                    <div class="card reveal" style="margin-bottom: 1rem;">
                        <div class="card-header">
                            <h3>Top Sources</h3>
                        </div>
                        <div class="card-body">
                            @foreach($topSources as $source)
                            <div class="source-bar">
                                <div style="width: 110px; font-size: 0.78rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $source->name }}</div>
                                <div class="source-bar-fill">
                                    <div class="source-bar-fill-inner" style="width: {{ $topSources->max('articles_count') > 0 ? ($source->articles_count / $topSources->max('articles_count') * 100) : 0 }}%;"></div>
                                </div>
                                <span class="font-mono" style="font-size: 0.7rem; color: var(--text-muted); width: 28px; text-align: right;">{{ $source->articles_count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Topics Overview -->
                    <div class="card reveal" style="margin-bottom: 1rem;">
                        <div class="card-header">
                            <h3>Topics</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem 1rem;">
                            @foreach($topics as $topic)
                            <a href="{{ route('topics.show', $topic) }}" style="display: flex; align-items: center; gap: 0.6rem; padding: 0.5rem 0; text-decoration: none; color: inherit; {{ $loop->last ? '' : 'border-bottom: 1px solid var(--border-subtle);' }}">
                                <span class="topic-dot" style="background: {{ $topic->color }};"></span>
                                <div style="flex: 1;">
                                    <div style="font-size: 0.82rem; font-weight: 500;">{{ $topic->name }}</div>
                                    <div style="font-size: 0.65rem; color: var(--text-muted);">{{ $topic->frequency_label }} · {{ $topic->category ?? 'General' }}</div>
                                </div>
                                <span class="font-mono" style="font-size: 0.72rem; color: var(--text-muted);">{{ $topic->articles_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Scans -->
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Scan Activity</h3>
                        </div>
                        <div class="card-body" style="padding: 0.25rem 1rem;">
                            @foreach($recentScans as $scan)
                            <div class="scan-item">
                                <span class="scan-dot" style="background: var(--{{ $scan->status_color }});"></span>
                                <div style="flex: 1;">
                                    <span style="font-weight: 500;">{{ $scan->topic->name ?? 'Full Scan' }}</span>
                                    <span style="color: var(--text-muted);"> · {{ $scan->new_articles }} new</span>
                                </div>
                                <span class="font-mono" style="font-size: 0.68rem; color: var(--text-muted);">{{ $scan->duration_seconds }}s</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
