@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="contact-wrap mx-auto" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-5">
            <div class="section-label">RESTRICTED AREA</div>
            <h1 class="section-title">Admin Login.</h1>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-field">
                <input type="email" id="email" name="email" placeholder=" " value="{{ old('email') }}" required autofocus>
                <label>EMAIL ADDRESS</label>
                <span class="field-line"></span>
            </div>

            <div class="form-field mt-4">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label>PASSWORD</label>
                <span class="field-line"></span>
            </div>

            <div class="mt-5 text-center">
                <button type="submit" class="btn-vivid w-100">Access Dashboard</button>
            </div>
        </form>
    </div>
</div>
@endsection
