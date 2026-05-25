@extends('layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="section-label">INQUIRY REF #{{ str_pad($inquiry->id, 4, '0', STR_PAD_LEFT) }}</div>
            <h1 class="section-title">Message Details.</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('admin.inquiries.index') }}" class="btn-vivid">Back to Inbox</a>
        </div>
    </div>
    
    <div class="contact-wrap mx-auto" style="max-width:800px;">
        <div class="row mb-4">
            <div class="col-sm-6">
                <div style="font-family:'Syncopate',sans-serif;font-size:.65rem;color:var(--cyan);letter-spacing:2px;">FROM</div>
                <div style="font-size:1.2rem;">{{ $inquiry->full_name }}</div>
                <div style="opacity:.6;font-size:.9rem;"><i class="bi bi-envelope"></i> {{ $inquiry->email }}</div>
            </div>
            <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                <div style="font-family:'Syncopate',sans-serif;font-size:.65rem;color:var(--cyan);letter-spacing:2px;">RECEIVED</div>
                <div>{{ $inquiry->created_at->format('M d, Y h:i A') }}</div>
                <div style="opacity:.6;font-size:.8rem;">IP: {{ $inquiry->ip_address ?? 'Unknown' }}</div>
            </div>
        </div>
        
        <div class="mb-4">
            <div style="font-family:'Syncopate',sans-serif;font-size:.65rem;color:var(--cyan);letter-spacing:2px;margin-bottom:10px;">SERVICE INTEREST</div>
            <div style="font-size:1.1rem; border-left:3px solid var(--turquoise); padding-left:15px;">{{ $inquiry->service }}</div>
        </div>
        
        <div class="mb-5">
            <div style="font-family:'Syncopate',sans-serif;font-size:.65rem;color:var(--cyan);letter-spacing:2px;margin-bottom:10px;">MESSAGE</div>
            <div style="background:rgba(0,0,0,.3); padding:20px; border-radius:4px; font-size:1.05rem; line-height:1.6; white-space:pre-wrap;">{{ $inquiry->message }}</div>
        </div>
        
        <hr style="border-color:rgba(255,255,255,.1); margin: 30px 0;">
        
        <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST" class="d-flex align-items-center gap-3">
            @csrf @method('PATCH')
            <div style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;opacity:.6;">UPDATE STATUS:</div>
            <select name="status" class="form-select bg-dark text-white border-secondary w-auto rounded-0">
                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New</option>
                <option value="read" {{ $inquiry->status == 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ $inquiry->status == 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            <button type="submit" class="btn btn-outline-info rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;">SAVE</button>
        </form>
    </div>
</div>
@endsection
