@extends('layouts.app')

@section('title', 'Edit Photo')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h1 class="section-title">Edit Photo.</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('photos.index') }}" class="btn btn-outline-light rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;">Back to Gallery</a>
        </div>
    </div>
    
    <div class="contact-wrap mx-auto" style="max-width:700px;">
        <form action="{{ route('photos.update', $photo) }}" method="POST">
            @csrf @method('PUT')
            @include('photos._form', ['photo' => $photo])
            
            <div class="mt-5 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-danger rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;" onclick="if(confirm('Are you sure you want to delete this photo?')) document.getElementById('delete-form').submit();">Delete Photo</button>
                <button type="submit" class="btn-vivid">Save Changes</button>
            </div>
        </form>
        
        <form id="delete-form" action="{{ route('photos.destroy', $photo) }}" method="POST" style="display:none;">
            @csrf @method('DELETE')
        </form>
    </div>
</div>
@endsection
