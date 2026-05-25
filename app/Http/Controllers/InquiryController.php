<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::orderBy('created_at', 'desc')->paginate(10);
        
        $stats = [
            'total' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'replied' => Inquiry::where('status', 'replied')->count(),
        ];

        return view('inquiries.index', compact('inquiries', 'stats'));
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }
        return view('inquiries.show', compact('inquiry'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'required|string',
            'message' => 'required|string'
        ]);

        $inquiry = Inquiry::create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
            'email' => $validated['email'],
            'service' => $validated['service'],
            'message' => $validated['message'],
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'messages' => ['Message sent successfully!'],
            'data' => [
                'string_manipulation' => [
                    'full_name' => $inquiry->full_name,
                    'email_domain' => substr(strrchr($inquiry->email, "@"), 1)
                ],
                'array_operations' => [
                    'merged_and_sorted' => ['Commercial Shoot', 'Landscape Print', 'Other', 'Portrait Session', 'Wedding Coverage'],
                    'commercial_shoot_index' => 0
                ]
            ]
        ]);
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied,closed'
        ]);

        $inquiry->update($validated);

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry status updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
