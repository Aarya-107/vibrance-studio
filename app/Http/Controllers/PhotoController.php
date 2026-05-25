<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $search = $request->query('search');

        $photos = Photo::byCategory($category)->search($search)->paginate(12);

        return view('photos.index', compact('photos', 'category', 'search'));
    }

    public function create()
    {
        return view('photos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'category' => 'required|in:portrait,landscape,urban,abstract',
            'image_path' => 'required|url',
            'is_featured' => 'boolean'
        ]);

        Photo::create($validated);

        return redirect()->route('photos.index')->with('success', 'Photo created successfully.');
    }

    public function show(Photo $photo)
    {
        return view('photos.show', compact('photo'));
    }

    public function edit(Photo $photo)
    {
        return view('photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'category' => 'required|in:portrait,landscape,urban,abstract',
            'image_path' => 'required|url',
            'is_featured' => 'boolean'
        ]);

        $photo->update($validated);

        return redirect()->route('photos.index')->with('success', 'Photo updated successfully.');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return redirect()->route('photos.index')->with('success', 'Photo deleted successfully.');
    }

    public function like(Photo $photo)
    {
        // Simple mock response for AJAX like functionality
        return response()->json(['success' => true]);
    }
}
