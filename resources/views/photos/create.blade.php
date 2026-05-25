@extends('layouts.app')

@section('title', 'Add New Photo')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="section-title">Add New Photo.</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('photos.index') }}" class="btn btn-outline-light rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;">Back to Gallery</a>
        </div>
    </div>
    
    <div class="contact-wrap mx-auto" style="max-width:700px;">
        <form action="{{ route('photos.store') }}" method="POST">
            @csrf
            @include('photos._form', ['photo' => new \App\Models\Photo])
            
            <div class="mt-5 text-end">
                <button type="submit" class="btn-vivid">Upload Photo</button>
            </div>
        </form>
    </div>
</div>
@endsection
