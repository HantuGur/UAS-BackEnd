@extends('layouts.app')
@section('title', 'Daftar Menu - RestoUAS')
@section('content')
<div class="header">
    <h1> Daftar Menu Restoran</h1>
    <a href="{{ route('menus.create') }}" class="btn btn-primary">+ Tambah Menu Baru</a>
</div>
<div class="card">
    @if ($menus->isEmpty())
        <p style="color:var(--text-muted);text-align:center;padding:20px">Belum ada menu yang tersimpan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:60px;text-align:center">No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th style="width:180px;text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $menu->name }}</strong></td>
                    <td>{{ ucfirst($menu->category ?? 'Lainnya') }}</td>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td style="text-align:center">
                        <div style="display:flex;gap:8px;justify-content:center">
                            <a href="{{ route('menus.edit', $menu) }}" class="btn btn-secondary" style="padding:6px 12px;font-size:12px">Ubah</a>
                            <form action="{{ route('menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:12px">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection