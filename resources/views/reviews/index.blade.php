@extends('layouts.admin')
@section('title', 'Ulasan Menu')
@section('content')
<div class="page-header"><h1 class="page-title">⭐ Ulasan Menu</h1></div>
<div class="card">
    <table>
        <thead><tr><th>Pelanggan</th><th>Menu</th><th>Rating</th><th>Komentar</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($reviews as $r)
            <tr>
                <td>{{ $r->customer->name }}</td><td>{{ $r->menu->name }}</td>
                <td>{{ str_repeat('⭐', $r->rating) }}</td>
                <td style="font-size:13px;">{{ $r->comment ?? '-' }}</td>
                <td>{{ $r->created_at->format('d M Y') }}</td>
                <td><form action="{{ route('reviews.destroy', $r) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection