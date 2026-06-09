@extends('layouts.admin')

@section('title', 'Form Mesajlari')

@section('content')
    <section class="admin-section">
        <h2>Gelen Kutusu</h2>
        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>Durum</th>
                        <th>Ad</th>
                        <th>E-posta</th>
                        <th>Konu</th>
                        <th>Tarih</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>{{ $message->is_read ? 'Okundu' : 'Yeni' }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->subject ?: '-' }}</td>
                            <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                            <td><a class="table-action" href="{{ route('admin.messages.show', $message) }}">Ac</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Henuz form mesaji yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-row">{{ $messages->links() }}</div>
    </section>
@endsection
