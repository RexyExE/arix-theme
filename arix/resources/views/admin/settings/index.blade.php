@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
    Settings
@endsection

@section('content-header')
    <div style="max-width: 960px; margin: 0 auto 1.5rem auto;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="settings" style="width: 22px; height: 22px; color: #a855f7;"></i>
                    Panel Settings
                </h1>
                <p style="color: #94a3b8; font-size: 0.85rem; margin: 0.25rem 0 0 0;">Configure panel identity, public branding, and security requirements.</p>
            </div>
            <ol class="breadcrumb" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.07); padding: 0.35rem 0.85rem; margin: 0; border-radius: 9999px;">
                <li><a href="{{ route('admin.index') }}" style="color: #a855f7;"><i data-lucide="home" style="width: 13px; height: 13px; display: inline-block; vertical-align: middle;"></i> Admin</a></li>
                <li class="active" style="color: #cbd5e1;">Settings</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div style="max-width: 960px; margin: 0 auto;">
        {{-- Modern Segmented Tab Bar --}}
        <div style="margin-bottom: 1.25rem;">
            @yield('settings::nav')
        </div>

        {{-- Main Settings Form Card --}}
        <div class="admin-card" style="background: rgba(14, 12, 26, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; overflow: hidden; box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);">
            {{-- Card Header --}}
            <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="sliders" style="width: 18px; height: 18px; color: #a855f7;"></i>
                        General Configuration
                    </h3>
                    <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: #94a3b8;">Manage company naming and authentication verification policies.</p>
                </div>
                <span style="font-size: 0.65rem; font-weight: 700; color: #a855f7; background: rgba(168, 85, 247, 0.12); border: 1px solid rgba(168, 85, 247, 0.25); padding: 0.2rem 0.6rem; border-radius: 9999px; letter-spacing: 0.08em; text-transform: uppercase;">CORE</span>
            </div>

            <form action="{{ route('admin.settings') }}" method="POST">
                <div style="padding: 1.75rem;">
                    {{-- 1. Company Name Field --}}
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label for="appName" style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">
                            Company Name
                        </label>
                        <p style="color: #64748b; font-size: 0.8rem; margin: 0 0 0.65rem 0;">This name is displayed across navigation titles, emails, and client panel views.</p>
                        <div style="position: relative; max-width: 540px;">
                            <input 
                                type="text" 
                                id="appName"
                                class="form-control" 
                                name="app:name" 
                                value="{{ old('app:name', config('app.name')) }}" 
                                placeholder="e.g. My Hosting Panel"
                                style="background: rgba(8, 6, 18, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; color: #ffffff; padding: 0.65rem 1rem; font-size: 0.88rem; width: 100%; height: 42px;" 
                            />
                        </div>
                    </div>

                    {{-- 2. Two-Factor Authentication Requirement --}}
                    <div class="form-group" style="margin-bottom: 0.5rem;">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">
                            Two-Factor Authentication Requirement
                        </label>
                        <p style="color: #64748b; font-size: 0.8rem; margin: 0 0 0.85rem 0;">Require multi-factor authentication (TOTP) before accounts can access panel resources.</p>
                        
                        @php
                            $level = old('pterodactyl:auth:2fa_required', config('pterodactyl.auth.2fa_required'));
                        @endphp

                        <div class="row" style="margin-left: -6px; margin-right: -6px; gap: 0.75rem 0;">
                            {{-- Option 0: Not Required --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 6px; padding-right: 6px;">
                                <label style="display: block; cursor: pointer; margin: 0;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="0" @if ($level == 0) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 0 ? 'active' : '' }}" style="padding: 1rem 1.15rem; border-radius: 12px; border: 1px solid {{ $level == 0 ? 'rgba(139, 92, 246, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 0 ? 'rgba(139, 92, 246, 0.12)' : 'rgba(8, 6, 18, 0.5)' }}; transition: all 0.2s ease;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                                            <span style="font-weight: 700; font-size: 0.86rem; color: {{ $level == 0 ? '#ffffff' : '#cbd5e1' }};">Optional</span>
                                            <span class="radio-indicator" style="width: 14px; height: 14px; border-radius: 50%; border: 2px solid {{ $level == 0 ? '#8b5cf6' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 0 ? '#8b5cf6' : 'transparent' }}; display: inline-block;"></span>
                                        </div>
                                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0; line-height: 1.35;">Users choose whether to enable 2FA protection on their accounts.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Option 1: Admin Only --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 6px; padding-right: 6px;">
                                <label style="display: block; cursor: pointer; margin: 0;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="1" @if ($level == 1) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 1 ? 'active' : '' }}" style="padding: 1rem 1.15rem; border-radius: 12px; border: 1px solid {{ $level == 1 ? 'rgba(245, 158, 11, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 1 ? 'rgba(245, 158, 11, 0.12)' : 'rgba(8, 6, 18, 0.5)' }}; transition: all 0.2s ease;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                                            <span style="font-weight: 700; font-size: 0.86rem; color: {{ $level == 1 ? '#ffffff' : '#cbd5e1' }};">Admin Only</span>
                                            <span class="radio-indicator" style="width: 14px; height: 14px; border-radius: 50%; border: 2px solid {{ $level == 1 ? '#f59e0b' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 1 ? '#f59e0b' : 'transparent' }}; display: inline-block;"></span>
                                        </div>
                                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0; line-height: 1.35;">Required for administrative users before accessing panel controls.</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Option 2: All Users --}}
                            <div class="col-xs-12 col-sm-4" style="padding-left: 6px; padding-right: 6px;">
                                <label style="display: block; cursor: pointer; margin: 0;">
                                    <input type="radio" name="pterodactyl:auth:2fa_required" value="2" @if ($level == 2) checked @endif style="display: none;" onchange="updateRadioCards(this)">
                                    <div class="twofa-card {{ $level == 2 ? 'active' : '' }}" style="padding: 1rem 1.15rem; border-radius: 12px; border: 1px solid {{ $level == 2 ? 'rgba(16, 185, 129, 0.5)' : 'rgba(255, 255, 255, 0.08)' }}; background: {{ $level == 2 ? 'rgba(16, 185, 129, 0.12)' : 'rgba(8, 6, 18, 0.5)' }}; transition: all 0.2s ease;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                                            <span style="font-weight: 700; font-size: 0.86rem; color: {{ $level == 2 ? '#ffffff' : '#cbd5e1' }};">All Users</span>
                                            <span class="radio-indicator" style="width: 14px; height: 14px; border-radius: 50%; border: 2px solid {{ $level == 2 ? '#10b981' : 'rgba(255, 255, 255, 0.25)' }}; background: {{ $level == 2 ? '#10b981' : 'transparent' }}; display: inline-block;"></span>
                                        </div>
                                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0; line-height: 1.35;">Mandatory for all registered client and administrator accounts.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Action Footer --}}
                <div style="padding: 1rem 1.75rem; border-top: 1px solid rgba(255, 255, 255, 0.06); background: rgba(0, 0, 0, 0.15); display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem;">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-weight: 600; font-size: 0.84rem; border-radius: 10px;">
                        <i data-lucide="save" style="width: 16px; height: 16px;"></i>
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
            const indicator = activeCard.querySelector('.radio-indicator');
            if (indicator) {
                indicator.style.borderColor = color;
                indicator.style.background = color;
            }
        }
    }
    </script>
@endsection
