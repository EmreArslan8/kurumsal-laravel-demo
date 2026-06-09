@extends('layouts.admin')

@section('title', 'Entegrasyon Haritasi')

@section('content')
    <section class="stat-grid integration-summary" aria-label="HTML to Laravel CMS integration steps">
        <div>
            <span>01</span>
            <strong>HTML</strong>
            <p>Hazir statik sayfa teslim alinir.</p>
        </div>
        <div>
            <span>02</span>
            <strong>Assets</strong>
            <p>CSS, JS ve medya dosyalari public altina kopyalanir.</p>
        </div>
        <div>
            <span>03</span>
            <strong>Blade</strong>
            <p>Sabit alanlar Blade placeholder yapisina tasinir.</p>
        </div>
        <div>
            <span>04</span>
            <strong>Admin</strong>
            <p>Panel alanlari frontend metinlerini ve gorselleri gunceller.</p>
        </div>
        <div>
            <span>05</span>
            <strong>i18n</strong>
            <p>Ceviriler ve formlar Laravel tablolarina baglanir.</p>
        </div>
    </section>

    <section class="admin-section integration-overview">
        <div class="section-heading">
            <div>
                <h2>Hazir Tasarimdan CMS Kontrolune</h2>
                <p>Musteri 16 sayfanin HTML/CSS/JS dosyalarini teslim eder; biz tasarimi yeniden uretmeyiz, dosyalari Laravel Blade ve CMS alanlarina baglariz.</p>
            </div>
        </div>

        <div class="integration-preview-links">
            <a class="button primary compact" href="{{ asset('client-html-demo/index.html') }}" target="_blank" rel="noreferrer">
                Ornek Ham HTML
            </a>
            <a class="button ghost compact" href="{{ route('site.client-demo', ['locale' => 'tr']) }}" target="_blank" rel="noreferrer">
                Ornek Laravel Baglantisi
            </a>
        </div>

        <div class="path-list">
            <code>{{ $sampleHtmlPath }}</code>
            <code>{{ $sampleCssPath }}</code>
            <code>{{ $sampleJsPath }}</code>
        </div>

        <div class="two-column integration-code-grid">
            <article class="integration-code-card">
                <h3>Statik teslimat</h3>
                <pre><code>&lt;h1&gt;Kurumsal baslik&lt;/h1&gt;
&lt;img src="/assets/hero.jpg" alt=""&gt;
&lt;p&gt;Sayfa metni&lt;/p&gt;
&lt;button&gt;Teklif Al&lt;/button&gt;</code></pre>
                <p>Tasarim dili, class isimleri, JS davranislari ve medya klasoru once ayni sekilde calisir hale getirilir.</p>
            </article>

            <article class="integration-code-card">
                <h3>Laravel CMS karsiligi</h3>
                <pre><code>&lt;h1&gt;&#123;&#123; $pageTranslation-&gt;title &#125;&#125;&lt;/h1&gt;
&lt;span style="background-image: url('&#123;&#123; $page-&gt;image_url &#125;&#125;')"&gt;&lt;/span&gt;
&#123;!! nl2br(e($pageTranslation-&gt;body)) !!&#125;
&lt;button&gt;&#123;&#123; $t('cta.offer') &#125;&#125;&lt;/button&gt;</code></pre>
                <p>Admin panelde kaydedilen veri render aninda Blade tarafindan statik tasarimin ilgili noktasina yerlestirilir.</p>
            </article>
        </div>
    </section>

    <section class="admin-section integration-delivery">
        <div class="section-heading">
            <div>
                <h2>16 HTML Teslim Matrisi</h2>
                <p>Gercek projede bu listedeki her sayfa icin musterinin verdigi HTML dosyasi kaynak alinir. Dosya adi degisebilir; onemli olan hangi HTML'in hangi Laravel sayfa kaydina baglanacaginin netlesmesidir.</p>
            </div>
        </div>

        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Laravel slug</th>
                        <th>Beklenen HTML</th>
                        <th>Sayfa tipi</th>
                        <th>Panelden baglanacak alanlar</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        @php
                            $translation = $page->translations->first();
                            $expectedFile = $page->slug === 'home' ? 'index.html' : $page->slug.'.html';
                            $sampleExists = file_exists(base_path('client-html-demo/'.$expectedFile));
                            $fields = match ($page->type) {
                                'landing' => 'Hero, metrikler, vitrin bloklari, CTA',
                                'listing' => 'Liste kartlari, filtre alanlari, gorseller, SEO',
                                'detail' => 'Detay hero, uzun icerik, galeri, CTA',
                                'form' => 'Form etiketleri, validasyon, kayit, mail',
                                'media' => 'Galeri grid, medya gorselleri, siralama',
                                default => 'Baslik, spot, icerik, hero gorsel, SEO',
                            };
                        @endphp
                        <tr>
                            <td>{{ $page->sort_order }}</td>
                            <td><code>{{ $page->slug }}</code><br><small>{{ $translation?->menu_title }}</small></td>
                            <td><code>client-html-demo/{{ $expectedFile }}</code></td>
                            <td>{{ $page->type }}</td>
                            <td>{{ $fields }}</td>
                            <td>{{ $sampleExists ? 'Ornek dosya var' : 'Musteriden beklenecek' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-section integration-flow">
        <div class="section-heading">
            <div>
                <h2>Entegrasyon Akisi</h2>
                <p>Her adim statik dosyadan dinamik CMS davranisina kontrollu bir gecis saglar.</p>
            </div>
        </div>

        <ol class="integration-steps">
            <li class="integration-step">
                <span class="integration-step-number">1</span>
                <div>
                    <h3>Static HTML delivered</h3>
                    <p>Hazir HTML yapisi once mevcut tasarim siniflari, bolum sirasi ve kullanici arayuzu korunarak Laravel view yapisina alinir.</p>
                </div>
            </li>
            <li class="integration-step">
                <span class="integration-step-number">2</span>
                <div>
                    <h3>Assets copied to public</h3>
                    <p>CSS, JS, font ve gorseller <code>public</code> altina tasinir; Blade icinde <code>asset()</code> ile cagirilir.</p>
                </div>
            </li>
            <li class="integration-step">
                <span class="integration-step-number">3</span>
                <div>
                    <h3>Blade placeholders inserted</h3>
                    <p>Sabit baslik, metin, gorsel ve CTA alanlari <code>$page</code>, <code>$pageTranslation</code> ve ceviri yardimcilariyla degistirilir.</p>
                </div>
            </li>
            <li class="integration-step">
                <span class="integration-step-number">4</span>
                <div>
                    <h3>Admin fields update frontend</h3>
                    <p>Panelde kaydedilen slug, yayin durumu, hero gorseli, baslik, spot metin, icerik ve SEO alanlari frontend cikisini besler.</p>
                </div>
            </li>
            <li class="integration-step">
                <span class="integration-step-number">5</span>
                <div>
                    <h3>Translations and forms</h3>
                    <p>Buton ve form etiketleri <code>translation_entries</code> tablosundan gelir; form gonderimleri <code>contact_messages</code> kaydi ve mail bildirimi uretir.</p>
                </div>
            </li>
        </ol>
    </section>

    <section class="admin-section integration-mapping">
        <div class="section-heading">
            <div>
                <h2>Alan Esleme Tablosu</h2>
                <p>Statik HTML icindeki secili alanlar Laravel CMS tarafindaki veri kaynagina asagidaki gibi baglanir.</p>
            </div>
        </div>

        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>Statik alan</th>
                        <th>CMS karsiligi</th>
                        <th>Panel kaynagi</th>
                        <th>Frontend etkisi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>&lt;h1&gt;</code></td>
                        <td><code>pageTranslation.title</code></td>
                        <td>Sayfa duzenleme ekranindaki dil bazli sayfa basligi.</td>
                        <td>Hero veya icerik basligi her dil icin ayri render edilir.</td>
                    </tr>
                    <tr>
                        <td><code>&lt;img&gt;</code></td>
                        <td><code>page.image_url</code></td>
                        <td>Sayfanin ortak hero gorsel URL alani.</td>
                        <td>Gorsel yolu panelden degisince frontend medya alani guncellenir.</td>
                    </tr>
                    <tr>
                        <td><code>&lt;p&gt;</code></td>
                        <td><code>body</code></td>
                        <td>Dil bazli icerik metni.</td>
                        <td>Paragraf ve uzun icerik bloklari Blade ile guvenli bicimde basilir.</td>
                    </tr>
                    <tr>
                        <td>Button labels</td>
                        <td><code>translation_entries</code></td>
                        <td>Ceviri sozlugundeki CTA ve form anahtarlari.</td>
                        <td>Ayni buton class'i korunur, metin aktif dile gore degisir.</td>
                    </tr>
                    <tr>
                        <td><code>&lt;form&gt;</code></td>
                        <td><code>contact_messages + mail</code></td>
                        <td>Iletisim ve teklif formu gonderimleri.</td>
                        <td>Gonderim veritabanina kaydedilir ve Laravel mail akisi tetiklenir.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-section two-column integration-layers">
        <div>
            <h2>Ceviri Katmani</h2>
            <p>Statik arayuzde sabit gorunen menu, buton, form etiketi ve sistem mesajlari key tabanli sozluge tasinir.</p>
            <div class="scope-list">
                <span><code>cta.offer</code></span>
                <span><code>cta.contact</code></span>
                <span><code>form.name</code></span>
                <span><code>form.submit</code></span>
                <span><code>section.contact_text</code></span>
            </div>
        </div>

        <div>
            <h2>Form Katmani</h2>
            <p>Statik form HTML'i ayni kalir; Laravel tarafinda CSRF, validasyon, kayit ve mail bildirimi eklenir.</p>
            <div class="scope-list">
                <span>CSRF</span>
                <span>Validation</span>
                <span><code>contact_messages</code></span>
                <span>Mail log</span>
                <span>Admin inbox</span>
            </div>
        </div>
    </section>
@endsection
