@extends('layouts.admin')

@section('title', 'Ceviri Sozlugu')

@section('content')
    <form class="admin-section" method="post" action="{{ route('admin.translations.update') }}">
        @csrf
        @method('PUT')

        <div class="section-heading">
            <div>
                <h2>Statik Kelimeler</h2>
                <p>Menu, buton, form etiketi ve sistem metinleri buradan dil bazli yonetilir.</p>
            </div>
            <button class="button primary compact" type="submit">Cevirileri Kaydet</button>
        </div>

        <div class="translation-table">
            <table>
                <thead>
                    <tr>
                        <th>Anahtar</th>
                        @foreach($languages as $language)
                            <th>{{ strtoupper($language->code) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $key => $rows)
                        <tr>
                            <td><code>{{ $key }}</code></td>
                            @foreach($languages as $language)
                                @php $entry = $rows->firstWhere('language_id', $language->id); @endphp
                                <td>
                                    <input name="entries[{{ $key }}][{{ $language->id }}]" value="{{ $entry?->value }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection
