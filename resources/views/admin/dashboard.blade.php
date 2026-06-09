@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <section class="stat-grid">
        <div><span>Sayfa</span><strong>{{ $pageCount }}</strong></div>
        <div><span>Dil</span><strong>{{ $languageCount }}</strong></div>
        <div><span>Medya</span><strong>{{ $mediaCount }}</strong></div>
        <div><span>Form Mesaji</span><strong>{{ $messageCount }}</strong></div>
        <div><span>Okunmamis</span><strong>{{ $unreadCount }}</strong></div>
    </section>

    <section class="admin-section two-column">
        <div>
            <h2>Demo Kapsami</h2>
            <div class="scope-list">
                <span>16 sayfa</span>
                <span>Coklu dil</span>
                <span>Dil sekmeli icerik</span>
                <span>Statik ceviri sozlugu</span>
                <span>Form kaydi</span>
                <span>Mail log bildirimi</span>
            </div>
            <p>
                Hazir HTML'in Laravel CMS'e nasil baglandigini gormek icin
                <a class="inline-link" href="{{ route('admin.integration.show') }}">HTML entegrasyon akisina</a>
                bakabilirsiniz.
            </p>
        </div>

        <div>
            <h2>Son Mesajlar</h2>
            <div class="message-list">
                @forelse($latestMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}">
                        <strong>{{ $message->name }}</strong>
                        <span>{{ $message->subject ?: $message->email }}</span>
                    </a>
                @empty
                    <p>Henuz mesaj yok.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
