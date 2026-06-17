@extends('layouts.admin')
@section('title', 'Aduan Pelanggan')
@section('content')
<div class="page-header"><h1 class="page-title">💬 Aduan Pelanggan</h1></div>
<div class="card">
    <table>
        <thead><tr><th>Pelanggan</th><th>Subjek</th><th>Pesan</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($feedbacks as $f)
            <tr>
                <td>{{ $f->customer->name }}</td><td>{{ $f->subject }}</td>
                <td style="max-width:300px; word-break:break-word; font-size:13px;">{{ $f->message }}</td>
                <td>{{ $f->created_at->format('d M Y') }}</td>
                <td><form action="{{ route('feedbacks.destroy', $f) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection