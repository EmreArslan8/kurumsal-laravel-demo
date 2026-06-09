@extends('layouts.admin')

@section('title', 'Mesaj Detayi')

@section('content')
    <section class="admin-section message-detail">
        <a class="table-action" href="{{ route('admin.messages.index') }}">Geri Don</a>
        <h2>{{ $message->subject ?: 'Iletisim Formu' }}</h2>
        <dl>
            <div><dt>Ad</dt><dd>{{ $message->name }}</dd></div>
            <div><dt>E-posta</dt><dd>{{ $message->email }}</dd></div>
            <div><dt>Telefon</dt><dd>{{ $message->phone ?: '-' }}</dd></div>
            <div><dt>Firma</dt><dd>{{ $message->company ?: '-' }}</dd></div>
            <div><dt>Dil</dt><dd>{{ strtoupper($message->locale) }}</dd></div>
            <div><dt>Tarih</dt><dd>{{ $message->created_at->format('d.m.Y H:i') }}</dd></div>
        </dl>
        <article>{{ $message->message }}</article>
    </section>
@endsection
