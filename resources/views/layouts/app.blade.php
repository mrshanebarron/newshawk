<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NewsHawk — Intelligence Scanner')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-deep: #0a0d12;
            --bg-primary: #0f1319;
            --bg-card: #141820;
            --bg-card-hover: #1a1f2a;
            --bg-elevated: #1e2433;
            --border-subtle: #1e2433;
            --border-active: #2a3344;
            --text-primary: #e8ecf4;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.08);
            --accent-bright: #60a5fa;
            --emerald: #10b981;
            --emerald-glow: rgba(16, 185, 129, 0.12);
            --amber: #f59e0b;
            --amber-glow: rgba(245, 158, 11, 0.12);
            --rose: #f43f5e;
            --rose-glow: rgba(244, 63, 94, 0.12);
            --cyan: #06b6d4;
            --cyan-glow: rgba(6, 182, 212, 0.08);
            --violet: #8b5cf6;
            --orange: #f97316;
            --sidebar-w: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Page Layout */
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-primary);
            border-right: 1px solid var(--border-subtle);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--cyan));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-brand h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .sidebar-brand small {
            display: block;
            font-size: 0.6rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        .sidebar-section {
            padding: 1rem 0.75rem;
        }

        .sidebar-label {
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            padding: 0 0.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-nav { list-style: none; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.55rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .sidebar-link:hover {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .sidebar-link.active {
            background: var(--accent-glow);
            color: var(--accent-bright);
        }

        .sidebar-link svg { flex-shrink: 0; opacity: 0.7; }
        .sidebar-link.active svg { opacity: 1; }

        .sidebar-badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.1rem 0.45rem;
            border-radius: 10px;
            font-family: 'JetBrains Mono', monospace;
        }

        .sidebar-badge-alert {
            background: var(--rose-glow);
            color: var(--rose);
        }

        .sidebar-badge-count {
            background: var(--bg-elevated);
            color: var(--text-muted);
        }

        .sidebar-topic {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.78rem;
            transition: all 0.15s ease;
        }

        .sidebar-topic:hover {
            background: var(--bg-card);
            color: var(--text-primary);
        }

        .topic-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border-subtle);
        }

        .scan-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .scan-pulse {
            width: 8px;
            height: 8px;
            background: var(--emerald);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            50% { opacity: 0.7; box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(10, 13, 18, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0 1.5rem;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }

        .topbar-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .topbar-breadcrumb a:hover { color: var(--text-secondary); }
        .topbar-breadcrumb svg { color: var(--text-muted); opacity: 0.5; }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.25rem;
        }

        .content-area {
            padding: 1.5rem;
            max-width: 1400px;
        }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .card:hover { border-color: var(--border-active); }

        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .card-body { padding: 1rem 1.25rem; }

        /* Stats */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 1.15rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
        }

        .stat-card-accent::before { background: var(--accent); }
        .stat-card-emerald::before { background: var(--emerald); }
        .stat-card-amber::before { background: var(--amber); }
        .stat-card-rose::before { background: var(--rose); }
        .stat-card-cyan::before { background: var(--cyan); }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .stat-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .stat-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Grids */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .grid-sidebar {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.15rem 0.55rem;
            border-radius: 5px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge-accent { background: var(--accent-glow); color: var(--accent-bright); }
        .badge-emerald { background: var(--emerald-glow); color: var(--emerald); }
        .badge-amber { background: var(--amber-glow); color: var(--amber); }
        .badge-rose { background: var(--rose-glow); color: var(--rose); }
        .badge-cyan { background: var(--cyan-glow); color: var(--cyan); }
        .badge-violet { background: rgba(139, 92, 246, 0.12); color: var(--violet); }
        .badge-orange { background: rgba(249, 115, 22, 0.12); color: var(--orange); }
        .badge-slate { background: var(--bg-elevated); color: var(--text-muted); }
        .badge-blue { background: var(--accent-glow); color: var(--accent-bright); }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-sm { padding: 0.3rem 0.7rem; font-size: 0.72rem; }

        .btn-primary {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .btn-primary:hover { background: var(--accent-bright); }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border-color: var(--border-subtle);
        }

        .btn-ghost:hover {
            background: var(--bg-card);
            color: var(--text-primary);
            border-color: var(--border-active);
        }

        /* Breaking News Banner */
        .breaking-banner {
            background: linear-gradient(135deg, var(--rose-glow), rgba(244, 63, 94, 0.03));
            border: 1px solid rgba(244, 63, 94, 0.2);
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .breaking-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--rose);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .breaking-dot {
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Article Cards */
        .article-card {
            display: block;
            text-decoration: none;
            color: inherit;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-subtle);
            transition: all 0.15s ease;
        }

        .article-card:last-child { border-bottom: none; }
        .article-card:hover { padding-left: 0.5rem; }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .article-title {
            font-weight: 600;
            font-size: 0.88rem;
            line-height: 1.4;
            margin-bottom: 0.3rem;
        }

        .article-excerpt {
            font-size: 0.78rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Sentiment Bar */
        .sentiment-bar {
            display: flex;
            height: 4px;
            border-radius: 2px;
            overflow: hidden;
            background: var(--bg-elevated);
        }

        .sentiment-positive { background: var(--emerald); }
        .sentiment-neutral { background: var(--amber); }
        .sentiment-negative { background: var(--rose); }

        /* Alert Item */
        .alert-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-subtle);
        }

        .alert-item:last-child { border-bottom: none; }

        .alert-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .alert-icon-rose { background: var(--rose-glow); }
        .alert-icon-amber { background: var(--amber-glow); }
        .alert-icon-cyan { background: var(--cyan-glow); }

        /* Source Bar */
        .source-bar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .source-bar-fill {
            flex: 1;
            height: 6px;
            background: var(--bg-elevated);
            border-radius: 3px;
            overflow: hidden;
        }

        .source-bar-fill-inner {
            height: 100%;
            border-radius: 3px;
            background: var(--accent);
            transition: width 0.5s ease;
        }

        /* Scan Feed */
        .scan-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border-subtle);
            font-size: 0.78rem;
        }

        .scan-item:last-child { border-bottom: none; }

        .scan-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .data-table th {
            text-align: left;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .data-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-secondary);
        }

        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: var(--bg-card-hover); }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.25rem;
            list-style: none;
        }

        .pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 0.5rem;
            border-radius: 6px;
            border: 1px solid var(--border-subtle);
            background: var(--bg-card);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.78rem;
        }

        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /* GSAP Reveal */
        body.gsap-ready .reveal { visibility: hidden; }

        /* Responsive */
        @media (max-width: 1024px) {
            .grid-sidebar { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">
    @yield('body')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script>
        document.body.classList.add('gsap-ready');
        gsap.registerPlugin(ScrollTrigger);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.reveal').forEach((el, i) => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    gsap.fromTo(el,
                        { autoAlpha: 0, y: 20 },
                        { autoAlpha: 1, y: 0, duration: 0.5, delay: i * 0.06, ease: 'power2.out' }
                    );
                } else {
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 90%',
                        once: true,
                        onEnter: () => {
                            gsap.fromTo(el,
                                { autoAlpha: 0, y: 20 },
                                { autoAlpha: 1, y: 0, duration: 0.5, ease: 'power2.out' }
                            );
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
