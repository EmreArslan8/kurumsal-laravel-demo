@extends('layouts.site')

@section('content')
    @php
        $t = fn (string $key, ?string $fallback = null) => $ui[$key] ?? $fallback ?? $key;
        $isHome = $page->slug === 'home';
        $showContactForm = in_array($page->slug, ['iletisim', 'teklif-al'], true);
    @endphp

    <section class="hero-band">
        <div class="hero-media" style="background-image: url('{{ $page->image_url }}')"></div>
        <div class="hero-content">
            <p class="eyebrow">Laravel CMS</p>
            <h1>{{ $pageTranslation->title }}</h1>
            <p>{{ $pageTranslation->subtitle }}</p>
            <div class="hero-actions">
                <a class="button primary" href="{{ route('site.page', ['locale' => $language->code, 'slug' => 'teklif-al']) }}">{{ $t('cta.offer', 'Teklif Al') }}</a>
                <a class="button ghost" href="{{ route('site.page', ['locale' => $language->code, 'slug' => 'iletisim']) }}">{{ $t('cta.contact', 'Iletisime Gec') }}</a>
            </div>
        </div>
    </section>

    @if($isHome)
        <section class="metric-strip" aria-label="Demo metrics">
            <div><strong>16</strong><span>{{ $t('home.metrics.pages', '16 sayfa tasarimi') }}</span></div>
            <div><strong>∞</strong><span>{{ $t('home.metrics.languages', 'Sinirsiz dil yapisi') }}</span></div>
            <div><strong>100%</strong><span>{{ $t('home.metrics.panel', 'Tam panel kontrolu') }}</span></div>
        </section>

        <section class="content-band split-band">
            <div>
                <p class="eyebrow">{{ $t('section.featured', 'Dinamik alanlar') }}</p>
                <h2>{{ $pageTranslation->subtitle }}</h2>
            </div>
            <p>{{ $t('section.featured_text', 'Sayfa basliklari, gorseller, metinler, SEO alanlari ve sabit kelimeler panelden yonetilir.') }}</p>
        </section>

        <section class="feature-grid">
            @foreach($featuredPages as $featuredPage)
                @php $featuredTranslation = $featuredPage->translations->first(); @endphp
                @if($featuredTranslation)
                    <a class="feature-card" href="{{ route('site.page', ['locale' => $language->code, 'slug' => $featuredPage->slug]) }}">
                        <span class="card-image" style="background-image: url('{{ $featuredPage->image_url }}')"></span>
                        <span class="card-body">
                            <strong>{{ $featuredTranslation->title }}</strong>
                            <small>{{ $featuredTranslation->subtitle }}</small>
                        </span>
                    </a>
                @endif
            @endforeach
        </section>
    @else
        <section class="content-band article-layout">
            <aside>
                <span class="type-pill">{{ $page->type }}</span>
                <strong>{{ $page->slug }}</strong>
                <p>{{ $pageTranslation->meta_description }}</p>
            </aside>
            <article>
                {!! nl2br(e($pageTranslation->body)) !!}
            </article>
        </section>
    @endif

    @if($showContactForm)
        <section class="contact-band">
            <div>
                <p class="eyebrow">{{ $t('section.contact_title', 'Iletisim formu') }}</p>
                <h2>{{ $pageTranslation->title }}</h2>
                <p>{{ $t('section.contact_text', 'Gonderimler veritabanina kaydedilir ve mail bildirimi Laravel log mailer uzerinden uretilir.') }}</p>
            </div>

            <form class="contact-form" method="post" action="{{ route('site.contact.store', ['locale' => $language->code]) }}">
                @csrf

                @if(session('status'))
                    <div class="form-status">{{ session('status') }}</div>
                @endif

                <label>
                    <span>{{ $t('form.name', 'Ad Soyad') }}</span>
                    <input name="name" value="{{ old('name') }}" required>
                </label>
                <label>
                    <span>{{ $t('form.email', 'E-posta') }}</span>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label>
                    <span>{{ $t('form.phone', 'Telefon') }}</span>
                    <input name="phone" value="{{ old('phone') }}">
                </label>
                <label>
                    <span>{{ $t('form.company', 'Firma') }}</span>
                    <input name="company" value="{{ old('company') }}">
                </label>
                <label class="wide">
                    <span>{{ $t('form.subject', 'Konu') }}</span>
                    <input name="subject" value="{{ old('subject') }}">
                </label>
                <label class="wide">
                    <span>{{ $t('form.message', 'Mesaj') }}</span>
                    <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                </label>

                @if($errors->any())
                    <div class="form-error">{{ $errors->first() }}</div>
                @endif

                <button class="button primary" type="submit">{{ $t('form.submit', 'Gonder') }}</button>
            </form>
        </section>
    @endif
@endsection
