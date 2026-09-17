@extends('layouts.admin')

@section('title')
    {{ $node->name }}: Settings
@endsection

@section('content-header')
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                <i class="fa fa-server" style="color: #38bdf8;"></i>
                {{ $node->name }}
                <span style="font-size: 0.72rem; font-weight: 600; color: #38bdf8; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">NODE SETTINGS</span>
            </h1>
            <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.3rem 0 0 0;">Adjust node resources, network parameters, and Arix console branding.</p>
        </div>
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
            <li><a href="{{ route('admin.index') }}" style="color: #38bdf8;"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="{{ route('admin.nodes') }}" style="color: #38bdf8;">Nodes</a></li>
            <li><a href="{{ route('admin.nodes.view', $node->id) }}" style="color: #cbd5e1;">{{ $node->name }}</a></li>
            <li class="active" style="color: #94a3b8;">Settings</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating" style="margin-bottom: 1.5rem;">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.nodes.view', $node->id) }}">About</a></li>
                <li class="active"><a href="{{ route('admin.nodes.view.settings', $node->id) }}">Settings</a></li>
                <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocation</a></li>
                <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}">Servers</a></li>
            </ul>
        </div>
    </div>
</div>

<form action="{{ route('admin.nodes.view.settings', $node->id) }}" method="POST">
    <div class="row" style="margin-top: 0.25rem;">
        {{-- LEFT COLUMN: Identity & Network --}}
        <div class="col-sm-6">
            {{-- 1. Identity & Arix Customizations Card --}}
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <i class="fa fa-sliders"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Node Identity & Branding</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">System labels and console appearance</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="name" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Node Name</label>
                        <input type="text" autocomplete="off" name="name" class="form-control" value="{{ old('name', $node->name) }}" style="width: 100%;" />
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Allowed characters: <code style="color: #c084fc;">a-zA-Z0-9_.-</code> and spaces (1-100 chars).</p>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="alert" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.4rem;">
                            Node Alert Banner
                            <span style="font-size: 0.62rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.5rem; border-radius: 9999px;">ARIX</span>
                        </label>
                        <textarea autocomplete="off" name="alert" class="form-control" rows="3" style="width: 100%;" placeholder="Optional notice shown on servers hosted on this node...">{{ old('alert', $node->alert) }}</textarea>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Leave empty to disable. Supports BBCode formatting.</p>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6" style="margin-bottom: 1.15rem;">
                            <label for="daemon_text" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.35rem;">
                                Daemon Prefix
                                <span style="font-size: 0.6rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.45rem; border-radius: 9999px;">ARIX</span>
                            </label>
                            <input type="text" autocomplete="off" name="daemon_text" class="form-control" value="{{ old('daemon_text', $node->daemon_text) }}" />
                        </div>
                        <div class="form-group col-md-6" style="margin-bottom: 1.15rem;">
                            <label for="container_text" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.35rem;">
                                Container Prompt
                                <span style="font-size: 0.6rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.45rem; border-radius: 9999px;">ARIX</span>
                            </label>
                            <input type="text" autocomplete="off" name="container_text" class="form-control" value="{{ old('container_text', $node->container_text) }}" />
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="node_icon" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.35rem;">
                            Node Icon
                            <span style="font-size: 0.62rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.5rem; border-radius: 9999px;">ARIX</span>
                        </label>
                        <input type="text" autocomplete="off" name="node_icon" class="form-control" value="{{ old('node_icon', $node->node_icon) }}" placeholder="e.g. server, cloud, cpu" />
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="description" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ $node->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="location_id" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Location</label>
                        <select name="location_id" class="form-control" style="width: 100%;">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ (((int) old('location_id', $node->location_id)) === $location->id) ? 'selected' : '' }}>{{ $location->long }} ({{ $location->short }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. Network & Connectivity Card --}}
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Network & SSL</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">FQDN, proxy, and protocol routing</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="fqdn" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Fully Qualified Domain Name (FQDN)</label>
                        <input type="text" autocomplete="off" name="fqdn" class="form-control" value="{{ old('fqdn', $node->fqdn) }}" style="width: 100%;" />
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Enter the domain name (e.g. <code style="color: #c084fc;">node.example.com</code>) used to reach Wings daemon.</p>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">Allow Automatic Allocation</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ old('public', $node->public) ? 'rgba(16, 185, 129, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ old('public', $node->public) ? 'rgba(16, 185, 129, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ old('public', $node->public) ? '#6ee7b7' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" name="public" value="1" {{ (old('public', $node->public)) ? 'checked' : '' }} style="display:none;"> Yes
                            </label>
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ !old('public', $node->public) ? 'rgba(239, 68, 68, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ !old('public', $node->public) ? 'rgba(239, 68, 68, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ !old('public', $node->public) ? '#fca5a5' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" name="public" value="0" {{ (old('public', $node->public)) ? '' : 'checked' }} style="display:none;"> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">Communicate Over SSL</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ old('scheme', $node->scheme) === 'https' ? 'rgba(16, 185, 129, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ old('scheme', $node->scheme) === 'https' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ old('scheme', $node->scheme) === 'https' ? '#6ee7b7' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pSSLTrue" value="https" name="scheme" {{ (old('scheme', $node->scheme) === 'https') ? 'checked' : '' }} style="display:none;"> <i class="fa fa-lock"></i> HTTPS
                            </label>
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ old('scheme', $node->scheme) !== 'https' ? 'rgba(245, 158, 11, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ old('scheme', $node->scheme) !== 'https' ? 'rgba(245, 158, 11, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ old('scheme', $node->scheme) !== 'https' ? '#fde68a' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pSSLFalse" value="http" name="scheme" {{ (old('scheme', $node->scheme) !== 'https') ? 'checked' : '' }} style="display:none;"> <i class="fa fa-unlock"></i> HTTP
                            </label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">Behind Reverse Proxy</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ !old('behind_proxy', $node->behind_proxy) ? 'rgba(255, 255, 255, 0.2)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ !old('behind_proxy', $node->behind_proxy) ? 'rgba(255, 255, 255, 0.08)' : 'rgba(14, 12, 26, 0.5)' }}; color: #e2e8f0; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == false) ? 'checked' : '' }} style="display:none;"> Not Behind Proxy
                            </label>
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ old('behind_proxy', $node->behind_proxy) ? 'rgba(139, 92, 246, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ old('behind_proxy', $node->behind_proxy) ? 'rgba(139, 92, 246, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ old('behind_proxy', $node->behind_proxy) ? '#c4b5fd' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" {{ (old('behind_proxy', $node->behind_proxy) == true) ? 'checked' : '' }} style="display:none;"> <i class="fa fa-shield"></i> Behind Proxy
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">Maintenance Mode</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ !old('maintenance_mode', $node->maintenance_mode) ? 'rgba(16, 185, 129, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ !old('maintenance_mode', $node->maintenance_mode) ? 'rgba(16, 185, 129, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ !old('maintenance_mode', $node->maintenance_mode) ? '#6ee7b7' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pMaintenanceFalse" value="0" name="maintenance_mode" {{ (old('maintenance_mode', $node->maintenance_mode) == false) ? 'checked' : '' }} style="display:none;"> Normal
                            </label>
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid {{ old('maintenance_mode', $node->maintenance_mode) ? 'rgba(245, 158, 11, 0.4)' : 'rgba(255, 255, 255, 0.1)' }}; background: {{ old('maintenance_mode', $node->maintenance_mode) ? 'rgba(245, 158, 11, 0.15)' : 'rgba(14, 12, 26, 0.5)' }}; color: {{ old('maintenance_mode', $node->maintenance_mode) ? '#fde68a' : '#94a3b8' }}; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pMaintenanceTrue" value="1" name="maintenance_mode" {{ (old('maintenance_mode', $node->maintenance_mode) == true) ? 'checked' : '' }} style="display:none;"> <i class="fa fa-wrench"></i> Under Maintenance
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Allocations & Daemon Ports --}}
        <div class="col-sm-6">
            {{-- 3. Allocation Limits Card --}}
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <i class="fa fa-microchip"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Capacity & Allocation Limits</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">RAM and storage hardware quotas</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    {{-- Memory Section --}}
                    <div style="margin-bottom: 1.25rem;">
                        <h4 style="font-size: 0.72rem; font-weight: 700; color: #10b981; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem;">
                            <i class="fa fa-memory" style="margin-right: 0.3rem;"></i> MEMORY
                        </h4>
                        <div class="row">
                            <div class="form-group col-xs-6" style="margin-bottom: 0.5rem;">
                                <label for="memory" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Total Memory</label>
                                <div style="position: relative;">
                                    <input type="text" name="memory" class="form-control" data-multiplicator="true" value="{{ old('memory', $node->memory) }}"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">MiB</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-6" style="margin-bottom: 0.5rem;">
                                <label for="memory_overallocate" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Overallocate</label>
                                <div style="position: relative;">
                                    <input type="text" name="memory_overallocate" class="form-control" value="{{ old('memory_overallocate', $node->memory_overallocate) }}"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">%</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 0.72rem; margin: 0.3rem 0 0 0;">Define memory available on this node. Set overallocate to allow over-provisioning beyond physical limit.</p>
                    </div>

                    {{-- Disk Section --}}
                    <div style="padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.06);">
                        <h4 style="font-size: 0.72rem; font-weight: 700; color: #f59e0b; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem;">
                            <i class="fa fa-hdd-o" style="margin-right: 0.3rem;"></i> STORAGE
                        </h4>
                        <div class="row">
                            <div class="form-group col-xs-6" style="margin-bottom: 0.5rem;">
                                <label for="disk" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Disk Space</label>
                                <div style="position: relative;">
                                    <input type="text" name="disk" class="form-control" data-multiplicator="true" value="{{ old('disk', $node->disk) }}"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">MiB</span>
                                </div>
                            </div>
                            <div class="form-group col-xs-6" style="margin-bottom: 0.5rem;">
                                <label for="disk_overallocate" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Overallocate</label>
                                <div style="position: relative;">
                                    <input type="text" name="disk_overallocate" class="form-control" value="{{ old('disk_overallocate', $node->disk_overallocate) }}"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">%</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 0.72rem; margin: 0.3rem 0 0 0;">Define disk space available on this node for server storage quotas.</p>
                    </div>
                </div>
            </div>

            {{-- 4. General Configuration & Ports Card --}}
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(236, 72, 153, 0.15); display: flex; align-items: center; justify-content: center; color: #ec4899;">
                        <i class="fa fa-plug"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Daemon Ports & Web Limits</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">SFTP, daemon listening port, and uploads</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="upload_size" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Maximum Web Upload Filesize</label>
                        <div style="position: relative;">
                            <input type="text" name="upload_size" class="form-control" value="{{ old('upload_size', $node->upload_size) }}"/>
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">MiB</span>
                        </div>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Maximum file size allowed through browser-based file manager uploads.</p>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                            <label for="daemonListen" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Daemon Port</label>
                            <input type="text" name="daemonListen" class="form-control" value="{{ old('daemonListen', $node->daemonListen) }}"/>
                        </div>
                        <div class="form-group col-md-6" style="margin-bottom: 1rem;">
                            <label for="daemonSFTP" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Daemon SFTP Port</label>
                            <input type="text" name="daemonSFTP" class="form-control" value="{{ old('daemonSFTP', $node->daemonSFTP) }}"/>
                        </div>
                    </div>
                    <p style="color: #64748b; font-size: 0.75rem; margin: 0;">SFTP runs in Wings' internal container. <strong>Never use the same port as physical SSHd.</strong></p>
                </div>
            </div>

            {{-- 5. Master Key & Actions Card --}}
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(239, 68, 68, 0.15); display: flex; align-items: center; justify-content: center; color: #ef4444;">
                        <i class="fa fa-key"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Security Master Key</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Rotate node authentication tokens</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 0.6rem; color: #fca5a5; font-size: 0.88rem; font-weight: 600;">
                        <input type="checkbox" name="reset_secret" id="reset_secret" style="accent-color: #ef4444; width: 16px; height: 16px;" />
                        Reset Daemon Master Key
                    </label>
                    <p style="color: #64748b; font-size: 0.75rem; margin: 0.35rem 0 0 0;">Invalidates current master token. Any requests using the old key will be denied immediately.</p>
                </div>
                <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: flex-end; align-items: center;">
                    {!! method_field('PATCH') !!}
                    {!! csrf_field() !!}
                    <button type="submit" class="button button-primary" style="padding: 0.6rem 1.5rem; border-radius: 9999px; display: inline-flex; align-items: center; gap: 0.45rem; font-weight: 700;">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('[data-toggle="popover"]').popover({
        placement: 'auto'
    });
    $('select[name="location_id"]').select2();
    </script>
@endsection
