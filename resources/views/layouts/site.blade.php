<!doctype html>
<html lang="{{ $language->code }}" dir="{{ $language->direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTranslation->meta_title ?: $pageTranslation->title }}</title>
    <meta name="description" content="{{ $pageTranslation->meta_description }}">
    <link rel="stylesheet" href="{{ asset('assets/demo.css') }}">
</head>
<body class="site-shell">
    @php
        $t = fn (string $key, ?string $fallback = null) => $ui[$key] ?? $fallback ?? $key;
    @endphp

    <header class="site-header">
        <a class="brand-mark" href="{{ route('site.home', ['locale' => $language->code]) }}">
            <span class="brand-symbol"></span>
            <span>NovaKurumsal</span>
        </a>

        <nav class="site-nav" aria-label="Main navigation">
            @foreach($menuPages as $menuPage)
                @php $menuTranslation = $menuPage->translations->first(); @endphp
                @if($menuTranslation)
                    <a href="{{ $menuPage->slug === 'home' ? route('site.home', ['locale' => $language->code]) : route('site.page', ['locale' => $language->code, 'slug' => $menuPage->slug]) }}">
                        {{ $menuTranslation->menu_title }}
                    </a>
                @endif
            @endforeach
        </nav>

        <div class="header-actions">
            <div class="language-switcher" aria-label="{{ $t('nav.language', 'Dil') }}">
                @foreach($languages as $availableLanguage)
                    <a class="{{ $availableLanguage->id === $language->id ? 'active' : '' }}"
                       href="{{ $page->slug === 'home' ? route('site.home', ['locale' => $availableLanguage->code]) : route('site.page', ['locale' => $availableLanguage->code, 'slug' => $page->slug]) }}">
                        {{ strtoupper($availableLanguage->code) }}
                    </a>
                @endforeach
            </div>
            <a class="icon-link" href="{{ route('admin.dashboard') }}">{{ $t('nav.panel', 'Panel') }}</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div>
            <strong>NovaKurumsal</strong>
            <span>{{ $t('footer.copy', 'Laravel kurumsal CMS demo') }}</span>
        </div>
        <a href="{{ route('site.page', ['locale' => $language->code, 'slug' => 'teklif-al']) }}">{{ $t('cta.offer', 'Teklif Al') }}</a>
    </footer>

    <script src="{{ asset('assets/demo.js') }}" defer></script>
</body>
</html>
