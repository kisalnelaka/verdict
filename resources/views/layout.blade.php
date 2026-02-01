<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERDICT | Cognitive Infrastructure</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=JetBrains+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Asset fallback helper */
        body {
            background-color: #0a0a0c;
            color: #e4e4e7;
        }
    </style>
</head>

<body>
    <div class="app-container">
        <nav class="glass nav-bar">
            <div class="logo">VER<span>DICT</span></div>
            <div class="nav-links">
                <a href="{{ route('timeline') }}"
                    class="nav-link {{ request()->routeIs('timeline') ? 'active' : '' }}">Timeline</a>
                <a href="{{ route('ledger') }}"
                    class="nav-link {{ request()->routeIs('ledger') ? 'active' : '' }}">Memory</a>
                <a href="{{ route('system.actions') }}"
                    class="nav-link {{ request()->routeIs('system.actions') ? 'active' : '' }}"
                    style="color: var(--accent-cyber);">Cockpit</a>
            </div>
            <a href="{{ route('decisions.create') }}" class="btn btn-new">+ New Intent</a>
        </nav>

        <main class="content-area">
            @if(session('success'))
                <div class="glass alert alert-success animate-fade">
                    <div
                        style="color: var(--accent-toxic); font-weight: 800; font-size: 0.7rem; text-transform: uppercase; margin-bottom: 0.2rem;">
                        Operation Success</div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="glass alert alert-error animate-fade">
                    <div
                        style="color: var(--accent-crimson); font-weight: 800; font-size: 0.7rem; text-transform: uppercase; margin-bottom: 0.2rem;">
                        System Alert</div>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer
            style="text-align: center; margin-top: 4rem; padding-bottom: 4rem; opacity: 0.3; font-size: 0.7rem; letter-spacing: 2px;">
            VERDICT // COGNITIVE_GOVERNANCE_ENGINE // {{ date('Y') }}
        </footer>
    </div>
</body>

</html>