<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERDICT | Cognitive Infrastructure</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        @import url('/app.css');
        /* Inline fallback if needed or link to the asset */
    </style>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>

<body>
    <div class="app-container">
        <header class="animate-fade">
            <div class="logo">VER<span>DICT</span></div>
            <nav>
                <a href="{{ route('timeline') }}"
                    class="{{ request()->routeIs('timeline') ? 'active' : '' }}">Timeline</a>
                <a href="{{ route('ledger') }}" class="{{ request()->routeIs('ledger') ? 'active' : '' }}">Memory</a>
                <a href="#" style="opacity: 0.5; cursor: not-allowed;">Integrations</a>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    <script>
        // Micro-animations or dynamic effects
    </script>
</body>

</html>