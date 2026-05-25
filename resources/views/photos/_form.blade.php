<div class="row g-4">
    <div class="col-md-6">
        <div class="form-field">
            <input type="text" name="title" id="title" placeholder=" " value="{{ old('title', $photo->title) }}" required>
            <label>PHOTO TITLE</label>
            <span class="field-line"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-field">
            <input type="text" name="author" id="author" placeholder=" " value="{{ old('author', $photo->author) }}" required>
            <label>PHOTOGRAPHER NAME</label>
            <span class="field-line"></span>
        </div>
    </div>
    <div class="col-12">
        <div class="form-field">
            <input type="url" name="image_path" id="image_path" placeholder=" " value="{{ old('image_path', $photo->image_path) }}" required oninput="document.getElementById('img-preview').src = this.value;">
            <label>IMAGE URL (UNSPLASH OR ABSOLUTE URL)</label>
            <span class="field-line"></span>
        </div>
        <div class="mt-3 text-center bg-dark p-2 rounded border border-secondary" style="min-height: 200px; display:flex; align-items:center; justify-content:center;">
            <img id="img-preview" src="{{ old('image_path', $photo->image_path) }}" alt="Preview" style="max-height: 200px; max-width: 100%; object-fit: contain;">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-field">
            <select name="category" id="category" required>
                <option value="">Select Category</option>
                <option value="portrait" {{ old('category', $photo->category) == 'portrait' ? 'selected' : '' }}>Portrait</option>
                <option value="landscape" {{ old('category', $photo->category) == 'landscape' ? 'selected' : '' }}>Landscape</option>
                <option value="urban" {{ old('category', $photo->category) == 'urban' ? 'selected' : '' }}>Urban</option>
                <option value="abstract" {{ old('category', $photo->category) == 'abstract' ? 'selected' : '' }}>Abstract</option>
            </select>
            <label style="top:-8px;font-size:.55rem;opacity:1;color:var(--cyan);">CATEGORY</label>
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-center">
        <div class="form-check form-switch" style="font-family:'Syncopate',sans-serif;font-size:.7rem;letter-spacing:2px;">
            <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $photo->is_featured) ? 'checked' : '' }} style="cursor:none;">
            <label class="form-check-label" for="is_featured" style="cursor:none;">FEATURE IN GALLERY</label>
        </div>
    </div>
</div>
