@extends('layouts.app')

@section('title', 'Your Favorites')

@section('styles')
<style>
    .hero-fav { height:40vh; display:flex; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; }
    .hero-title { font-size: calc(2rem + 3vw); font-weight:800; line-height:.85;
        background: linear-gradient(to right, var(--bright-red), var(--bright-yellow), var(--turquoise), var(--cyan));
        background-size: 300% auto; -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        animation: shine 5s linear infinite; }
    @keyframes shine { to { background-position: 300% center; } }
    .hero-subtitle { font-size:1.1rem; opacity:.6; letter-spacing:4px; margin-top:1.5rem; }
    
    .gallery-grid { display:grid; grid-template-columns: repeat(12, 1fr); gap:12px; }
    .gallery-card { position:relative; overflow:hidden; border-radius:4px; cursor:none; height: 350px; grid-column: span 4;}
    .gallery-img { width:100%; height:100%; object-fit:cover; transition: transform .6s cubic-bezier(.25,.46,.45,.94), filter .4s; filter: saturate(.8) brightness(.85); }
    .gallery-card:hover .gallery-img { transform: scale(1.08); filter: saturate(1.2) brightness(1); }
    .gallery-overlay { position:absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,.8) 0%, transparent 60%); opacity:0; transition: opacity .4s; display:flex; align-items:flex-end; padding:20px; }
    .gallery-card:hover .gallery-overlay { opacity:1; }
    .overlay-info h6 { font-family:'Syncopate',sans-serif; font-size:.65rem; letter-spacing:3px; margin-bottom:4px; }
    .overlay-info span { font-size:.7rem; opacity:.6; letter-spacing:2px; }
    .overlay-like { margin-left:auto; width:36px; height:36px; border:1px solid rgba(255,255,255,.4); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.85rem; cursor:none; transition: all .3s; flex-shrink:0; background:transparent; color:#fff;}
    .overlay-like:hover, .overlay-like.liked { background: var(--bright-red); border-color: var(--bright-red); animation: pulse-like .4s ease; }
    @keyframes pulse-like { 0%{transform:scale(1);} 50%{transform:scale(1.4);} 100%{transform:scale(1);} }
    .cat-label { position:absolute; top:14px; left:14px; font-family:'Syncopate',sans-serif; font-size:.55rem; letter-spacing:3px; padding:5px 10px; background: rgba(0,0,0,.6); border:1px solid var(--cyan); color: var(--cyan); border-radius:2px; opacity:0; transition: opacity .3s; }
    .gallery-card:hover .cat-label { opacity:1; }
    .empty-state { text-align: center; margin-top: 5rem; font-family: 'Syncopate', sans-serif; opacity: 0.5; font-size: 1.2rem; letter-spacing: 2px; }
</style>
@endsection

@section('content')
<section class="hero-fav">
    <div>
        <h1 class="hero-title syncopate">FAVORITES</h1>
        <p class="hero-subtitle syncopate">Your Selected Works</p>
    </div>
</section>

<section class="py-5">
    <div class="container pb-5">
        <div class="gallery-grid" id="favorites-grid">
            <!-- Rendered by JS -->
        </div>
        <div class="empty-state" id="empty-state" style="display:none;">
            No favorites yet. Head to the gallery to select some!
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let favs = JSON.parse(localStorage.getItem('vibrance_favs') || '[]');
    let $grid = $('#favorites-grid');
    let $empty = $('#empty-state');
    
    if (favs.length === 0) {
        $empty.show();
    } else {
        favs.forEach(fav => {
            let card = `
            <div class="gallery-card" data-id="${fav.id}">
                <img class="gallery-img" src="${fav.image}" alt="">
                <div class="cat-label">${fav.category}</div>
                <div class="gallery-overlay">
                    <div class="overlay-info">
                        <h6>${fav.title}</h6>
                        <span>${fav.author}</span>
                    </div>
                    <button class="overlay-like liked" onclick="unlikePhoto(event, ${fav.id}, this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>`;
            $grid.append(card);
        });
    }
});

function unlikePhoto(e, id, btn) {
    e.stopPropagation();
    let $card = $(btn).closest('.gallery-card');
    
    let favs = JSON.parse(localStorage.getItem('vibrance_favs') || '[]');
    favs = favs.filter(f => f.id != id);
    localStorage.setItem('vibrance_favs', JSON.stringify(favs));
    
    window.showToast('Removed from Favourites', 'cyan');
    
    $card.fadeOut(400, function() {
        $(this).remove();
        if (favs.length === 0) {
            $('#empty-state').fadeIn();
        }
    });

    $.post(`/photos/${id}/like`).fail(function(e) { console.log(e); });
}
</script>
@endpush
