@extends('layouts.arix', ['navbar' => 'index', 'sideEditor' => true])

@section('title')
    Arix Theme
@endsection

@section('content')
    <form action="{{ route('admin.arix') }}" method="POST">
        <div class="header" style="display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); margin-bottom: 1.25rem;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: #818cf8; flex-shrink: 0;">
                <i data-lucide="wand-2" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    General Settings
                    <span style="font-size: 0.62rem; font-weight: 700; color: #818cf8; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">CORE</span>
                </p>
                <span class="description-text" style="color: #94a3b8; font-size: 0.82rem;">Configure your panel branding, dark/light logos, dimensions, and support navigation links.</span>
            </div>
        </div>
        <x-arix.input-field 
            id="arix:logo" 
            :value="$logo" 
            label="Panel logo (Dark mode)"
        />
        <x-arix.input-field
            id="arix:logoLight" 
            :value="$logoLight" 
            label="Panel logo (Light mode)"
        />
        <x-arix.switch 
            hr="true"
            id="arix:fullLogo"
            name="arix:fullLogo"
            :value="$fullLogo"
            label="Logo only"
            helpText="Enable or disable the text next to the panel logo." 
        />
        <div style="position:relative;">
            <x-arix.input-field 
                hr="true"
                id="arix:logoHeight" 
                :value="$logoHeight" 
                label="Panel logo height"
            />
            <div style="position:absolute;bottom:42px;right:16px">
                px
            </div>
        </div>
        <div>
            <p class="subtitle">Support links</p>
            <x-arix.callout
                message="Leave empty remove the a specific support link from your panel."
            />
        </div>
        <x-arix.input-field 
            hr="true"
            id="arix:discord" 
            :value="$discord" 
            label="Discord ID"
        />
        <x-arix.input-field
            id="arix:support" 
            :value="$support" 
            label="Supportcenter"
        />
        <x-arix.input-field
            id="arix:billing" 
            :value="$billing" 
            label="Billing Area"
        />
        <x-arix.input-field
            id="arix:status" 
            :value="$status" 
            label="Server Status"
        />
        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>
@endsection