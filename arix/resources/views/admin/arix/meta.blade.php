@extends('layouts.arix', ['navbar' => 'meta', 'sideEditor' => true])

@section('title')
    Arix Meta data
@endsection

@section('content')
    <form action="{{ route('admin.arix.meta') }}" method="POST">
        <div class="header" style="display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); margin-bottom: 1.25rem;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), rgba(6, 182, 212, 0.1)); display: flex; align-items: center; justify-content: center; color: #14b8a6; flex-shrink: 0;">
                <i data-lucide="tags" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    SEO & Metadata
                    <span style="font-size: 0.62rem; font-weight: 700; color: #14b8a6; background: rgba(20, 184, 166, 0.15); border: 1px solid rgba(20, 184, 166, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">INDEXING</span>
                </p>
                <span class="description-text" style="color: #94a3b8; font-size: 0.82rem;">Control browser titles, favicons, social share OpenGraph embeds, and theme color tags.</span>
            </div>
        </div>
        <x-arix.input-field 
            id="arix:meta_favicon" 
            :value="$meta_favicon" 
            label="Favicon"
        />
        <x-arix.input-field
            id="arix:meta_title" 
            :value="$meta_title" 
            label="Meta title"
        />
        <x-arix.input-field
            id="arix:meta_image" 
            :value="$meta_image" 
            label="Meta image"
        />
        <x-arix.textarea-field
            id="arix:meta_description" 
            :value="$meta_description" 
            label="Meta description"
        />
        <div class="input-field">
            <label for="arix:meta_color">Meta color</label>
            <x-arix.color-input
                target="meta_color"
                id="arix:meta_color" 
                :value="$meta_color"
            />
        </div>
        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>

    <!-- <form action="{{ route('admin.arix.meta') }}" method="POST">
        <div class="input-field hr">
            <label for="arix:meta_favicon">Favicon</label>
            <input type="text" id="arix:meta_favicon" name="arix:meta_favicon" value="{{ old('arix:meta_favicon', $meta_favicon) }}" />
        </div>
        <div class="input-field hr">
            <label for="arix:meta_title">Meta title</label>
            <input type="text" id="arix:meta_title" name="arix:meta_title" value="{{ old('arix:meta_title', $meta_title) }}" />
        </div>
        <div class="input-field hr">
            <label for="arix:meta_image">Meta image</label>
            <input type="text" id="arix:meta_image" name="arix:meta_image" value="{{ old('arix:meta_image', $meta_image) }}" />
        </div>
        <div class="input-field">
            <label for="arix:meta_description">Meta description</label>
            <textarea type="text" id="arix:meta_description" name="arix:meta_description" width="100%" rows="5">{{ old('arix:meta_description', $meta_description) }}</textarea>
        </div>
        <div class="input-field hr">
            <label for="arix:meta_color">Meta color</label>
            <input type="color" id="arix:meta_color" name="arix:meta_color" value="{{ old('arix:meta_color', $meta_color) }}" />
        </div>
        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form> -->
@endsection