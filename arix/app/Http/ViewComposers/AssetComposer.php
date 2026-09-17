<?php

namespace Pterodactyl\Http\ViewComposers;

use Illuminate\View\View;
use Pterodactyl\Services\Helpers\AssetHashService;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class AssetComposer
{
    /**
     * AssetComposer constructor.
     */
    public function __construct(private AssetHashService $assetHashService, private SettingsRepositoryInterface $settings)
    {
    }

    /**
     * Provide access to the asset service in the views.
     */
    public function compose(View $view): void
    {
        $view->with('asset', $this->assetHashService);

        $defaults = config('arix', []);

        $getSetting = function (string $key, mixed $default = null) use ($defaults) {
            try {
                return $this->settings->get("settings::arix:{$key}", $default ?? ($defaults[$key] ?? null));
            } catch (\Throwable $e) {
                return $default ?? ($defaults[$key] ?? null);
            }
        };

        $getJsonSetting = function (string $key, array $default = []) use ($defaults) {
            try {
                $raw = $this->settings->get("settings::arix:{$key}");
                if (empty($raw)) {
                    return $defaults[$key] ?? $default;
                }
                $decoded = json_decode($raw, true);
                return is_array($decoded) ? $decoded : ($defaults[$key] ?? $default);
            } catch (\Throwable $e) {
                return $defaults[$key] ?? $default;
            }
        };

        $arixConfig = [
            /* GENERAL */
            'logo' => $getSetting('logo', '/arix/Arix.png'),
            'logoLight' => $getSetting('logoLight', '/arix/Arix.png'),
            'fullLogo' => $getSetting('fullLogo', false),
            'logoHeight' => $getSetting('logoHeight', '32'),
            'discord' => $getSetting('discord', '715281172422197300'),
            'support' => $getSetting('support', 'https://discord.gg/geCjrRbAwC'),
            'status' => $getSetting('status', 'https://status.weijers.one'),
            'billing' => $getSetting('billing', 'https://billing.weijers.one'),

            /* ANNOUNCEMENT */
            'announcement' => $getSetting('announcement', false),
            'announcementColor' => $getSetting('announcementColor', '#16aaaa'),
            'announcementIcon' => $getSetting('announcementIcon', 'megaphone'),
            'announcementMessage' => $getSetting('announcementMessage', 'We have a brand new game panel design!'),
            'announcementCta' => $getSetting('announcementCta', false),
            'announcementCtaTitle' => $getSetting('announcementCtaTitle', 'Buy now!'),
            'announcementCtaLink' => $getSetting('announcementCtaLink', '/'),
            'announcementDismissable' => $getSetting('announcementDismissable', false),
            'announcementType' => $getSetting('announcementType', 'info'),
            'announcementCloseable' => $getSetting('announcementCloseable', false),

            /* STYLING */
            'pageTitle' => $getSetting('pageTitle', true),

            'background' => $getSetting('background', true),
            'backgroundImage' => $getSetting('backgroundImage', ''),
            'backgroundImageLight' => $getSetting('backgroundImageLight', ''),
            'loginBackground' => $getSetting('loginBackground', '/arix/background-login.png'),
            'loginGradient' => $getSetting('loginGradient', false),
            'backgroundFaded' => $getSetting('backgroundFaded', 'default'),

            'backdrop' => $getSetting('backdrop', false),
            'backdropPercentage' => $getSetting('backdropPercentage', 100),
            
            'radiusInput' => $getSetting('radiusInput', 7),
            'radiusBox' => $getSetting('radiusBox', 10),
            'borderInput' => $getSetting('borderInput', true),

            'flashMessage' => $getSetting('flashMessage', 1),

            'font' => $getSetting('font', 'default'),
            'icon' => $getSetting('icon', 'heroicons'),

            /* LAYOUTS */
            'layout' => $getSetting('layout', 1),
            'searchComponent' => $getSetting('searchComponent', 1),

            'logoPosition' => $getSetting('logoPosition', 1),
            'socialPosition' => $getSetting('socialPosition', 1),
            'loginLayout' => $getSetting('loginLayout', 1),

            /* COMPONENTS */
            'serverRow' => $getSetting('serverRow', 1),
            'statsCards' => $getSetting('statsCards', 2),
            'sideGraphs' => $getSetting('sideGraphs', 2),
            'graphs' => $getSetting('graphs', 2),

            /* DASHBOARD WIDGETS */
            'dashboardWidgets' => (function() use ($getJsonSetting, $getSetting, $defaults) {
                $widgets = $getJsonSetting('dashboardWidgets', []);
                if (!empty($widgets)) {
                    return $widgets;
                }
                $slots = [];
                for ($i = 1; $i <= 7; $i++) {
                    $s = $getSetting("slot{$i}", 'disabled');
                    if ($s !== 'disabled' && !empty($s)) {
                        $slots[] = $s;
                    }
                }
                if (!empty($slots)) {
                    return $slots;
                }
                return $defaults['dashboardWidgets'] ?? ['banner', 'statCards', 'graphs', 'SFTP'];
            })(),

            /* LEGACY SLOTS (Compatibility) */
            'slot1' => $getSetting('slot1', 'banner'),
            'slot2' => $getSetting('slot2', 'statCards'),
            'slot3' => $getSetting('slot3', 'graphs'),
            'slot4' => $getSetting('slot4', 'SFTP'),
            'slot5' => $getSetting('slot5', 'disabled'),
            'slot6' => $getSetting('slot6', 'disabled'),
            'slot7' => $getSetting('slot7', 'disabled'),

            /* COLORS DARKMODE */
            'primary' => $getSetting('primary', '#4A35CF'),
            
            'successText' => $getSetting('successText', '#E1FFD8'),
            'successBorder' => $getSetting('successBorder', '#56AA2B'),
            'successBackground' => $getSetting('successBackground', '#3D8F1F'),

            'dangerText' => $getSetting('dangerText', '#FFD8D8'),
            'dangerBorder' => $getSetting('dangerBorder', '#AA2A2A'),
            'dangerBackground' => $getSetting('dangerBackground', '#8F1F20'),

            'secondaryText' => $getSetting('secondaryText', '#B2B2C1'),
            'secondaryBorder' => $getSetting('secondaryBorder', '#42425B'),
            'secondaryBackground' => $getSetting('secondaryBackground', '#2B2B40'),

            'gray50' => $getSetting('gray50', '#F4F4F4'),
            'gray100' => $getSetting('gray100', '#D5D5DB'),
            'gray200' => $getSetting('gray200', '#B2B2C1'),
            'gray300' => $getSetting('gray300', '#8282A4'),
            'gray400' => $getSetting('gray400', '#5E5E7F'),
            'gray500' => $getSetting('gray500', '#42425B'),
            'gray600' => $getSetting('gray600', '#2B2B40'),
            'gray700' => $getSetting('gray700', '#1D1D37'),
            'gray800' => $getSetting('gray800', '#0B0D2A'),
            'gray900' => $getSetting('gray900', '#040519'),

            /* COLORS LIGHTMODE */
            'lightmode_primary' => $getSetting('lightmode_primary', '#4A35CF'),
            
            'lightmode_successText' => $getSetting('lightmode_successText', '#E1FFD8'),
            'lightmode_successBorder' => $getSetting('lightmode_successBorder', '#56AA2B'),
            'lightmode_successBackground' => $getSetting('lightmode_successBackground', '#3D8F1F'),

            'lightmode_dangerText' => $getSetting('lightmode_dangerText', '#FFD8D8'),
            'lightmode_dangerBorder' => $getSetting('lightmode_dangerBorder', '#AA2A2A'),
            'lightmode_dangerBackground' => $getSetting('lightmode_dangerBackground', '#8F1F20'),

            'lightmode_secondaryText' => $getSetting('lightmode_secondaryText', '#46464D'),
            'lightmode_secondaryBorder' => $getSetting('lightmode_secondaryBorder', '#C0C0D3'),
            'lightmode_secondaryBackground' => $getSetting('lightmode_secondaryBackground', '#A6A7BD'),

            'lightmode_gray50' => $getSetting('lightmode_gray50', '#141415'),
            'lightmode_gray100' => $getSetting('lightmode_gray100', '#27272C'),
            'lightmode_gray200' => $getSetting('lightmode_gray200', '#46464D'),
            'lightmode_gray300' => $getSetting('lightmode_gray300', '#626272'),
            'lightmode_gray400' => $getSetting('lightmode_gray400', '#757689'),
            'lightmode_gray500' => $getSetting('lightmode_gray500', '#A6A7BD'),
            'lightmode_gray600' => $getSetting('lightmode_gray600', '#C0C0D3'),
            'lightmode_gray700' => $getSetting('lightmode_gray700', '#E7E7EF'),
            'lightmode_gray800' => $getSetting('lightmode_gray800', '#F0F1F5'),
            'lightmode_gray900' => $getSetting('lightmode_gray900', '#FFFFFF'),

            /* META DATA */
            'meta_color' => $getSetting('meta_color', '#4a35cf'),
            'meta_title' => $getSetting('meta_title', 'Pterodactyl Panel'),
            'meta_description' => $getSetting('meta_description', 'Our official Pterodactyl panel'),
            'meta_image' => $getSetting('meta_image', '/arix/meta-tags.png'),
            'meta_favicon' => $getSetting('meta_favicon', '/arix/Arix.png'),

            /* EMAIL */
            'mail_color' => $getSetting('mail_color', '#4a35cf'),
            'mail_backgroundColor' => $getSetting('mail_backgroundColor', '#F5F5FF'),
            'mail_logo' => $getSetting('mail_logo', 'https://arix.gg/arix.png'),
            'mail_logoFull' => $getSetting('mail_logoFull', false),
            'mail_mode' => $getSetting('mail_mode', 'light'),

            'mail_discord' => $getSetting('mail_discord', 'https://arix.gg/discord'),
            'mail_twitter' => $getSetting('mail_twitter', 'https://x.com'),
            'mail_facebook' => $getSetting('mail_facebook', 'https://facebook.com'),
            'mail_instagram' => $getSetting('mail_instagram', 'https://instagram.com'),
            'mail_linkedin' => $getSetting('mail_linkedin', 'https://linkedin.com'),
            'mail_youtube' => $getSetting('mail_youtube', 'https://youtube.com'),

            'mail_status' => $getSetting('mail_status', 'https://arix.gg/status'),
            'mail_billing' => $getSetting('mail_billing', 'https://arix.gg/billing'),
            'mail_support' => $getSetting('mail_support', 'https://arix.gg/support'),

            /* Advanced */
            'profileType'       => $getSetting('profileType', 'gravatar'),
            'modeToggler'       => $getSetting('modeToggler', true),
            'langSwitch'        => $getSetting('langSwitch', true),
            'defaultLang'      => $getSetting('defaultLang', 'en'),
            'languageOptions'    => $getJsonSetting('languageOptions', [['key' => 'en', 'name' => 'English']]),
            'ipFlag'            => $getSetting('ipFlag', true),
            'lowResourcesAlert' => $getSetting('lowResourcesAlert', false),
            'alertLink'         => $getSetting('alertLink', ''),
            'dashboardPage'       => $getSetting('dashboardPage', true),
            'registration'     => $getSetting('registration', false),
            'defaultMode' => $getSetting('defaultMode', 'darkmode'),
            'copyright' => $getSetting('copyright', 'Arix Theme by Rexy'),

            /* SOCIALS */
            'socials' => (function() use ($getJsonSetting, $getSetting, $defaults) {
                $soc = $getJsonSetting('socials', []);
                if (!empty($soc)) {
                    return $soc;
                }
                $list = [];
                $billing = $getSetting('billing', $defaults['billing'] ?? '');
                if (!empty($billing)) {
                    $list[] = ['title' => 'Billing Area', 'icon' => 'billing', 'description' => 'Manage your services', 'link' => $billing];
                }
                $support = $getSetting('support', $defaults['support'] ?? '');
                if (!empty($support)) {
                    $list[] = ['title' => 'Support Center', 'icon' => 'support', 'description' => 'Get support', 'link' => $support];
                }
                $status = $getSetting('status', $defaults['status'] ?? '');
                if (!empty($status)) {
                    $list[] = ['title' => 'Server Status', 'icon' => 'status', 'description' => 'Check server status', 'link' => $status];
                }
                return $list;
            })(),
            'socialButtons' => $getSetting('socialButtons', false),
            'discordBox' => $getSetting('discordBox', true),
        ];

        $view->with('siteConfiguration', [
            'name' => config('app.name', 'Pterodactyl'),
            'arix' => $arixConfig,
            'locale' => config('app.locale', 'en'),
            'recaptcha' => [
                'enabled' => config('recaptcha.enabled', false),
                'method' => config('recaptcha.method', 'recaptcha'),
                'siteKey' => config('recaptcha.website_key', ''),
            ],
            'turnstile' => [
                'siteKey' => config('turnstile.site_key', ''),
            ],
        ]);
    }
}
