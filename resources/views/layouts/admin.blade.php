<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel CMS Demo Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/demo.css') }}">
</head>
<body class="admin-shell">
    <aside class="admin-sidebar">
        <a class="brand-mark admin-brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-symbol"></span>
            <span>CMS Panel</span>
        </a>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.integration.show') }}">HTML Entegrasyon Akisi</a>
            <a href="{{ route('admin.pages.index') }}">Sayfalar</a>
            <a href="{{ route('admin.media.index') }}">Medya</a>
            <a href="{{ route('admin.languages.index') }}">Diller</a>
            <a href="{{ route('admin.translations.index') }}">Ceviriler</a>
            <a href="{{ route('admin.messages.index') }}">Form Mesajlari</a>
            <a href="{{ route('site.home', ['locale' => 'tr']) }}">Siteyi Ac</a>
        </nav>
    </aside>

    <section class="admin-main">
        <header class="admin-topbar">
            <div>
                <span class="eyebrow">Laravel demo</span>
                <h1>@yield('title', 'Yonetim Paneli')</h1>
            </div>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="button ghost compact" type="submit">Cikis</button>
            </form>
        </header>

        @if(session('status'))
            <div class="panel-status">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="panel-error">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </section>

    <script src="{{ asset('assets/demo.js') }}" defer></script>
</body>
</html>
