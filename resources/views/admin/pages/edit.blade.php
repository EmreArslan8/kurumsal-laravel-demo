@extends('layouts.admin')

@section('title', 'Sayfa Duzenle')

@section('content')
    <form class="admin-section edit-form" method="post" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="section-heading">
            <div>
                <h2>{{ $page->slug }}</h2>
                <p>Genel alanlar tum diller icin ortaktir, metin alanlari dil sekmelerinden yonetilir.</p>
            </div>
            <button class="button primary compact" type="submit">Kaydet</button>
        </div>

        <div class="form-grid">
            <label>
                <span>Slug</span>
                <input name="slug" value="{{ old('slug', $page->slug) }}" required>
            </label>
            <label>
                <span>Tip</span>
                <input name="type" value="{{ old('type', $page->type) }}" required>
            </label>
            <label>
                <span>Siralama</span>
                <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0" required>
            </label>
            <label class="check-row">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published))>
                <span>Yayinda</span>
            </label>
            <label class="wide">
                <span>Hero gorsel URL</span>
                <input name="image_url" value="{{ old('image_url', $page->image_url) }}">
            </label>
            <label>
                <span>Medya kutuphanesinden sec</span>
                <select name="selected_media_url">
                    <option value="">Mevcut URL kalsin</option>
                    @foreach($mediaAssets as $media)
                        <option value="{{ $media->url }}" @selected(old('selected_media_url', $page->image_url) === $media->url)>
                            {{ $media->original_name }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label>
                <span>Yeni hero gorsel yukle</span>
                <input type="file" name="hero_image" accept="image/*">
            </label>
        </div>

        <div class="tabs" data-tabs>
            <div class="tab-buttons" role="tablist">
                @foreach($languages as $language)
                    <button type="button" class="{{ $loop->first ? 'active' : '' }}" data-tab-button="page-lang-{{ $language->id }}">
                        {{ strtoupper($language->code) }}
                    </button>
                @endforeach
            </div>

            @foreach($languages as $language)
                @php $translation = $page->translations->firstWhere('language_id', $language->id); @endphp
                <section class="tab-panel {{ $loop->first ? 'active' : '' }}" data-tab-panel="page-lang-{{ $language->id }}">
                    <div class="form-grid">
                        <label>
                            <span>Menu basligi</span>
                            <input name="translations[{{ $language->id }}][menu_title]" value="{{ old("translations.{$language->id}.menu_title", $translation?->menu_title) }}">
                        </label>
                        <label>
                            <span>Sayfa basligi</span>
                            <input name="translations[{{ $language->id }}][title]" value="{{ old("translations.{$language->id}.title", $translation?->title) }}">
                        </label>
                        <label class="wide">
                            <span>Spot metin</span>
                            <input name="translations[{{ $language->id }}][subtitle]" value="{{ old("translations.{$language->id}.subtitle", $translation?->subtitle) }}">
                        </label>
                        <label class="wide">
                            <span>Icerik</span>
                            <textarea name="translations[{{ $language->id }}][body]" rows="8">{{ old("translations.{$language->id}.body", $translation?->body) }}</textarea>
                        </label>
                        <label>
                            <span>Meta baslik</span>
                            <input name="translations[{{ $language->id }}][meta_title]" value="{{ old("translations.{$language->id}.meta_title", $translation?->meta_title) }}">
                        </label>
                        <label>
                            <span>Meta aciklama</span>
                            <textarea name="translations[{{ $language->id }}][meta_description]" rows="3">{{ old("translations.{$language->id}.meta_description", $translation?->meta_description) }}</textarea>
                        </label>
                    </div>
                </section>
            @endforeach
        </div>
    </form>
@endsection
