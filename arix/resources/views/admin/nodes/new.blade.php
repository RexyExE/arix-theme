@extends('layouts.admin')

@section('title')
    Nodes &rarr; New
@endsection

@section('content-header')
    <div class="admin-container">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa fa-plus-circle" style="color: #10b981;"></i>
                    Provision New Node
                    <span style="font-size: 0.72rem; font-weight: 600; color: #10b981; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">COMPUTE</span>
                </h1>
                <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.3rem 0 0 0;">Deploy a new compute node for container workloads and game server orchestration.</p>
            </div>
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                <li><a href="{{ route('admin.index') }}" style="color: #a855f7;"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="{{ route('admin.nodes') }}" style="color: #a855f7;">Nodes</a></li>
                <li class="active" style="color: #cbd5e1;">New</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="admin-container">
<form action="{{ route('admin.nodes.new') }}" method="POST">
    <div class="row">
        {{-- LEFT COLUMN — Identity & Network --}}
        <div class="col-sm-6">
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <i class="fa fa-id-card"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Node Identity</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Naming, location & visibility</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="pName" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-tag" style="color: #a855f7; font-size: 0.75rem;"></i> Node Name
                        </label>
                        <input type="text" name="name" id="pName" class="form-control" value="{{ old('name') }}" placeholder="e.g. US-East-01"/>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Allowed characters: <code style="color: #c084fc;">a-zA-Z0-9_.-</code> and spaces (1-100 chars).</p>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="daemon_text" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-terminal" style="color: #a855f7; font-size: 0.75rem;"></i> Console Prefix
                            <span style="font-size: 0.6rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.5rem; border-radius: 9999px;">ARIX</span>
                        </label>
                        <input type="text" autocomplete="off" name="daemon_text" class="form-control" value="{{ old('daemon_text') }}" placeholder="[Pterodactyl Daemon]:"/>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Customizes the daemon prefix shown in server consoles.</p>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="container_text" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-cube" style="color: #a855f7; font-size: 0.75rem;"></i> Container Prompt
                            <span style="font-size: 0.6rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.5rem; border-radius: 9999px;">ARIX</span>
                        </label>
                        <input type="text" autocomplete="off" name="container_text" class="form-control" value="{{ old('container_text') }}" placeholder="container@pterodactyl~"/>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Customizes the container shell prompt text.</p>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="pDescription" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-align-left" style="color: #a855f7; font-size: 0.75rem;"></i> Description
                        </label>
                        <textarea name="description" id="pDescription" rows="3" class="form-control" placeholder="Optional node description...">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="pLocationId" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-globe" style="color: #a855f7; font-size: 0.75rem;"></i> Location
                        </label>
                        <select name="location_id" id="pLocationId" class="form-control">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $location->id != old('location_id') ?: 'selected' }}>{{ $location->short }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.5rem;">
                            <i class="fa fa-eye" style="color: #a855f7; font-size: 0.75rem;"></i> Visibility
                        </label>
                        <div style="display: flex; gap: 0.5rem;">
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.15); color: #6ee7b7; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pPublicTrue" value="1" name="public" checked style="display:none;"> <i class="fa fa-globe" style="font-size: 0.72rem;"></i> Public
                            </label>
                            <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(14, 12, 26, 0.5); color: #94a3b8; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <input type="radio" id="pPublicFalse" value="0" name="public" style="display:none;"> <i class="fa fa-lock" style="font-size: 0.72rem;"></i> Private
                            </label>
                        </div>
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.35rem 0 0 0;">Private nodes cannot be targeted by auto-deployment.</p>
                    </div>

                    {{-- Network --}}
                    <div style="padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: 0.5rem;">
                        <h4 style="font-size: 0.82rem; font-weight: 700; color: #a855f7; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.85rem;">
                            <i class="fa fa-wifi" style="margin-right: 0.3rem;"></i> NETWORK
                        </h4>
                        <div class="form-group" style="margin-bottom: 1.15rem;">
                            <label for="pFQDN" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">FQDN / IP Address</label>
                            <input type="text" name="fqdn" id="pFQDN" class="form-control" value="{{ old('fqdn') }}" placeholder="node.example.com"/>
                            <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Domain or IP for daemon connections. Use a domain if SSL is enabled.</p>
                        </div>
                        <div class="form-group" style="margin-bottom: 1.15rem;">
                            <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">SSL Protocol</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.15); color: #6ee7b7; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <input type="radio" id="pSSLTrue" value="https" name="scheme" checked style="display:none;"> <i class="fa fa-lock" style="font-size: 0.72rem;"></i> HTTPS
                                </label>
                                <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(14, 12, 26, 0.5); color: #94a3b8; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <input type="radio" id="pSSLFalse" value="http" name="scheme" @if(request()->isSecure()) disabled @endif style="display:none;"> <i class="fa fa-unlock" style="font-size: 0.72rem;"></i> HTTP
                                </label>
                            </div>
                            @if(request()->isSecure())
                                <p style="color: #fca5a5; font-size: 0.75rem; margin: 0.35rem 0 0 0;"><i class="fa fa-exclamation-triangle"></i> Panel uses HTTPS — node <strong>must</strong> also use SSL.</p>
                            @else
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.35rem 0 0 0;">Use HTTPS unless connecting by IP without certificates.</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem; display: block;">Reverse Proxy</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(14, 12, 26, 0.5); color: #94a3b8; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <input type="radio" id="pProxyFalse" value="0" name="behind_proxy" checked style="display:none;"> Direct
                                </label>
                                <label style="cursor: pointer; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.82rem; font-weight: 600; border: 1px solid rgba(139, 92, 246, 0.4); background: rgba(139, 92, 246, 0.12); color: #c4b5fd; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <input type="radio" id="pProxyTrue" value="1" name="behind_proxy" style="display:none;"> <i class="fa fa-shield" style="font-size: 0.72rem;"></i> Behind Proxy
                                </label>
                            </div>
                            <p style="color: #64748b; font-size: 0.75rem; margin: 0.35rem 0 0 0;">Enable if using CloudFlare or another reverse proxy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN — Resources & Ports --}}
        <div class="col-sm-6">
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <i class="fa fa-microchip"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Resource Allocation</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Memory, storage & daemon ports</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.15rem;">
                        <label for="pDaemonBase" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                            <i class="fa fa-folder-open" style="color: #10b981; font-size: 0.75rem;"></i> Server Files Directory
                        </label>
                        <input type="text" name="daemonBase" id="pDaemonBase" class="form-control" value="/var/lib/pterodactyl/volumes" />
                        <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">OVH users may need <code style="color: #c084fc;">/home/daemon-data</code> for adequate space.</p>
                    </div>

                    {{-- Memory Section --}}
                    <div style="padding: 0.85rem 0; border-top: 1px solid rgba(255, 255, 255, 0.05); margin-top: 0.5rem;">
                        <h4 style="font-size: 0.72rem; font-weight: 700; color: #10b981; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem;">
                            <i class="fa fa-memory" style="margin-right: 0.3rem;"></i> MEMORY
                        </h4>
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pMemory" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Total Capacity</label>
                                <div style="position: relative;">
                                    <input type="text" name="memory" data-multiplicator="true" class="form-control" id="pMemory" value="{{ old('memory') }}" placeholder="8192"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">MiB</span>
                                </div>
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pMemoryOverallocate" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Over-Allocate</label>
                                <div style="position: relative;">
                                    <input type="text" name="memory_overallocate" class="form-control" id="pMemoryOverallocate" value="{{ old('memory_overallocate') }}" placeholder="0"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">%</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 0.72rem; margin: 0;">Set <code style="color: #c084fc;">-1</code> to disable checks, <code style="color: #c084fc;">0</code> to prevent over-provisioning.</p>
                    </div>

                    {{-- Disk Section --}}
                    <div style="padding: 0.85rem 0; border-top: 1px solid rgba(255, 255, 255, 0.05); margin-top: 0.5rem;">
                        <h4 style="font-size: 0.72rem; font-weight: 700; color: #f59e0b; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem;">
                            <i class="fa fa-hdd-o" style="margin-right: 0.3rem;"></i> STORAGE
                        </h4>
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pDisk" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Total Capacity</label>
                                <div style="position: relative;">
                                    <input type="text" name="disk" data-multiplicator="true" class="form-control" id="pDisk" value="{{ old('disk') }}" placeholder="50000"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">MiB</span>
                                </div>
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pDiskOverallocate" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Over-Allocate</label>
                                <div style="position: relative;">
                                    <input type="text" name="disk_overallocate" class="form-control" id="pDiskOverallocate" value="{{ old('disk_overallocate') }}" placeholder="0"/>
                                    <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.78rem; font-weight: 600;">%</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 0.72rem; margin: 0;">Set <code style="color: #c084fc;">-1</code> to disable checks, <code style="color: #c084fc;">0</code> to prevent over-provisioning.</p>
                    </div>

                    {{-- Ports Section --}}
                    <div style="padding: 0.85rem 0; border-top: 1px solid rgba(255, 255, 255, 0.05); margin-top: 0.5rem;">
                        <h4 style="font-size: 0.72rem; font-weight: 700; color: #a855f7; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.75rem;">
                            <i class="fa fa-plug" style="margin-right: 0.3rem;"></i> DAEMON PORTS
                        </h4>
                        <div class="row">
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pDaemonListen" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">Daemon Port</label>
                                <input type="text" name="daemonListen" class="form-control" id="pDaemonListen" value="8080" />
                            </div>
                            <div class="form-group col-md-6" style="margin-bottom: 0.85rem;">
                                <label for="pDaemonSFTP" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">SFTP Port</label>
                                <input type="text" name="daemonSFTP" class="form-control" id="pDaemonSFTP" value="2022" />
                            </div>
                        </div>
                        <p style="color: #64748b; font-size: 0.72rem; margin: 0;">CloudFlare users: set daemon port to <code style="color: #c084fc;">8443</code> for WSS proxying. Don't reuse your SSH port.</p>
                    </div>
                </div>

                {{-- Submit Footer --}}
                <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: flex-end; align-items: center;">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.45rem;">
                        <i class="fa fa-rocket"></i> Deploy Node
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pLocationId').select2();
    </script>
@endsection
