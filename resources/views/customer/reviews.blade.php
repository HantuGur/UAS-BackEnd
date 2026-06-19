@extends('layouts.customer')
@section('title', 'Beri Ulasan - Resto 3D')
@section('content')
<div class="card" style="max-width:500px; margin:0 auto;">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:8px;">⭐ Beri Ulasan</h2>
    <p style="color:var(--text-muted); margin-bottom:20px;">Menu: <strong>{{ $menu->name }}</strong></p>
    <form action="{{ route('customer.review.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        <div style="margin-bottom:16px;">
            <label style="display:block; font-weight:600; font-size:13px; margin-bottom:8px;">Rating</label>
            <div style="display:flex; gap:8px;">
                @for($i=1; $i<=5; $i++)
                <label style="cursor:pointer;"><input type="radio" name="rating" value="{{ $i }}" required> {{ $i }}⭐</label>
                @endfor
            </div>
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Komentar (Opsional)</label>
            <textarea name="comment" class="form-control" rows="4" placeholder="Bagikan pengalaman makan Anda..."></textarea>
        </div>
        <button type="submit" class="btn btn-navy" style="width:100%;">Kirim Ulasan</button>
    </form>
</div>
@endsection