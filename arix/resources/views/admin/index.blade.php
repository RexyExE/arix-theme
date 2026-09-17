@extends('layouts.admin')

@section('title')
    Administrative Overview
@endsection

@section('content-header')
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                Administrative Overview
                <span style="font-size: 0.72rem; font-weight: 600; color: #a855f7; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">Silk Veil v3</span>
            </h1>
            <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.3rem 0 0 0;">Unified infrastructure oversight, node telemetry, and cluster diagnostics.</p>
        </div>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
            <li><a href="{{ route('admin.index') }}" style="color: #a855f7;"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li class="active" style="color: #cbd5e1;">Overview</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="row" style="margin-top: 0.75rem;">
    {{-- 1. Administrative Command Center Hero Banner --}}
    <div class="col-xs-12">
        <div class="mori-hero-banner" style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <span class="mori-hero-tag" style="color: #c084fc; font-weight: 700; letter-spacing: 0.15em;">COMMAND CENTER OVERSIGHT</span>
                    <h2 class="mori-hero-title" style="margin: 0.35rem 0; font-size: 1.75rem;">System Core Diagnostics</h2>
                    <p class="mori-hero-subtitle" style="max-width: 680px;">Your central vantage point across panel processes, node connectivity, database integrity, and theme customization.</p>
                </div>
                <div style="display: inline-flex; align-items: center; gap: 0.6rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.45rem 1rem; border-radius: 9999px;">
                    <span class="telemetry-live-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 10px #10b981; display: inline-block;"></span>
                    <span style="color: #10b981; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.1em;">DAEMON SOCKET: ACTIVE</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. System Integrity & Arix Theme Status (2-Column Grid) --}}
    <div class="col-xs-12 col-md-6" style="margin-bottom: 1.5rem;">
        <div class="stat-card" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                            <i class="fa fa-server fa-lg"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Pterodactyl Core</h4>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Runtime Environment</span>
                        </div>
                    </div>
                    @if($version->isLatestPanel())
                        <span style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 600;">
                            <i class="fa fa-check-circle"></i> UP TO DATE
                        </span>
                    @else
                        <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 600;">
                            <i class="fa fa-exclamation-triangle"></i> UPDATE READY
                        </span>
                    @endif
                </div>

                <div style="margin: 1.2rem 0;">
                    <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono, monospace);">
                        v{{ config('app.version') }}
                    </div>
                    <p style="font-size: 0.85rem; color: #cbd5e1; margin-top: 0.35rem;">
                        @if ($version->isLatestPanel())
                            Your core panel is operating on the official release build.
                        @else
                            New build available: <a href="https://github.com/Pterodactyl/Panel/releases/v{{ $version->getPanel() }}" target="_blank" style="color: #00e5ff; font-weight: 600;">v{{ $version->getPanel() }}</a>.
                        @endif
                    </p>
                </div>
            </div>

            <div style="padding-top: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: #94a3b8;">
                <span>PHP <strong>{{ phpversion() }}</strong></span>
                <span>Laravel <strong>{{ app()->version() }}</strong></span>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-6" style="margin-bottom: 1.5rem;">
        <div class="stat-card" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(168, 85, 247, 0.18); display: flex; align-items: center; justify-content: center; color: #c084fc;">
                            <i class="fa fa-paint-brush fa-lg"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Arix Theme Engine</h4>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Silk Veil / Bubble Glass</span>
                        </div>
                    </div>
                    <span style="background: rgba(139, 92, 246, 0.18); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.35); padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 600;">
                        ACTIVE OVERLAY
                    </span>
                </div>

                <div style="margin: 1.2rem 0;">
                    <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono, monospace);">
                        v{{ config('app.arix') }} <span style="font-size: 1rem; color: #a855f7; font-weight: 600;">(Silk Veil)</span>
                    </div>
                    <p style="font-size: 0.85rem; color: #cbd5e1; margin-top: 0.35rem;">
                        Ultra-smooth glassmorphism, bubble pill navigation, and ambient aura active.
                    </p>
                </div>
            </div>

            <div style="padding-top: 0.85rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.78rem; color: #94a3b8;">Theme Configuration</span>
                <a href="{{ route('admin.arix') }}" class="button button-primary" style="padding: 0.35rem 0.85rem; font-size: 0.78rem; border-radius: 9999px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="fa fa-sliders"></i> Open Arix Editor
                </a>
            </div>
        </div>
    </div>

    {{-- 3. Infrastructure Quick Action Hub (4 Cards) --}}
    <div class="col-xs-12" style="margin-bottom: 0.75rem;">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa fa-cubes" style="color: #a855f7;"></i> Infrastructure Hub
        </h3>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.servers') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.72rem; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.1em;">SERVERS</span>
                    <i class="fa fa-terminal" style="color: #94a3b8;"></i>
                </div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Game & Bot Fleet</div>
                <p style="font-size: 0.78rem; color: #94a3b8; margin: 0.35rem 0 0 0;">Provision, suspend & manage containers</p>
            </div>
        </a>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.nodes') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.72rem; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.1em;">NODES</span>
                    <i class="fa fa-sitemap" style="color: #94a3b8;"></i>
                </div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Compute Clusters</div>
                <p style="font-size: 0.78rem; color: #94a3b8; margin: 0.35rem 0 0 0;">Daemon daemons & allocations</p>
            </div>
        </a>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.databases') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.72rem; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.1em;">DATABASES</span>
                    <i class="fa fa-database" style="color: #94a3b8;"></i>
                </div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Database Hosts</div>
                <p style="font-size: 0.78rem; color: #94a3b8; margin: 0.35rem 0 0 0;">MySQL cluster endpoints</p>
            </div>
        </a>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 1.25rem;">
        <a href="{{ route('admin.nests') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.72rem; font-weight: 700; color: #a855f7; text-transform: uppercase; letter-spacing: 0.1em;">NESTS & EGGS</span>
                    <i class="fa fa-archive" style="color: #94a3b8;"></i>
                </div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Service Templates</div>
                <p style="font-size: 0.78rem; color: #94a3b8; margin: 0.35rem 0 0 0;">Game scripts & Docker images</p>
            </div>
        </a>
    </div>

    {{-- 4. Official Ecosystem & Community Resources (Frosted Glass Bubble Buttons) --}}
    <div class="col-xs-12" style="margin-top: 1rem; margin-bottom: 1.5rem;">
        <div style="background: rgba(18, 16, 34, 0.65); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 18px; padding: 1.25rem 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <span style="font-size: 0.88rem; font-weight: 600; color: #cbd5e1;">Official Ecosystem & Community Links</span>
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ $version->getDiscord() }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                        <button type="button" class="button" style="background: rgba(114, 137, 218, 0.18); border: 1px solid rgba(114, 137, 218, 0.35); color: #99aab5; padding: 0.5rem 1.1rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fa fa-comments"></i> Discord Support
                        </button>
                    </a>
                    <a href="https://pterodactyl.io" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                        <button type="button" class="button" style="background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3); color: #c084fc; padding: 0.5rem 1.1rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fa fa-book"></i> Documentation
                        </button>
                    </a>
                    <a href="https://github.com/pterodactyl/panel" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                        <button type="button" class="button" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); color: #e2e8f0; padding: 0.5rem 1.1rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fa fa-github"></i> GitHub
                        </button>
                    </a>
                    <a href="{{ $version->getDonations() }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                        <button type="button" class="button" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 0.5rem 1.1rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fa fa-heart"></i> Sponsor
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
