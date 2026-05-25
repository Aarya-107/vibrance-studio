<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VIBRANCE | @yield('title', 'Cinematic Photography')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&family=Outfit:wght@300;400;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --bright-red: #FF0000;
            --bright-yellow: #FFEF00;
            --electric-blue: #0047AB;
            --cyan: #00FFFF;
            --turquoise: #40E0D0;
            --bg-dark: #050505;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: var(--bg-dark); color: #fff; font-family: 'Outfit', sans-serif; overflow-x: hidden; cursor: none; }
        .syncopate { font-family: 'Syncopate', sans-serif; text-transform: uppercase; }
        .mesh-bg { position: fixed; top:0; left:0; width:100%; height:100%; z-index:-1; filter: blur(100px); opacity:.45; pointer-events:none; }
        .blob { position:absolute; width:500px; height:500px; border-radius:50%; animation: float 20s infinite alternate; }
        @keyframes float { 0%{transform:translate(0,0) scale(1);} 100%{transform:translate(20vw,20vh) scale(1.2);} }
        #cursor { width:10px; height:10px; background:#fff; border-radius:50%; position:fixed; pointer-events:none; z-index:10000; mix-blend-mode:difference; transition:width .2s,height .2s; }
        #cursor.hovered { width:18px; height:18px; }
        #cursor-follower { width:40px; height:40px; border:2px solid var(--cyan); border-radius:50%; position:fixed; pointer-events:none; z-index:9999; box-shadow:0 0 20px var(--turquoise); transition:border-color .3s, transform .1s; }
        #cursor-follower.hovered { border-color: var(--bright-red); transform: scale(1.5); }
        .navbar { padding:25px 0; transition:.4s; border-bottom:2px solid transparent; }
        .navbar.scrolled { background: rgba(0,0,0,.92); backdrop-filter: blur(20px); border-color: var(--cyan); padding:15px 0; }
        .nav-link { color: rgba(255,255,255,.7) !important; letter-spacing:2px; font-size:.75rem; transition: color .3s; }
        .nav-link:hover, .nav-link.active { color: var(--cyan) !important; }
        .btn-vivid { background: var(--bright-red); color:#fff; font-weight:800; padding:18px 48px; border:none; letter-spacing:3px; transition: all .3s; box-shadow: 8px 8px 0 var(--bright-yellow); font-family:'Syncopate',sans-serif; font-size:.75rem; cursor:none; border-radius:2px; text-decoration:none; display:inline-block; }
        .btn-vivid:hover { transform: translate(-4px,-4px); box-shadow: 12px 12px 0 var(--bright-yellow); color:#fff; }
        .btn-vivid:active { transform: translate(2px,2px); box-shadow: 4px 4px 0 var(--bright-yellow); }
        .btn-vivid.loading { opacity:.7; pointer-events:none; }
        #toast-container { position:fixed; bottom:30px; right:30px; z-index:30000; display:flex; flex-direction:column; gap:10px; }
        .toast-msg { background: rgba(0,0,0,.9); border-left:3px solid var(--cyan); padding:14px 20px; border-radius:4px; font-size:.8rem; letter-spacing:1px; backdrop-filter: blur(10px); min-width:200px; animation: slideToast .3s ease; }
        .toast-msg.red { border-color: var(--bright-red); }
        .toast-msg.yellow { border-color: var(--bright-yellow); }
        @keyframes slideToast { from{transform:translateX(60px);opacity:0;} to{transform:translateX(0);opacity:1;} }
        footer { border-top:1px solid rgba(255,255,255,.08); }
        .footer-brand { font-size:2.5rem; font-weight:700; opacity:.06; letter-spacing:10px; }
        @yield('styles')
    </style>
</head>
<body>
<div class="mesh-bg">
    <div class="blob" style="background: var(--bright-red); top:-10%; left:-10%;"></div>
    <div class="blob" style="background: var(--electric-blue); top:30%; right:-10%; animation-delay:-5s;"></div>
    <div class="blob" style="background: var(--turquoise); bottom:-10%; left:30%; animation-delay:-10s;"></div>
</div>
<div id="cursor"></div>
<div id="cursor-follower"></div>
<div id="toast-container">
    @if(session('success'))
        <div class="toast-msg">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="toast-msg red">{{ $error }}</div>
        @endforeach
    @endif
</div>

<!-- NAV -->
<nav class="navbar fixed-top" id="nav">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-brand syncopate fw-bold text-white" href="{{ route('photos.index') }}" style="letter-spacing:4px;">VIBRANCE.</a>
        <div class="d-flex gap-4 align-items-center">
            <a class="nav-link syncopate" href="{{ route('photos.index') }}#gallery">Gallery</a>
            <a class="nav-link syncopate" href="{{ route('photos.index') }}#contact">Contact</a>
            @guest
                <a class="nav-link syncopate" href="{{ route('login') }}">Login</a>
            @endguest
            @auth
                <a class="nav-link syncopate" href="{{ route('admin.inquiries.index') }}">Admin</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
                    @csrf
                    <button type="submit" class="nav-link syncopate bg-transparent border-0" style="cursor:none;">Logout</button>
                </form>
                <a class="nav-link fs-5 text-danger" style="margin-top:-5px; padding-left:5px" href="{{ route('favorites') }}" title="Favorites">❤️</a>
            @endauth
        </div>
    </div>
</nav>

<main style="padding-top: 100px; min-height: 80vh;">
    @yield('content')
</main>

<footer class="py-5 text-center mt-5">
    <div class="container">
        <div class="footer-brand syncopate">VIBRANCE</div>
        <p class="mt-3" style="opacity:.4; font-size:.7rem; letter-spacing:3px;">© 2024 VIBRANCE STUDIO. ALL RIGHTS RESERVED.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    gsap.registerPlugin(ScrollTrigger);
    
    // AJAX CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('mousemove', function (e) {
        gsap.to('#cursor', { x: e.clientX, y: e.clientY, duration: 0 });
        gsap.to('#cursor-follower', { x: e.clientX - 20, y: e.clientY - 20, duration: 0.12 });
    });
    
    $(document).on('mouseenter', 'a, button, .gallery-card, .filter-btn, .overlay-like, input, textarea, select', function () {
        $('#cursor, #cursor-follower').addClass('hovered');
    }).on('mouseleave', 'a, button, .gallery-card, .filter-btn, .overlay-like, input, textarea, select', function () {
        $('#cursor, #cursor-follower').removeClass('hovered');
    });
    
    $(window).on('scroll', function () {
        $('#nav').toggleClass('scrolled', $(this).scrollTop() > 60);
    });
    
    window.showToast = function(msg, type) {
        let $toast = $(`<div class="toast-msg ${type||''}">${msg}</div>`);
        $('#toast-container').append($toast);
        setTimeout(() => { $toast.css({opacity:0, transition:'opacity .4s'}); setTimeout(() => $toast.remove(), 400); }, 2800);
    }
    
    setTimeout(() => { $('.toast-msg').each(function() {
        let $t = $(this);
        setTimeout(() => { $t.css({opacity:0, transition:'opacity .4s'}); setTimeout(() => $t.remove(), 400); }, 2800);
    }); }, 100);
});
</script>
@stack('scripts')
</body>
</html>
