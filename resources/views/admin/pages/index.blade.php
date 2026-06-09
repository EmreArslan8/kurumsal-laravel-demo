@extends('layouts.admin')

@section('title', 'Sayfalar')

@section('content')
    <section class="admin-section">
        <div class="section-heading">
            <div>
                <h2>Sayfa Yonetimi</h2>
                <p>Demo 16 sayfa uzerinden calisir. Her sayfada tum diller icin ayri icerik vardir.</p>
            </div>
        </div>

        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>Sirasi</th>
                        <th>Sayfa</th>
                        <th>Slug</th>
                        <th>Tip</th>
                        <th>Durum</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        @php $translation = $page->translations->first(); @endphp
                        <tr>
                            <td>{{ $page->sort_order }}</td>
                            <td>{{ $translation?->title ?: $page->slug }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->type }}</td>
                            <td>{{ $page->is_published ? 'Yayinda' : 'Kapali' }}</td>
                            <td><a class="table-action" href="{{ route('admin.pages.edit', $page) }}">Duzenle</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
