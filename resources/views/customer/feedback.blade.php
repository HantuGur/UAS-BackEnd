```html
@extends('layouts.customer')
@section('title', 'Kirim Aduan - Resto 3D')
@section('content')
<div class="card" style="max-width:600px; margin:0 auto;">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">💬 Kirim Aduan</h2>
    <form action="{{ route('customer.feedback.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:16px;">
            <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Subjek Aduan</label>
            <input type="text" name="subject" class="form-control" placeholder="Misal: Makanan terlambat datang" required>
        </div>
        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Pesan Lengkap</label>
            <textarea name="message" class="form-control" rows="5" placeholder="Ceritakan pengalaman Anda..." required style="resize:vertical;"></textarea>
        </div>
        <button type="submit" class="btn btn-navy" style="width:100%; padding:12px;">Kirim Aduan</button>
    </form>
</div>
@endsection