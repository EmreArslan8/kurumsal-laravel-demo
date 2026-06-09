@extends('layouts.admin')

@section('title', 'Diller')

@section('content')
    <section class="admin-section">
        <h2>Yeni Dil Ekle</h2>
        <form class="form-grid" method="post" action="{{ route('admin.languages.store') }}">
            @csrf
            <label>
                <span>Dil adi</span>
                <input name="name" placeholder="Deutsch" required>
            </label>
            <label>
                <span>Kod</span>
                <input name="code" placeholder="de" required>
            </label>
            <label>
                <span>Yazim yonu</span>
                <select name="direction">
                    <option value="ltr">LTR</option>
                    <option value="rtl">RTL</option>
                </select>
            </label>
            <label>
                <span>Siralama</span>
                <input type="number" name="sort_order" value="{{ $languages->count() + 1 }}" min="0" required>
            </label>
            <label class="check-row">
                <input type="checkbox" name="is_active" value="1" checked>
                <span>Aktif</span>
            </label>
            <label class="check-row">
                <input type="checkbox" name="is_default" value="1">
                <span>Varsayilan</span>
            </label>
            <button class="button primary compact" type="submit">Dil Ekle</button>
        </form>
    </section>

    <section class="admin-section">
        <h2>Kayitli Diller</h2>
        <div class="language-editor">
            @foreach($languages as $language)
                <form method="post" action="{{ route('admin.languages.update', $language) }}">
                    @csrf
                    @method('PUT')
                    <input name="name" value="{{ $language->name }}" required>
                    <input name="code" value="{{ $language->code }}" required>
                    <select name="direction">
                        <option value="ltr" @selected($language->direction === 'ltr')>LTR</option>
                        <option value="rtl" @selected($language->direction === 'rtl')>RTL</option>
                    </select>
                    <input type="number" name="sort_order" value="{{ $language->sort_order }}" min="0" required>
                    <label class="check-row">
                        <input type="checkbox" name="is_active" value="1" @checked($language->is_active)>
                        <span>Aktif</span>
                    </label>
                    <label class="check-row">
                        <input type="checkbox" name="is_default" value="1" @checked($language->is_default)>
                        <span>Default</span>
                    </label>
                    <button class="table-action" type="submit">Kaydet</button>
                </form>
            @endforeach
        </div>
    </section>
@endsection
