<?php

return [
    /* GENERAL */
    'logo' => '/arix/Arix.png',
    'logoLight' => '/arix/Arix.png',
    'fullLogo' => false,
    'logoHeight' => '32',
    'discord' => '715281172422197300',
    'support' => 'https://discord.gg/geCjrRbAwC',
    'status' => 'https://status.weijers.one',
    'billing' => 'https://billing.weijers.one',

    /* ANNOUNCEMENT */
    'announcement' => false,
    'announcementColor' => '#16aaaa',
    'announcementIcon' => 'megaphone',
    'announcementMessage' => 'We have a brand new game panel design!',
    'announcementCta' => false,
    'announcementCtaTitle' => 'Buy now!',
    'announcementCtaLink' => '/',
    'announcementDismissable' => false,
    'announcementType' => 'info',
    'announcementCloseable' => false,

    /* STYLING */
    'pageTitle' => true,
    'background' => true,
    'backgroundImage' => '',
    'backgroundImageLight' => '',
    'loginBackground' => '/arix/background-login.png',
    'loginGradient' => false,
    'backgroundFaded' => 'default',

    'backdrop' => false,
    'backdropPercentage' => 100,
    
    'radiusInput' => 7,
    'radiusBox' => 10,
    'borderInput' => true,

    'flashMessage' => 1,

    'font' => 'jetbrains_mono',
    'icon' => 'heroicons',

    /* LAYOUTS */
    'layout' => 1,
    'searchComponent' => 1,
    'logoPosition' => 1,
    'socialPosition' => 1,
    'loginLayout' => 1,

    /* COMPONENTS */
    'serverRow' => 1,
    'statsCards' => 2,
    'sideGraphs' => 2,
    'graphs' => 2,
    'socialButtons' => false,
    'discordBox' => true,

    /* DASHBOARD WIDGETS */
    'dashboardWidgets' => ['banner', 'statCards', 'graphs', 'SFTP'],

    /* LEGACY SLOTS (Compatibility Fallbacks) */
    'slot1' => 'banner',
    'slot2' => 'statCards',
    'slot3' => 'graphs',
    'slot4' => 'SFTP',
    'slot5' => 'disabled',
    'slot6' => 'disabled',
    'slot7' => 'disabled',

    /* COLORS DARKMODE */
    'primary' => '#8B5CF6',
    
    'successText' => '#00E5FF',
    'successBorder' => '#00E5FF',
    'successBackground' => '#083344',

    'dangerText' => '#FFD8D8',
    'dangerBorder' => '#AA2A2A',
    'dangerBackground' => '#8F1F20',

    'secondaryText' => '#CBD5E1',
    'secondaryBorder' => '#8B5CF6',
    'secondaryBackground' => '#101322',

    'gray50' => '#F1F5F9',
    'gray100' => '#E2E8F0',
    'gray200' => '#CBD5E1',
    'gray300' => '#94A3B8',
    'gray400' => '#64748B',
    'gray500' => '#181C32',
    'gray600' => '#101322',
    'gray700' => '#0B0D16',
    'gray800' => '#08090F',
    'gray900' => '#05060A',

    /* COLORS LIGHTMODE */
    'lightmode_primary' => '#4A35CF',
    
    'lightmode_successText' => '#E1FFD8',
    'lightmode_successBorder' => '#56AA2B',
    'lightmode_successBackground' => '#3D8F1F',

    'lightmode_dangerText' => '#FFD8D8',
    'lightmode_dangerBorder' => '#AA2A2A',
    'lightmode_dangerBackground' => '#8F1F20',

    'lightmode_secondaryText' => '#46464D',
    'lightmode_secondaryBorder' => '#C0C0D3',
    'lightmode_secondaryBackground' => '#A6A7BD',

    'lightmode_gray50' => '#141415',
    'lightmode_gray100' => '#27272C',
    'lightmode_gray200' => '#46464D',
    'lightmode_gray300' => '#626272',
    'lightmode_gray400' => '#757689',
    'lightmode_gray500' => '#A6A7BD',
    'lightmode_gray600' => '#C0C0D3',
    'lightmode_gray700' => '#E7E7EF',
    'lightmode_gray800' => '#F0F1F5',
    'lightmode_gray900' => '#FFFFFF',

    /* META DATA */
    'meta_color' => '#4a35cf',
    'meta_title' => 'Pterodactyl Panel',
    'meta_description' => 'Our official Pterodactyl panel',
    'meta_image' => '/arix/meta-tags.png',
    'meta_favicon' => '/arix/Arix.png',

    /* EMAIL */
    'mail_color' => '#4a35cf',
    'mail_backgroundColor' => '#F5F5FF',
    'mail_logo' => 'https://arix.gg/arix.png',
    'mail_logoFull' => false,
    'mail_mode' => 'light',
    'mail_discord' => 'https://arix.gg/discord',
    'mail_twitter' => 'https://x.com',
    'mail_facebook' => 'https://facebook.com',
    'mail_instagram' => 'https://instagram.com',
    'mail_linkedin' => 'https://linkedin.com',
    'mail_youtube' => 'https://youtube.com',

    'mail_status' => 'https://arix.gg/status',
    'mail_billing' => 'https://arix.gg/billing',
    'mail_support' => 'https://arix.gg/support',
    
    /* ADVANCED */
    'profileType'       => 'gravatar',
    'modeToggler'       => true,
    'langSwitch'        => true,
    'defaultLang'       => 'en',
    'languageOptions'   => [['key' => 'en', 'name' => 'English']],
    'ipFlag'            => true,
    'lowResourcesAlert' => false,
    'alertLink'         => '',
    'dashboardPage'     => true,
    'registration'      => false,
    'defaultMode'       => 'darkmode',
    'copyright'         => 'Arix Theme by Rexy',

    /* SOCIALS */
    'socials' => [],
];