@extends('layouts.app')
@section('title', 'Alerts — NewsHawk')

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
                    <span style="color: var(--text-primary);">Alerts</span>
                </div>
            </div>
            <div style="font-size: 0.78rem; color: var(--text-muted);">
                {{ $unreadCount }} unread
            </div>
        </div>

        <div class="content-area">
            <!-- Filters -->
            <div class="reveal" style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <a href="{{ route('alerts.index') }}" class="btn {{ !request('severity') && !request('type') && !request('unread') ? 'btn-primary' : 'btn-ghost' }} btn-sm">All</a>
                <a href="{{ route('alerts.index', ['unread' => 1]) }}" class="btn {{ request('unread') ? 'btn-primary' : 'btn-ghost' }} btn-sm">Unread Only</a>

                <span style="width: 1px; height: 20px; background: var(--border-subtle); margin: 0 0.25rem;"></span>

                <a href="{{ route('alerts.index', ['severity' => 'critical']) }}" class="btn {{ request('severity') === 'critical' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('severity') === 'critical' ? '' : 'color: var(--rose);' }}">Critical</a>
                <a href="{{ route('alerts.index', ['severity' => 'warning']) }}" class="btn {{ request('severity') === 'warning' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('severity') === 'warning' ? '' : 'color: var(--amber);' }}">Warning</a>
                <a href="{{ route('alerts.index', ['severity' => 'info']) }}" class="btn {{ request('severity') === 'info' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('severity') === 'info' ? '' : 'color: var(--cyan);' }}">Info</a>

                <span style="width: 1px; height: 20px; background: var(--border-subtle); margin: 0 0.25rem;"></span>

                <a href="{{ route('alerts.index', ['type' => 'breaking']) }}" class="btn {{ request('type') === 'breaking' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Breaking</a>
                <a href="{{ route('alerts.index', ['type' => 'sentiment_shift']) }}" class="btn {{ request('type') === 'sentiment_shift' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Sentiment</a>
                <a href="{{ route('alerts.index', ['type' => 'volume_spike']) }}" class="btn {{ request('type') === 'volume_spike' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Volume</a>
                <a href="{{ route('alerts.index', ['type' => 'keyword_match']) }}" class="btn {{ request('type') === 'keyword_match' ? 'btn-primary' : 'btn-ghost' }} btn-sm">Keyword</a>
            </div>

            <!-- Alerts List -->
            <div class="card reveal">
                <div class="card-body" style="padding: 0.5rem 1.25rem;">
                    @forelse($alerts as $alert)
                    <div class="alert-item" style="{{ !$alert->is_read ? 'background: var(--bg-card-hover); margin: 0 -1.25rem; padding: 0.75rem 1.25rem;' : '' }}">
                        <div class="alert-icon alert-icon-{{ $alert->severity_color }}">
                            {{ $alert->severity_icon }}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <span style="font-weight: 600; font-size: 0.88rem;">{{ $alert->title }}</span>
                                @if(!$alert->is_read)
                                <span style="width: 6px; height: 6px; background: var(--accent); border-radius: 50%;"></span>
                                @endif
                            </div>
                            @if($alert->message)
                            <div style="font-size: 0.78rem; color: var(--text-secondary); margin-bottom: 0.35rem;">{{ $alert->message }}</div>
                            @endif
                            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: var(--text-muted);">
                                <span class="badge badge-{{ $alert->topic->category_color ?? 'slate' }}">{{ $alert->topic->name }}</span>
                                <span>{{ $alert->type_label }}</span>
                                <span>·</span>
                                <span>{{ $alert->triggered_at->diffForHumans() }}</span>
                                @if($alert->article)
                                <span>·</span>
                                <a href="{{ route('articles.show', $alert->article) }}" style="color: var(--accent); text-decoration: none;">View Article →</a>
                                @endif
                            </div>
                        </div>
                        <span class="badge badge-{{ $alert->severity_color }}">{{ $alert->severity }}</span>
                    </div>
                    @empty
                    <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                        No alerts match your filters.
                    </div>
                    @endforelse
                </div>
            </div>

            @if($alerts->hasPages())
            <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
                {{ $alerts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
