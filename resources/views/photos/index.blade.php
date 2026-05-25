@extends('layouts.app')

@section('title', 'Gallery')

@section('styles')
<style>
    .hero { height:70vh; display:flex; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden; }
    .hero-title { font-size: calc(3rem + 5vw); font-weight:800; line-height:.85;
        background: linear-gradient(to right, var(--bright-red), var(--bright-yellow), var(--turquoise), var(--cyan));
        background-size: 300% auto; -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        animation: shine 5s linear infinite; }
    @keyframes shine { to { background-position: 300% center; } }
    .hero-subtitle { font-size:1.1rem; opacity:.6; letter-spacing:4px; margin-top:1.5rem; }
    .section-label { font-family:'Syncopate',sans-serif; font-size:.6rem; letter-spacing:6px; opacity:.4; margin-bottom:12px; }
    .section-title { font-family:'Syncopate',sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight:700; line-height:1; }
    .filter-bar { display:flex; gap:12px; flex-wrap:wrap; }
    .filter-btn { background:transparent; border:1px solid rgba(255,255,255,.2); color:rgba(255,255,255,.6); padding:8px 22px; font-family:'Syncopate',sans-serif; font-size:.65rem; letter-spacing:2px; cursor:none; transition:all .3s; border-radius:2px; text-decoration:none;}
    .filter-btn:hover, .filter-btn.active { background: var(--bright-red); border-color: var(--bright-red); color:#fff; box-shadow: 0 0 20px rgba(255,0,0,.4); }
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
    
    .contact-wrap { background: rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:50px; }
    .form-field { position:relative; margin-bottom:28px; }
    .form-field input, .form-field textarea, .form-field select { width:100%; background:transparent; border:none; border-bottom:1px solid rgba(255,255,255,.2); color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; padding:14px 0 10px; outline:none; transition: border-color .3s; resize:none; cursor:none; }
    .form-field select option { background:#111; }
    .form-field label { position:absolute; top:14px; left:0; font-size:.75rem; letter-spacing:3px; opacity:.45; pointer-events:none; transition: top .3s, font-size .3s, opacity .3s, color .3s; font-family:'Syncopate',sans-serif; }
    .form-field input:focus ~ label, .form-field input:not(:placeholder-shown) ~ label,
    .form-field textarea:focus ~ label, .form-field textarea:not(:placeholder-shown) ~ label { top:-8px; font-size:.55rem; opacity:1; color: var(--cyan); }
    .form-field input:focus, .form-field textarea:focus { border-color: var(--cyan); }
    .form-field .field-line { position:absolute; bottom:0; left:0; height:2px; width:0; background: linear-gradient(90deg, var(--bright-red), var(--cyan)); transition: width .4s; }
    .form-field input:focus ~ .field-line, .form-field textarea:focus ~ .field-line { width:100%; }
    .form-success { display:none; text-align:center; padding:40px; }
    .form-success .success-icon { font-size:3rem; color: var(--cyan); }
</style>
@endsection

@section('content')
<section class="hero" id="hero">
    <div>
        <div class="section-label">EST. 2024 — CINEMATIC VISION</div>
        <h1 class="hero-title syncopate">CAPTURE<br>THE LIGHT.</h1>
        <p class="hero-subtitle syncopate">Photography that breathes.</p>
    </div>
</section>

<section id="gallery" class="py-5">
    <div class="container py-5">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5">
            <div>
                <div class="section-label">PORTFOLIO — SELECTED WORKS</div>
                <h2 class="section-title">The Collection.</h2>
            </div>
            <div class="filter-bar mt-3">
                <a href="{{ route('photos.index', ['category' => 'all']) }}" class="filter-btn {{ $category == 'all' ? 'active' : '' }}">All</a>
                <a href="{{ route('photos.index', ['category' => 'portrait']) }}" class="filter-btn {{ $category == 'portrait' ? 'active' : '' }}">Portrait</a>
                <a href="{{ route('photos.index', ['category' => 'landscape']) }}" class="filter-btn {{ $category == 'landscape' ? 'active' : '' }}">Landscape</a>
                <a href="{{ route('photos.index', ['category' => 'urban']) }}" class="filter-btn {{ $category == 'urban' ? 'active' : '' }}">Urban</a>
                <a href="{{ route('photos.index', ['category' => 'abstract']) }}" class="filter-btn {{ $category == 'abstract' ? 'active' : '' }}">Abstract</a>
            </div>
        </div>
        
        <div class="gallery-grid" id="gallery-grid">
            @foreach($photos as $photo)
            <div class="gallery-card" data-id="{{ $photo->id }}" onclick="window.location='{{ route('photos.show', $photo) }}'">
                <img class="gallery-img" src="{{ $photo->image_path }}" alt="">
                <div class="cat-label">{{ $photo->category_label }}</div>
                <div class="gallery-overlay">
                    <div class="overlay-info">
                        <h6>{{ $photo->title }}</h6>
                        <span>{{ $photo->author }}</span>
                    </div>
                    <button class="overlay-like" onclick="likePhoto(event, {{ $photo->id }}, this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $photos->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <div class="section-label">LET'S CONNECT</div>
                <h2 class="section-title">Start a project.</h2>
                <p class="mt-4" style="opacity:.55;">Every image begins with a conversation. Tell us your vision and we'll translate it into something extraordinary.</p>
                <div class="mt-4"><i class="bi bi-envelope text-info"></i> &nbsp; hello@vibrance.studio</div>
            </div>
            <div class="col-lg-7">
                <div class="contact-wrap">
                    <div id="form-area">
                        <form id="contact-form">
                            <div class="row g-3">
                                <div class="col-md-6"><div class="form-field"><input type="text" id="fname" placeholder=" " required><label>FIRST NAME</label><span class="field-line"></span></div></div>
                                <div class="col-md-6"><div class="form-field"><input type="text" id="lname" placeholder=" " required><label>LAST NAME</label><span class="field-line"></span></div></div>
                                <div class="col-12"><div class="form-field"><input type="email" id="email" placeholder=" " required><label>EMAIL ADDRESS</label><span class="field-line"></span></div></div>
                                <div class="col-12"><div class="form-field">
                                    <select id="service" required><option value="">Select a service</option><option>Portrait Session</option><option>Landscape Print</option><option>Commercial Shoot</option><option>Wedding Coverage</option><option>Other</option></select>
                                    <label style="top:-8px;font-size:.55rem;opacity:1;color:var(--cyan);">SERVICE TYPE</label>
                                </div></div>
                                <div class="col-12"><div class="form-field"><textarea id="message" rows="4" placeholder=" " required></textarea><label>YOUR MESSAGE</label><span class="field-line"></span></div></div>
                                <div class="col-12 mt-3 d-flex align-items-center gap-3">
                                    <button class="btn-vivid" type="submit" id="submit-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-success" id="form-success">
                        <div class="success-icon"><i class="bi bi-check-circle"></i></div>
                        <h4 class="syncopate mt-3" style="letter-spacing:3px;">Message Sent!</h4>
                        <p style="opacity:.6;">We'll be in touch within 24 hours.</p>
                        <button class="btn-vivid mt-3" id="reset-form">Send Another</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let favs = JSON.parse(localStorage.getItem('vibrance_favs') || '[]');
    favs.forEach(fav => {
        $(`.gallery-card[data-id="${fav.id}"] .overlay-like`).addClass('liked');
    });
});

function likePhoto(e, id, btn) {
    e.stopPropagation();
    let $btn = $(btn);
    $btn.toggleClass('liked');
    let isLiked = $btn.hasClass('liked');
    
    let favs = JSON.parse(localStorage.getItem('vibrance_favs') || '[]');
    if (isLiked) {
        let $card = $btn.closest('.gallery-card');
        let photo = {
            id: id,
            image: $card.find('img').attr('src'),
            category: $card.find('.cat-label').text(),
            title: $card.find('.overlay-info h6').text(),
            author: $card.find('.overlay-info span').text(),
        };
        favs.push(photo);
        window.showToast('Added to Favourites ❤', 'red');
    } else {
        favs = favs.filter(f => f.id !== id);
        window.showToast('Removed from Favourites', 'cyan');
    }
    localStorage.setItem('vibrance_favs', JSON.stringify(favs));

    $.post(`/photos/${id}/like`).fail(function(e) { console.log(e); });
}

$('#contact-form').on('submit', function(e) {
    e.preventDefault();
    let $btn = $('#submit-btn');
    $btn.addClass('loading').text('Sending...');
    
    $.post('{{ route('inquiries.store') }}', {
        fname: $('#fname').val(),
        lname: $('#lname').val(),
        email: $('#email').val(),
        service: $('#service').val(),
        message: $('#message').val()
    })
    .done(function(res) {
        if(res.success) {
            $('#form-area').fadeOut(300, () => $('#form-success').fadeIn(400));
            window.showToast(res.messages[0], 'cyan');
        }
    })
    .fail(function(xhr) {
        $btn.removeClass('loading').text('Send Message');
        let errs = xhr.responseJSON.errors;
        for(let key in errs) {
            window.showToast(errs[key][0], 'red');
        }
    });
});

$('#reset-form').on('click', function() {
    $('#form-success').fadeOut(300, () => {
        $('#form-area').fadeIn(400);
        $('#contact-form')[0].reset();
        $('#submit-btn').removeClass('loading').text('Send Message');
    });
});
</script>
@endpush
