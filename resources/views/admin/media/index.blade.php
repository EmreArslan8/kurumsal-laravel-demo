@extends('layouts.admin')

@section('title', 'Medya Kutuphanesi')

@section('content')
    <section class="admin-section">
        <div class="section-heading">
            <div>
                <h2>Gorsel Yukle</h2>
                <p>Yuklenen gorseller <code>storage/app/public/media</code> altinda saklanir ve sayfa hero gorseli olarak secilebilir.</p>
            </div>
        </div>

        <form class="form-grid" method="post" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
            @csrf
            <label>
                <span>Gorsel dosyasi</span>
                <input type="file" name="file" accept="image/*" required>
            </label>
            <label>
                <span>Alt metin</span>
                <input name="alt_text" placeholder="Gorsel aciklamasi">
            </label>
            <button class="button primary compact" type="submit">Yukle</button>
        </form>
    </section>

    <section class="admin-section">
        <div class="section-heading">
            <div>
                <h2>Yuklenen Gorseller</h2>
                <p>Bu URL'ler sayfa duzenleme ekraninda hero gorsel olarak secilebilir.</p>
            </div>
        </div>

        <div class="media-grid">
            @forelse($mediaAssets as $media)
                <article class="media-card">
                    <img src="{{ $media->url }}" alt="{{ $media->alt_text ?: $media->original_name }}">
                    <div>
                        <strong>{{ $media->original_name }}</strong>
                        <code>{{ $media->url }}</code>
                        <small>{{ number_format($media->size / 1024, 1) }} KB</small>
                    </div>
                </article>
            @empty
                <p>Henuz medya yuklenmedi.</p>
            @endforelse
        </div>

        <div class="pagination-row">{{ $mediaAssets->links() }}</div>
    </section>
@endsection
