@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
    Settings
@endsection

@section('content-header')
    <div class="admin-container" style="margin-bottom: 1.25rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.25rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.65rem;">
                    <i data-lucide="settings" style="width: 26px; height: 26px; color: #a855f7;"></i>
                    Panel Settings
                </h1>
                <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.35rem 0 0 0;">Configure panel identity, public branding, and security requirements.</p>
            </div>
            <ol class="breadcrumb" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 0.45rem 1rem; margin: 0; border-radius: 9999px;">
                <li><a href="{{ route('admin.index') }}" style="color: #a855f7; font-weight: 600;"><i data-lucide="home" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 3px;"></i> Admin</a></li>
                <li class="active" style="color: #cbd5e1;">Settings</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="admin-container">
        {{-- Modern Segmented Tab Bar --}}
        <div style="margin-bottom: 1.5rem;">
            @yield('settings::nav')
        </div>

        {{-- Main Settings Form Card --}}
        <div class="admin-card">
            {{-- Card Header --}}
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">
                        <i data-lucide="sliders" style="width: 20px; height: 20px; color: #a855f7;"></i>
                        General Configuration
                    </h3>
                    <p class="admin-card-subtitle">Manage company naming and authentication verification policies.</p>
                </div>
                <span class="admin-badge-core">CORE</span>
            </div>

            <form action="{{ route('admin.settings') }}" method="POST">
                <div class="admin-card-body">
                    {{-- 1. Company Name Field --}}
                    <div class="admin-form-group">
                        <label for="appName" class="admin-label">
                            Company Name
                        </label>
                        <p class="admin-help-text">This name is displayed across navigation titles, emails, and client panel views.</p>
                        <div style="max-width: 640px;">
                            <input 
                                type="text" 
                                id="appName"
                                class="form-control admin-input" 
                                name="app:name" 
                                value="{{ old('app:name', config('app.name')) }}" 
                                placeholder="e.g. My Hosting Panel"
                            />
                        </div>
                    </div>

                    {{-- 2. Two-Factor Authentication Requirement --}}
                    <div class="admin-form-group" style="margin-bottom: 0.5rem;">
                        <label class="admin-label">
                            Two-Factor Authentication Requirement
                        </label>
                        <p class="admin-help-text">Require multi-factor authentication (TOTP) before accounts can access panel resources.</p>
                        
                        @php
                            $level = old('pterodactyl:auth:2fa_required', config('pterodactyl.auth.2fa_required'));
                        @endphp

                        <div class="row" style="margin-left: -8px; margin-right: -8px;">
                            {{-- Option 0: Optional --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 8px; padding-right: 8px; margin-bottom: 1rem;">
                                <label style="display: block; cursor: pointer; margin: 0; height: 100%;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="0" @if ($level == 0) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 0 ? 'active' : '' }}" style="border: 1px solid {{ $level == 0 ? 'rgba(139, 92, 246, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 0 ? 'rgba(139, 92, 246, 0.12)' : 'rgba(8, 6, 18, 0.5)' }};">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.6rem;">
                                            <span class="radio-title" style="color: {{ $level == 0 ? '#ffffff' : '#e2e8f0' }};">Optional</span>
                                            <span class="radio-indicator" style="border: 2px solid {{ $level == 0 ? '#8b5cf6' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 0 ? '#8b5cf6' : 'transparent' }};"></span>
                                        </div>
                                        <p class="radio-desc">Users choose whether to enable 2FA protection on their accounts.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Option 1: Admin Only --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 8px; padding-right: 8px; margin-bottom: 1rem;">
                                <label style="display: block; cursor: pointer; margin: 0; height: 100%;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="1" @if ($level == 1) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 1 ? 'active' : '' }}" style="border: 1px solid {{ $level == 1 ? 'rgba(245, 158, 11, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 1 ? 'rgba(245, 158, 11, 0.12)' : 'rgba(8, 6, 18, 0.5)' }};">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.6rem;">
                                            <span class="radio-title" style="color: {{ $level == 1 ? '#ffffff' : '#e2e8f0' }};">Admin Only</span>
                                            <span class="radio-indicator" style="border: 2px solid {{ $level == 1 ? '#f59e0b' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 1 ? '#f59e0b' : 'transparent' }};"></span>
                                        </div>
                                        <p class="radio-desc">Required for administrative users before accessing panel controls.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Option 2: All Users --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 8px; padding-right: 8px; margin-bottom: 1rem;">
                                <label style="display: block; cursor: pointer; margin: 0; height: 100%;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="2" @if ($level == 2) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 2 ? 'active' : '' }}" style="border: 1px solid {{ $level == 2 ? 'rgba(16, 185, 129, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 2 ? 'rgba(16, 185, 129, 0.12)' : 'rgba(8, 6, 18, 0.5)' }};">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.6rem;">
                                            <span class="radio-title" style="color: {{ $level == 2 ? '#ffffff' : '#e2e8f0' }};">All Users</span>
                                            <span class="radio-indicator" style="border: 2px solid {{ $level == 2 ? '#10b981' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 2 ? '#10b981' : 'transparent' }};"></span>
                                        </div>
                                        <p class="radio-desc">Mandatory for all registered client and administrator accounts.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Action Footer --}}
                <div class="admin-card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary" style="padding: 0.7rem 1.85rem; font-weight: 600; font-size: 0.95rem; border-radius: 10px; height: 46px; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%); border: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);">
                        <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function updateRadioCards(input) {
        document.querySelectorAll('.twofa-card').forEach(card => {
            card.style.borderColor = 'rgba(255, 255, 255, 0.08)';
            card.style.background = 'rgba(8, 6, 18, 0.5)';
            const title = card.querySelector('.radio-title');
            if (title) title.style.color = '#e2e8f0';
            const indicator = card.querySelector('.radio-indicator');
            if (indicator) {
                indicator.style.borderColor = 'rgba(255, 255, 255, 0.25)';
                indicator.style.background = 'transparent';
            }
        });
        const activeCard = input.parentElement.querySelector('.twofa-card');
        if (activeCard) {
            const val = input.value;
            const color = val == 0 ? '#8b5cf6' : (val == 1 ? '#f59e0b' : '#10b981');
            const bg = val == 0 ? 'rgba(139, 92, 246, 0.12)' : (val == 1 ? 'rgba(245, 158, 11, 0.12)' : 'rgba(16, 185, 129, 0.12)');
            activeCard.style.borderColor = color;
            activeCard.style.background = bg;
            const title = activeCard.querySelector('.radio-title');
            if (title) title.style.color = '#ffffff';
            const indicator = activeCard.querySelector('.radio-indicator');
            if (indicator) {
                indicator.style.borderColor = color;
                indicator.style.background = color;
            }
        }
    }
    </script>
@endsection
