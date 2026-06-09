<!doctype html>
<html lang="{{ $language->code }}" dir="{{ $language->direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTranslation->meta_title ?: $pageTranslation->title }}</title>
    <meta name="description" content="{{ $pageTranslation->meta_description }}">
    <link rel="stylesheet" href="{{ asset('client-html-demo/assets/client-site.css') }}">
</head>
<body>
    @php
        $t = fn (string $key, ?string $fallback = null) => $ui[$key] ?? $fallback ?? $key;
    @endphp

    <a class="skip-link" href="#main">{{ $t('client.skip', 'Icerige gec') }}</a>

    <header class="site-header" data-site-header>
        <div class="header-inner">
            <a class="brand" href="{{ route('site.client-demo', ['locale' => $language->code]) }}" aria-label="{{ $t('client.home_aria', 'Kordis ana sayfa') }}">
                <span class="brand-mark" aria-hidden="true">K</span>
                <span>
                    <strong>Kordis</strong>
                    <small>Engineering Group</small>
                </span>
            </a>

            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav" data-nav-toggle>
                <span class="nav-toggle-lines" aria-hidden="true"></span>
                <span class="sr-only">{{ $t('client.menu_toggle', 'Menuyu ac veya kapat') }}</span>
            </button>

            <nav class="primary-nav" id="primary-nav" data-primary-nav>
                @foreach($menuPages as $menuPage)
                    @php $menuTranslation = $menuPage->translations->first(); @endphp
                    @if($menuTranslation)
                        <a href="{{ $menuPage->slug === 'home' ? route('site.client-demo', ['locale' => $language->code]) : route('site.page', ['locale' => $language->code, 'slug' => $menuPage->slug]) }}">
                            {{ $menuTranslation->menu_title }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="language-switcher" aria-label="{{ $t('client.language_label', 'Dil secimi') }}">
                @foreach($languages as $availableLanguage)
                    <a class="language-option {{ $availableLanguage->id === $language->id ? 'is-active' : '' }}"
                       data-language="{{ $availableLanguage->code }}"
                       aria-pressed="{{ $availableLanguage->id === $language->id ? 'true' : 'false' }}"
                       href="{{ route('site.client-demo', ['locale' => $availableLanguage->code]) }}">
                        <span class="language-dot {{ $availableLanguage->code === 'tr' ? 'tr' : 'en' }}" aria-hidden="true"></span>
                        {{ strtoupper($availableLanguage->code) }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <main id="main">
        <section class="hero hero-home">
            <!-- CMS:hero_image -> $page->image_url -->
            <div class="hero-art" aria-hidden="true" style="background-image: linear-gradient(124deg, rgba(21, 47, 79, .95), rgba(47, 93, 140, .78)), url('{{ $page->image_url }}'); background-size: cover; background-position: center;">
                <span class="hero-grid"></span>
                <span class="hero-tower one"></span>
                <span class="hero-tower two"></span>
                <span class="hero-tower three"></span>
                <span class="hero-route"></span>
            </div>

            <div class="hero-content">
                <p class="eyebrow">{{ $t('client.hero_eyebrow', 'Laravel CMS baglantili hazir HTML') }}</p>
                <!-- CMS:title -> $pageTranslation->title -->
                <h1>{{ $pageTranslation->title }}</h1>
                <p class="hero-copy">{{ $pageTranslation->subtitle }}</p>
                <div class="hero-actions">
                    <a class="button primary" href="#contact">{{ $t('client.cta.quote', 'Teklif Iste') }}</a>
                    <a class="button secondary" href="#projects">{{ $t('client.cta.projects', 'Projeleri Incele') }}</a>
                </div>
            </div>

            <aside class="hero-metrics" aria-label="{{ $t('client.metrics_aria', 'CMS entegrasyon ozeti') }}">
                <div>
                    <strong>18+</strong>
                    <span>{{ $t('client.metric.experience', 'yil saha deneyimi') }}</span>
                </div>
                <div>
                    <strong>42</strong>
                    <span>{{ $t('client.metric.facilities', 'teslim edilen tesis') }}</span>
                </div>
                <div>
                    <strong>7/24</strong>
                    <span>{{ $t('client.metric.support', 'operasyon destegi') }}</span>
                </div>
            </aside>
        </section>

        <section class="section intro-band" aria-labelledby="intro-title">
            <div class="section-inner intro-grid">
                <div>
                    <p class="eyebrow">{{ $t('client.intro_eyebrow', 'Statik tasarim + Laravel veri') }}</p>
                    <h2 id="intro-title">{{ $t('client.intro_title', 'Yonetim kurullari icin net raporlama, saha ekipleri icin uygulanabilir plan.') }}</h2>
                </div>
                <p>{!! nl2br(e($pageTranslation->body)) !!}</p>
            </div>
        </section>

        <section class="section" id="services" aria-labelledby="services-title">
            <div class="section-inner">
                <div class="section-heading">
                    <p class="eyebrow">{{ $t('client.services_eyebrow', 'Hizmet kapsamimiz') }}</p>
                    <h2 id="services-title">{{ $t('client.services_title', 'Planlama, uygulama ve isletme tarafinda tamamlayici disiplinler.') }}</h2>
                </div>

                <!-- CMS:services -> $servicePages collection -->
                <div class="service-grid">
                    @foreach(range(1, 4) as $serviceNumber)
                        <article class="service-card">
                            <span class="card-index">{{ str_pad((string) $serviceNumber, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3>{{ $t("client.service{$serviceNumber}.title") }}</h3>
                            <p>{{ $t("client.service{$serviceNumber}.text") }}</p>
                            <a href="#contact" aria-label="{{ $t('client.detail', 'Detay al') }}: {{ $t("client.service{$serviceNumber}.title") }}">{{ $t('client.detail', 'Detay al') }}</a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section projects-section" id="projects" aria-labelledby="projects-title">
            <div class="section-inner">
                <div class="section-heading split">
                    <div>
                        <p class="eyebrow">{{ $t('client.projects_eyebrow', 'Proje vitrinleri') }}</p>
                        <h2 id="projects-title">{{ $t('client.projects_title', 'Yuksek temasli sahalarda olculebilir teslimatlar.') }}</h2>
                    </div>
                    <a class="text-link" href="{{ route('site.page', ['locale' => $language->code, 'slug' => 'hakkimizda']) }}">{{ $t('client.projects_link', 'Yaklasimimizi okuyun') }}</a>
                </div>

                <div class="project-list">
                    @foreach(['steel', 'copper', 'green'] as $index => $tone)
                        @php $projectNumber = $index + 1; @endphp
                        <article class="project-highlight">
                            <div class="project-visual {{ $tone }}" aria-hidden="true"><span></span></div>
                            <div class="project-copy">
                                <p class="project-type">{{ $t("client.project{$projectNumber}.type") }}</p>
                                <h3>{{ $t("client.project{$projectNumber}.title") }}</h3>
                                <p>{{ $t("client.project{$projectNumber}.text") }}</p>
                            </div>
                            <dl class="project-facts">
                                <div>
                                    <dt>{{ $t("client.project{$projectNumber}.fact1.label") }}</dt>
                                    <dd>{{ $t("client.project{$projectNumber}.fact1.value") }}</dd>
                                </div>
                                <div>
                                    <dt>{{ $t("client.project{$projectNumber}.fact2.label") }}</dt>
                                    <dd>{{ $t("client.project{$projectNumber}.fact2.value") }}</dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section contact-section" id="contact" aria-labelledby="contact-title">
            <div class="section-inner contact-layout">
                <div class="contact-copy">
                    <p class="eyebrow">{{ $t('client.contact_eyebrow', 'Iletisim') }}</p>
                    <h2 id="contact-title">{{ $t('client.contact_title', 'Bir sonraki yatirim toplantisi icin teknik on degerlendirme hazirlayalim.') }}</h2>
                    <p>{{ $t('client.contact_text', 'Form gonderimi bu statik prototipte tarayici icinde simule edilir. Entegrasyonda alanlar CRM, e-posta veya Laravel form endpointine baglanabilir.') }}</p>
                    <ul class="contact-notes" aria-label="{{ $t('client.contact_notes_label', 'Iletisim notlari') }}">
                        <li>{{ $t('client.contact_note1', '48 saat icinde on gorusme') }}</li>
                        <li>{{ $t('client.contact_note2', 'Gizlilik sozlesmesiyle teknik dosya inceleme') }}</li>
                        <li>{{ $t('client.contact_note3', 'Turkce ve Ingilizce teklif seti') }}</li>
                    </ul>
                </div>

                <!-- CMS:contact_form -> route(site.contact.store), contact_messages, mail -->
                <form class="contact-form" action="{{ route('site.contact.store', ['locale' => $language->code]) }}" method="post">
                    @csrf

                    @if(session('status'))
                        <p class="form-status" role="status">{{ session('status') }}</p>
                    @endif

                    @if($errors->any())
                        <p class="form-status" role="alert">{{ $errors->first() }}</p>
                    @endif

                    <div class="form-row">
                        <label for="name">{{ $t('form.name', 'Ad Soyad') }}</label>
                        <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-row">
                        <label for="company">{{ $t('form.company', 'Firma') }}</label>
                        <input id="company" name="company" type="text" autocomplete="organization" value="{{ old('company') }}" required>
                    </div>
                    <div class="form-row two-column">
                        <div>
                            <label for="email">{{ $t('form.email', 'E-posta') }}</label>
                            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label for="phone">{{ $t('form.phone', 'Telefon') }}</label>
                            <input id="phone" name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="subject">{{ $t('client.interest', 'Ilgi alani') }}</label>
                        <select id="subject" name="subject">
                            <option value="">{{ $t('client.select_placeholder', 'Seciniz') }}</option>
                            <option value="{{ $t('client.option.planning', 'Tesis planlama') }}" @selected(old('subject') === $t('client.option.planning', 'Tesis planlama'))>{{ $t('client.option.planning', 'Tesis planlama') }}</option>
                            <option value="{{ $t('client.option.project', 'Proje yonetimi') }}" @selected(old('subject') === $t('client.option.project', 'Proje yonetimi'))>{{ $t('client.option.project', 'Proje yonetimi') }}</option>
                            <option value="{{ $t('client.option.energy', 'Enerji sistemleri') }}" @selected(old('subject') === $t('client.option.energy', 'Enerji sistemleri'))>{{ $t('client.option.energy', 'Enerji sistemleri') }}</option>
                            <option value="{{ $t('client.option.operations', 'Operasyon destegi') }}" @selected(old('subject') === $t('client.option.operations', 'Operasyon destegi'))>{{ $t('client.option.operations', 'Operasyon destegi') }}</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="message">{{ $t('form.message', 'Mesaj') }}</label>
                        <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    <label class="consent">
                        <input type="checkbox" name="consent" required>
                        <span>{{ $t('client.consent', 'Kisisel verilerimin teklif sureci icin islenmesini kabul ediyorum.') }}</span>
                    </label>
                    <button class="button primary full" type="submit">{{ $t('client.meeting_request', 'Gorusme Talep Et') }}</button>
                </form>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="section-inner footer-inner">
            <a class="brand footer-brand" href="{{ route('site.client-demo', ['locale' => $language->code]) }}" aria-label="{{ $t('client.home_aria', 'Kordis ana sayfa') }}">
                <span class="brand-mark" aria-hidden="true">K</span>
                <span>
                    <strong>Kordis</strong>
                    <small>Engineering Group</small>
                </span>
            </a>
            <p>{{ $t('client.footer_address', 'Maslak, Istanbul / info@kordis.example') }}</p>
            <p>&copy; <span data-year>{{ now()->year }}</span> {{ $t('client.footer_copy', 'Kordis. Demo HTML teslim dosyasi.') }}</p>
        </div>
    </footer>

    <script src="{{ asset('client-html-demo/assets/client-site.js') }}"></script>
</body>
</html>
