<aside class="sidebar" :class="{ open: sidebarOpen }">
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                <path d="M11 8v6M8 11h6" opacity="0.5"/>
            </svg>
        </div>
        <div>
            <h1>NewsHawk</h1>
            <small>Intelligence Scanner</small>
        </div>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-label">Navigation</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('articles.index') }}" class="sidebar-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Articles
                </a>
            </li>
            <li>
                <a href="{{ route('topics.index') }}" class="sidebar-link {{ request()->routeIs('topics.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    Topics
                </a>
            </li>
            <li>
                <a href="{{ route('alerts.index') }}" class="sidebar-link {{ request()->routeIs('alerts.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    Alerts
                    @php $alertCount = \App\Models\Alert::where('is_read', false)->count(); @endphp
                    @if($alertCount > 0)
                    <span class="sidebar-badge sidebar-badge-alert">{{ $alertCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('sources.index') }}" class="sidebar-link {{ request()->routeIs('sources.*') ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    Sources
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-section" style="flex: 1; overflow-y: auto;">
        <div class="sidebar-label">Monitored Topics</div>
        @php $sidebarTopics = \App\Models\Topic::where('is_active', true)->orderBy('name')->get(); @endphp
        @foreach($sidebarTopics as $t)
        <a href="{{ route('topics.show', $t) }}" class="sidebar-topic">
            <span class="topic-dot" style="background: {{ $t->color }};"></span>
            {{ $t->name }}
            <span class="sidebar-badge sidebar-badge-count">{{ $t->articles_count }}</span>
        </a>
        @endforeach
    </div>

    <div class="sidebar-footer">
        <div class="scan-status">
            <div class="scan-pulse"></div>
            <span>Scanner Active · {{ \App\Models\Source::where('is_active', true)->count() }} sources</span>
        </div>
    </div>
</aside>
