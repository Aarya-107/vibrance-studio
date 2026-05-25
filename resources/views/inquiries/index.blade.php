@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    .stat-card { border:1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.03); padding:40px 30px; border-radius:4px; text-align:center; }
    .stat-number { font-family:'Syncopate',sans-serif; font-size:3.5rem; font-weight:700; background: linear-gradient(135deg, var(--cyan), var(--turquoise)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
    .stat-label { font-size:.7rem; letter-spacing:4px; opacity:.5; margin-top:8px; text-transform:uppercase; }
    .admin-table { background: rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.08); }
    .admin-table th { font-family:'Syncopate',sans-serif; font-size:.65rem; letter-spacing:2px; color:var(--cyan); border-bottom:1px solid rgba(255,255,255,.1); padding:15px; }
    .admin-table td { border-bottom:1px solid rgba(255,255,255,.05); padding:15px; vertical-align:middle; font-size:.9rem; }
    .badge-new { background:var(--bright-red); color:#fff; }
    .badge-read { background:var(--electric-blue); color:#fff; }
    .badge-replied { background:var(--turquoise); color:#000; }
    .badge-closed { background:rgba(255,255,255,.2); color:#fff; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="section-label">ADMINISTRATION</div>
    <h1 class="section-title mb-5">Inquiries Inbox.</h1>
    
    <div class="row g-4 mb-5">
        <div class="col-md-4"><div class="stat-card"><div class="stat-number">{{ $stats['total'] }}</div><div class="stat-label">Total Inquiries</div></div></div>
        <div class="col-md-4"><div class="stat-card"><div class="stat-number" style="background:var(--bright-red);-webkit-background-clip:text;">{{ $stats['new'] }}</div><div class="stat-label">New Messages</div></div></div>
        <div class="col-md-4"><div class="stat-card"><div class="stat-number" style="background:var(--turquoise);-webkit-background-clip:text;">{{ $stats['replied'] }}</div><div class="stat-label">Replied</div></div></div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table text-white">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inquiries as $inquiry)
                <tr>
                    <td style="opacity:.6;">{{ $inquiry->created_at->format('M d, Y') }}</td>
                    <td>{{ $inquiry->full_name }}</td>
                    <td style="color:var(--cyan);">{{ $inquiry->service }}</td>
                    <td>
                        <span class="badge badge-{{ $inquiry->status }} rounded-pill px-3">{{ strtoupper($inquiry->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-outline-info rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.6rem;letter-spacing:1px;">VIEW</a>
                        
                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-0" style="font-family:'Syncopate',sans-serif;font-size:.6rem;letter-spacing:1px;">DEL</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $inquiries->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
