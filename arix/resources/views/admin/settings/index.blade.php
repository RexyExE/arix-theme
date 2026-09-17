@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'basic'])

@section('title')
    Settings
@endsection

@section('content-header')
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                <i class="fa fa-cog" style="color: #a855f7;"></i>
                Panel Settings
                <span style="font-size: 0.72rem; font-weight: 600; color: #a855f7; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">CORE</span>
            </h1>
            <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.3rem 0 0 0;">Configure your panel's identity, security policies, and operational defaults.</p>
        </div>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
            <li><a href="{{ route('admin.index') }}" style="color: #a855f7;"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li class="active" style="color: #cbd5e1;">Settings</li>
        </ol>
    </div>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row" style="margin-top: 0.75rem;">
        {{-- Settings Form Card --}}
        <div class="col-xs-12">
            <div class="stat-card" style="padding: 0; overflow: hidden;">
                {{-- Card Header --}}
                <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <i class="fa fa-building fa-lg"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">General Configuration</h3>
                        <span style="font-size: 0.75rem; color: #94a3b8;">Brand identity & authentication</span>
                    </div>
                </div>

                <form action="{{ route('admin.settings') }}" method="POST">
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row" style="gap: 1.25rem 0;">
                            {{-- Company Name --}}
                            <div class="col-md-6" style="margin-bottom: 1.25rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-tag" style="color: #a855f7; margin-right: 0.35rem; font-size: 0.82rem;"></i>
                                    Company Name
                                </label>
                                <input type="text" class="form-control" name="app:name" value="{{ old('app:name', config('app.name')) }}" style="width: 100%;" />
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">This name appears throughout the panel and in all client-facing emails.</p>
                            </div>

                            {{-- 2FA Requirement --}}
                            <div class="col-md-6" style="margin-bottom: 1.25rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.6rem; display: block;">
                                    <i class="fa fa-shield" style="color: #10b981; margin-right: 0.35rem; font-size: 0.82rem;"></i>
                                    Two-Factor Authentication
                                </label>
                                @php
                                    $level = old('pterodactyl:auth:2fa_required', config('pterodactyl.auth.2fa_required'));
                                @endphp
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <label style="cursor: pointer; padding: 0.55rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ $level == 0 ? 'rgba(139, 92, 246, 0.5)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ $level == 0 ? 'rgba(139, 92, 246, 0.2)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ $level == 0 ? '#c4b5fd' : '#94a3b8' }}; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.35rem;">
                                        <input type="radio" name="pterodactyl:auth:2fa_required" value="0" @if ($level == 0) checked @endif style="display: none;">
                                        Not Required
                                    </label>
                                    <label style="cursor: pointer; padding: 0.55rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ $level == 1 ? 'rgba(245, 158, 11, 0.5)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ $level == 1 ? 'rgba(245, 158, 11, 0.18)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ $level == 1 ? '#fcd34d' : '#94a3b8' }}; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.35rem;">
                                        <input type="radio" name="pterodactyl:auth:2fa_required" value="1" @if ($level == 1) checked @endif style="display: none;">
                                        Admin Only
                                    </label>
                                    <label style="cursor: pointer; padding: 0.55rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ $level == 2 ? 'rgba(16, 185, 129, 0.5)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ $level == 2 ? 'rgba(16, 185, 129, 0.18)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ $level == 2 ? '#6ee7b7' : '#94a3b8' }}; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.35rem;">
                                        <input type="radio" name="pterodactyl:auth:2fa_required" value="2" @if ($level == 2) checked @endif style="display: none;">
                                        All Users
                                    </label>
                                </div>
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.5rem 0 0 0;">Users in the selected group must enable 2FA before accessing the panel.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div style="padding: 1rem 1.75rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem;">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="button button-primary" style="padding: 0.55rem 1.35rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.45rem;">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
