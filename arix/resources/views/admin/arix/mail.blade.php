@extends('layouts.arix', ['navbar' => 'mail', 'sideEditor' => false])

@section('title')
    Arix Mail
@endsection

@section('content')
    <form action="{{ route('admin.arix.mail') }}" method="POST" class="content-box">
        <div class="header" style="display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); margin-bottom: 1.25rem;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.1)); display: flex; align-items: center; justify-content: center; color: #3b82f6; flex-shrink: 0;">
                <i data-lucide="mailbox" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    Email Templates
                    <span style="font-size: 0.62rem; font-weight: 700; color: #3b82f6; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">NOTIFICATIONS</span>
                </p>
                <span class="description-text" style="color: #94a3b8; font-size: 0.82rem;">Customize HTML email notification templates, header logo, background tone, and brand accents.</span>
            </div>
        </div>

        <x-arix.form-wrapper 
            title="Logo Settings" 
            description="Configure the logo settings for your mail templates."
        >
            <x-arix.input-field 
                id="arix:mail_logo" 
                :value="$mail_logo" 
                label="Mail logo"
            />
            <x-arix.switch 
                id="arix:mail_logoFull"
                name="arix:mail_logoFull"
                :value="$mail_logoFull"
                label="Logo only"
            />
        </x-arix.form-wrapper>
        <x-arix.form-wrapper 
            title="Mail Styling" 
            description="Configure the mail styling settings for your mail templates."
        >
            <div class="input-field">
                <label for="mail_color">Mail primary color</label>
                <x-arix.color-input
                    target="mail_color"
                    id="arix:mail_color"
                    :value="$mail_color"
                />
            </div>
            <div class="input-field">
                <label for="mail_backgroundColor">Mail background color</label>
                <x-arix.color-input
                    target="mail_backgroundColor"
                    id="arix:mail_backgroundColor" 
                    :value="$mail_backgroundColor"
                />
            </div>
            <div class="input-field">
                <label for="arix:mail_mode">Mail color mode</label>
                <select
                    id="arix:mail_mode"
                    name="arix:mail_mode"
                >
                    <option value="dark" @if(old('arix:mail_mode', $mail_mode) == 'dark') selected @endif>Dark mode</option>
                    <option value="light" @if(old('arix:mail_mode', $mail_mode) == 'light') selected @endif>Light mode</option>
                </select>
                <span style="font-size:0.8rem">If the background color is light, use a light setting. If the background color is dark, use a dark setting.</span>
            </div>
        </x-arix.form-wrapper>
        <x-arix.form-wrapper 
            title="Utility Links" 
            description="Configure the utility links settings for your mail templates. Leave empty to remove a specific utility link."
        >
            <x-arix.input-field 
                id="arix:mail_status" 
                :value="$mail_status"
                label="Mail status page"
            />
            <x-arix.input-field 
                id="arix:mail_billing" 
                :value="$mail_billing" 
                label="Mail billing"
            />
            <x-arix.input-field 
                id="arix:mail_support" 
                :value="$mail_support" 
                label="Mail support"
            />
        </x-arix.form-wrapper>
        <x-arix.form-wrapper 
            title="Mail socials" 
            description="Configure the mail socials settings for your mail templates. Leave empty to remove a specific social link."
        >
            <x-arix.input-field 
                id="arix:mail_discord" 
                :value="$mail_discord" 
                label="Mail discord"
            />
            <x-arix.input-field 
                id="arix:mail_twitter" 
                :value="$mail_twitter" 
                label="Mail Twitter"
            />
            <x-arix.input-field 
                id="arix:mail_facebook" 
                :value="$mail_facebook" 
                label="Mail Facebook"
            />
            <x-arix.input-field 
                id="arix:mail_instagram" 
                :value="$mail_instagram" 
                label="Mail Instagram"
            />
            <x-arix.input-field 
                id="arix:mail_linkedin" 
                :value="$mail_linkedin" 
                label="Mail Linkedin"
            />
            <x-arix.input-field 
                id="arix:mail_youtube" 
                :value="$mail_youtube" 
                label="Mail Youtube"
            />
        </x-arix.form-wrapper>

        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>
@endsection