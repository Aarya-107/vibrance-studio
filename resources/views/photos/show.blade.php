@extends('layouts.app')

@section('title', $photo->title)

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="syncopate" style="font-size:3rem; font-weight:800;">{{ $photo->title }}</h1>
            <p style="opacity:.6; letter-spacing:3px;">BY {{ $photo->author }} | {{ $photo->category_label }}</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('photos.index') }}" class="btn-vivid">Back to Gallery</a>
        </div>
    </div>
    
    <div class="text-center">
        <img src="{{ $photo->image_path }}" class="img-fluid rounded shadow-lg" alt="{{ $photo->title }}" style="max-height:80vh; object-fit:contain; border:1px solid rgba(255,255,255,.1);">
    </div>
</div>
@endsection
