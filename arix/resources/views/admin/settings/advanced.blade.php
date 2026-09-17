@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'advanced'])

@section('title')
    Advanced Settings
@endsection

@section('content-header')
    <div class="admin-container">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa fa-sliders" style="color: #9f75ff;"></i>
                    Advanced Settings
                    <span style="font-size: 0.72rem; font-weight: 600; color: #c084fc; background: rgba(159, 117, 255, 0.15); border: 1px solid rgba(159, 117, 255, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">SECURITY & NETWORK</span>
                </h1>
                <p style="color: #84809c; font-size: 0.88rem; margin: 0.3rem 0 0 0;">Fine-tune bot defenses, API connection timeouts, and automatic port provisioning.</p>
            </div>
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                <li><a href="{{ route('admin.index') }}" style="color: #9f75ff;"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li class="active" style="color: #cbd5e1;">Settings</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="admin-container">
        <div style="margin-bottom: 1.5rem;">
            @yield('settings::nav')
        </div>
        <div class="row">
        <div class="col-xs-12">
            <form action="" method="POST">
                {{-- 1. Captcha Gateway Card --}}
                <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(159, 117, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #9f75ff;">
                            <i class="fa fa-shield fa-lg"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Captcha Protection</h3>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Prevent brute-force authentication attacks</span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Protection Status</label>
                                <select class="form-control" name="recaptcha:enabled" style="width: 100%;">
                                    <option value="true">Enabled</option>
                                    <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>Disabled</option>
                                </select>
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Performs silent challenges on auth forms, displaying interactive challenges only on suspicious activity.</p>
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Captcha Provider</label>
                                <select class="form-control" name="recaptcha:method" style="width: 100%;">
                                    <option value="recaptcha" @if(old('recaptcha:method', config('recaptcha.method')) == 'recaptcha') selected @endif>Google reCAPTCHA v2 / Invisible</option>
                                    <option value="turnstile" @if(old('recaptcha:method', config('recaptcha.method')) == 'turnstile') selected @endif>Cloudflare Turnstile (Recommended)</option>
                                </select>
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Select your preferred challenge provider for registration and login security.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Google reCAPTCHA Card --}}
                <div class="stat-card" id="recaptcha" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                            <i class="fa fa-google fa-lg"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Google reCAPTCHA API Keys</h3>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Credentials obtained from the Google Cloud Console</span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Site Key</label>
                                <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}" style="width: 100%;">
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Secret Key</label>
                                <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Used for backend validation between Pterodactyl and Google.</p>
                            </div>
                        </div>
                        @if($showRecaptchaWarning)
                            <div style="margin-top: 0.75rem; padding: 0.85rem 1rem; border-radius: 12px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fde68a; font-size: 0.85rem;">
                                <i class="fa fa-warning" style="margin-right: 0.4rem;"></i>
                                You are currently using reCAPTCHA keys that were shipped with this Panel. For improved security it is recommended to <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color: #60a5fa; text-decoration: underline;">generate new keys</a> tied specifically to your domain.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 3. Cloudflare Turnstile Card --}}
                <div class="stat-card" id="turnstile" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(249, 115, 22, 0.15); display: flex; align-items: center; justify-content: center; color: #f97316;">
                            <i class="fa fa-cloud fa-lg"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Cloudflare Turnstile API Keys</h3>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Privacy-first CAPTCHA alternative from Cloudflare</span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Site Key</label>
                                <input type="text" class="form-control" name="turnstile:site_key" value="{{ old('turnstile:site_key', config('turnstile.site_key')) }}" style="width: 100%;">
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Secret Key</label>
                                <input type="text" class="form-control" name="turnstile:site_secret" value="{{ old('turnstile:site_secret', config('turnstile.site_secret')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Used for backend communication between your panel and Cloudflare.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. HTTP Connections Card --}}
                <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                            <i class="fa fa-exchange fa-lg"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">HTTP & Wings Connections</h3>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Guzzle client connection timeout limits</span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Connection Timeout (Seconds)</label>
                                <input type="number" required class="form-control" name="pterodactyl:guzzle:connect_timeout" value="{{ old('pterodactyl:guzzle:connect_timeout', config('pterodactyl.guzzle.connect_timeout')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Maximum time in seconds to wait for a socket connection before aborting.</p>
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Request Timeout (Seconds)</label>
                                <input type="number" required class="form-control" name="pterodactyl:guzzle:timeout" value="{{ old('pterodactyl:guzzle:timeout', config('pterodactyl.guzzle.timeout')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Maximum time in seconds to wait for a complete HTTP response from a Wings node.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 5. Automatic Allocation Creation Card --}}
                <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                    <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981;">
                            <i class="fa fa-network-wired fa-lg"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Automatic Port Allocations</h3>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Client-driven port provisioning on the Network tab</span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem 1.75rem;">
                        <div class="row">
                            <div class="form-group col-md-4" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Self-Service Allocation</label>
                                <select class="form-control" name="pterodactyl:client_features:allocations:enabled" style="width: 100%;">
                                    <option value="false">Disabled</option>
                                    <option value="true" @if(old('pterodactyl:client_features:allocations:enabled', config('pterodactyl.client_features.allocations.enabled'))) selected @endif>Enabled</option>
                                </select>
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Allow users to self-assign additional ports to their active game servers.</p>
                            </div>
                            <div class="form-group col-md-4" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Starting Port</label>
                                <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_start" value="{{ old('pterodactyl:client_features:allocations:range_start', config('pterodactyl.client_features.allocations.range_start')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Lowest port number in the automatically assignable port pool.</p>
                            </div>
                            <div class="form-group col-md-4" style="margin-bottom: 1rem;">
                                <label style="color: #e2e8f0; font-weight: 600; font-size: 0.88rem; margin-bottom: 0.4rem; display: block;">Ending Port</label>
                                <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_end" value="{{ old('pterodactyl:client_features:allocations:range_end', config('pterodactyl.client_features.allocations.range_end')) }}" style="width: 100%;">
                                <p style="color: #64748b; font-size: 0.78rem; margin: 0.35rem 0 0 0;">Highest port number in the automatically assignable port pool.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div style="padding: 1rem 1.75rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem;">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.45rem;">
                            <i class="fa fa-save"></i> Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        (function () {
            function toggleCaptchaBoxes() {
                var select = document.querySelector('select[name="recaptcha:method"]');
                if (!select) return;
                var value = select.value;
                var recaptchaBox = document.getElementById('recaptcha');
                var turnstileBox = document.getElementById('turnstile');
                if (recaptchaBox) recaptchaBox.style.display = (value === 'recaptcha') ? '' : 'none';
                if (turnstileBox) turnstileBox.style.display = (value === 'turnstile') ? '' : 'none';
            }

            document.addEventListener('DOMContentLoaded', function () {
                toggleCaptchaBoxes();
                var select = document.querySelector('select[name="recaptcha:method"]');
                if (select) select.addEventListener('change', toggleCaptchaBoxes);
            });
        })();
    </script>
@endsection
