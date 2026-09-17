@extends('layouts.admin')

@section('title')
    Nodes & Compute
@endsection

@section('scripts')
    @parent
    {!! Theme::css('vendor/fontawesome/animation.min.css') !!}
@endsection

@section('content-header')
    <div class="admin-container">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
            <div>
                <h1 style="font-size: 1.65rem; font-weight: 800; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.65rem; letter-spacing: -0.02em;">
                    <i class="fa fa-server" style="color: #38bdf8;"></i>
                    Compute Nodes
                    <span style="font-size: 0.7rem; font-weight: 700; color: #38bdf8; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">INFRASTRUCTURE</span>
                </h1>
                <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.35rem 0 0 0;">Manage physical hardware, daemon connectivity, and resource allocations for game servers.</p>
            </div>
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0; display: flex; align-items: center; gap: 0.4rem; font-size: 0.85rem;">
                <li><a href="{{ route('admin.index') }}" style="color: #a855f7; text-decoration: none;"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li style="color: #4f4d68;">/</li>
                <li class="active" style="color: #cbd5e1; font-weight: 600;">Nodes</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="admin-container">
    <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem; background: #161327; border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 14px; box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.05), 0 4px 20px rgba(0, 0, 0, 0.4);">
        {{-- Card Header & Action Toolbar --}}
        <div style="padding: 1.25rem 1.65rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); background: #141124; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.25); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                    <i class="fa fa-list-ul fa-lg"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: #ffffff;">Node Instances</h3>
                    <span style="font-size: 0.78rem; color: #84809c;">Active Wings daemons in cluster</span>
                </div>
            </div>

            {{-- Right: Search & Create New --}}
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <form action="{{ route('admin.nodes') }}" method="GET" style="margin: 0;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <i class="fa fa-search" style="position: absolute; left: 12px; color: #64748b; font-size: 0.85rem; pointer-events: none;"></i>
                        <input type="text" name="filter[name]" value="{{ request()->input('filter.name') }}" placeholder="Search nodes by name..." class="admin-input" style="padding-left: 2.25rem; padding-right: 0.75rem; min-width: 240px; height: 38px; font-size: 0.84rem; border-radius: 8px;">
                    </div>
                </form>

                <a href="{{ route('admin.nodes.new') }}" class="btn btn-primary" style="height: 38px; padding: 0 1.15rem; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.45rem; text-decoration: none; border-radius: 8px;">
                    <i class="fa fa-plus-circle"></i> Deploy Node
                </a>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="table-responsive" style="overflow-x: auto; margin: 0;">
            <table class="table" style="margin: 0; border-collapse: separate; border-spacing: 0; width: 100%;">
                <thead>
                    <tr style="background: rgba(8, 6, 18, 0.4); border-bottom: 1px solid rgba(255, 255, 255, 0.06);">
                        <th style="width: 48px; padding: 0.9rem 1rem; text-align: center; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);"></th>
                        <th style="padding: 0.9rem 1.25rem; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Node Name</th>
                        <th style="padding: 0.9rem 1.25rem; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Location</th>
                        <th style="padding: 0.9rem 1.25rem; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Memory</th>
                        <th style="padding: 0.9rem 1.25rem; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Disk</th>
                        <th style="padding: 0.9rem 1.25rem; text-align: center; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Servers</th>
                        <th style="padding: 0.9rem 1.25rem; text-align: center; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">SSL</th>
                        <th style="padding: 0.9rem 1.25rem; text-align: center; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Visibility</th>
                        <th style="padding: 0.9rem 1.25rem; text-align: right; color: #84809c; font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-top: none; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nodes as $node)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.04); transition: background 0.15s ease;">
                            {{-- Heartbeat Ping --}}
                            <td class="text-center text-muted left-icon" data-action="ping" data-secret="{{ $node->getDecryptedKey() }}" data-location="{{ $node->scheme }}://{{ $node->fqdn }}:{{ $node->daemonListen }}/api/system" style="vertical-align: middle; padding: 1rem 0.5rem; text-align: center;">
                                <i class="fa fa-fw fa-refresh fa-spin" style="color: #64748b;"></i>
                            </td>

                            {{-- Name & Status --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem;">
                                @if($node->maintenance_mode)
                                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #f59e0b; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.1rem 0.45rem; border-radius: 4px; margin-right: 0.4rem; text-transform: uppercase;">
                                        <i class="fa fa-wrench"></i> MAINT
                                    </span>
                                @endif
                                <a href="{{ route('admin.nodes.view', $node->id) }}" style="color: #ffffff; font-weight: 600; font-size: 0.92rem; text-decoration: none; transition: color 0.15s ease;" onmouseover="this.style.color='#9f75ff'" onmouseout="this.style.color='#ffffff'">
                                    {{ $node->name }}
                                </a>
                                <div style="font-size: 0.75rem; color: #64748b; font-family: 'JetBrains Mono', monospace; margin-top: 2px;">
                                    {{ $node->fqdn }}:{{ $node->daemonListen }}
                                </div>
                            </td>

                            {{-- Location --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.78rem; font-weight: 600; color: #cbd5e1; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); padding: 0.25rem 0.65rem; border-radius: 6px;">
                                    <i class="fa fa-globe" style="color: #9f75ff; font-size: 0.72rem;"></i>
                                    {{ $node->location->short }}
                                </span>
                            </td>

                            {{-- Memory --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; color: #cbd5e1; font-weight: 500; font-size: 0.85rem;">
                                <div>{{ number_format($node->memory) }} MiB</div>
                                <div style="font-size: 0.72rem; color: #64748b;">
                                    {{ round($node->memory / 1024, 1) }} GiB Allocated
                                </div>
                            </td>

                            {{-- Disk --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; color: #cbd5e1; font-weight: 500; font-size: 0.85rem;">
                                <div>{{ number_format($node->disk) }} MiB</div>
                                <div style="font-size: 0.72rem; color: #64748b;">
                                    {{ round($node->disk / 1024, 1) }} GiB Max
                                </div>
                            </td>

                            {{-- Servers Count --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; text-align: center;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 32px; padding: 0.2rem 0.55rem; font-size: 0.8rem; font-weight: 700; color: #c4b5fd; background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3); border-radius: 9999px;">
                                    {{ $node->servers_count }}
                                </span>
                            </td>

                            {{-- SSL --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; text-align: center;">
                                @if($node->scheme === 'https')
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; color: #6ee7b7; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        <i class="fa fa-lock"></i> HTTPS
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; color: #fca5a5; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        <i class="fa fa-unlock"></i> HTTP
                                    </span>
                                @endif
                            </td>

                            {{-- Public Visibility --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; text-align: center;">
                                @if($node->public)
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; color: #93c5fd; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        <i class="fa fa-eye"></i> Public
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; color: #94a3b8; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: 0.2rem 0.55rem; border-radius: 6px;">
                                        <i class="fa fa-eye-slash"></i> Private
                                    </span>
                                @endif
                            </td>

                            {{-- Action --}}
                            <td style="vertical-align: middle; padding: 1rem 1.25rem; text-align: right;">
                                <a href="{{ route('admin.nodes.view', $node->id) }}" class="btn btn-default btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none;">
                                    <i class="fa fa-sliders"></i> Configure
                                </a>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State (Replaces the vast empty black void) --}}
                        <tr>
                            <td colspan="9" style="padding: 4.5rem 2rem; text-align: center; border: none;">
                                <div style="width: 64px; height: 64px; border-radius: 16px; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2); display: inline-flex; align-items: center; justify-content: center; color: #38bdf8; font-size: 1.75rem; margin-bottom: 1.25rem;">
                                    <i class="fa fa-server"></i>
                                </div>
                                <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin: 0 0 0.5rem 0;">No Compute Nodes Configured</h3>
                                <p style="font-size: 0.88rem; color: #84809c; max-width: 460px; margin: 0 auto 1.5rem auto; line-height: 1.5;">
                                    @if(request()->has('filter.name'))
                                        No nodes matched your search query "{{ request()->input('filter.name') }}". Try checking for typos or clear the search filter.
                                    @else
                                        You have not deployed any physical compute nodes to your cluster yet. Deploy a Wings daemon instance to begin orchestrating game servers.
                                    @endif
                                </p>
                                <div>
                                    @if(request()->has('filter.name'))
                                        <a href="{{ route('admin.nodes') }}" class="btn btn-default" style="display: inline-flex; align-items: center; gap: 0.4rem; margin-right: 0.5rem; text-decoration: none;">
                                            <i class="fa fa-times"></i> Clear Search
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.nodes.new') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.45rem; text-decoration: none;">
                                        <i class="fa fa-plus-circle"></i> Deploy First Node
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        @if($nodes->hasPages())
            <div style="padding: 1rem 1.65rem; border-top: 1px solid rgba(255, 255, 255, 0.06); background: #121020; display: flex; align-items: center; justify-content: center;">
                {!! $nodes->appends(['filter' => Request::input('filter')])->render() !!}
            </div>
        @endif
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    (function pingNodes() {
        $('td[data-action="ping"]').each(function(i, element) {
            $.ajax({
                type: 'GET',
                url: $(element).data('location'),
                headers: {
                    'Authorization': 'Bearer ' + $(element).data('secret'),
                },
                timeout: 5000
            }).done(function (data) {
                $(element).find('i').tooltip({
                    title: 'v' + (data.version || 'Connected'),
                });
                $(element).removeClass('text-muted').find('i').removeClass().addClass('fa fa-fw fa-heartbeat faa-pulse animated').css('color', '#10b981');
            }).fail(function (error) {
                var errorText = 'Error connecting to node daemon!';
                try {
                    errorText = error.responseJSON.errors[0].detail || errorText;
                } catch (ex) {}

                $(element).removeClass('text-muted').find('i').removeClass().addClass('fa fa-fw fa-heart-o').css('color', '#ef4444');
                $(element).find('i').tooltip({ title: errorText });
            });
        }).promise().done(function () {
            setTimeout(pingNodes, 10000);
        });
    })();
    </script>
@endsection
