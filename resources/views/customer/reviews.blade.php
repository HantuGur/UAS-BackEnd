@extends('layouts.customer')
@section('title', 'Tulis Ulasan Menu - Resto 3D')
@section('content')

<div class="card" style="max-width: 500px; margin: 30px auto; border: 1px solid var(--border-color);">
    <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 6px; color: var(--navy-primary);">⭐ Tulis Ulasan Menu</h2>
    <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 24px;">Berikan penilaian Anda untuk menu: <strong>{{ $menu->name }}</strong></p>

    <form action="{{ route('customer.review.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

        <!-- Star Rating Input -->
        <div class="form-group">
            <label style="font-weight: 600; display: block; margin-bottom: 12px;">Penilaian Rasa & Kualitas</label>
            <div style="display: flex; gap: 10px; font-size: 28px; cursor: pointer;" id="starRatingContainer">
                <span class="star-item" onclick="setRating(1)" data-val="1" style="color: #ccc;">★</span>
                <span class="star-item" onclick="setRating(2)" data-val="2" style="color: #ccc;">★</span>
                <span class="star-item" onclick="setRating(3)" data-val="3" style="color: #ccc;">★</span>
                <span class="star-item" onclick="setRating(4)" data-val="4" style="color: #ccc;">★</span>
                <span class="star-item" onclick="setRating(5)" data-val="5" style="color: #ccc;">★</span>
            </div>
            <input type="hidden" name="rating" id="ratingInput" value="5" required>
            @error('rating') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label for="comment" style="font-weight: 600;">Ulasan / Komentar</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Bagaimana rasa hidangan ini? Apa masukan untuk dapur kami..." style="resize: none;"></textarea>
            @error('comment') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-navy" style="width: 100%; padding: 12px; font-size: 15px; border-radius: 4px; margin-top: 10px;">
            Kirim Ulasan Saya
        </button>
    </form>
</div>

<script>
    function setRating(val) {
        document.getElementById('ratingInput').value = val;
        const stars = document.querySelectorAll('.star-item');
        stars.forEach((star, idx) => {
            if (idx < val) {
                star.style.color = '#ffc107'; // gold
            } else {
                star.style.color = '#ccc'; // grey
            }
        });
    }

    // Set initial rating to 5 stars
    document.addEventListener('DOMContentLoaded', function() {
        setRating(5);
    });
</script>

@endsection
