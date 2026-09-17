@extends('layouts.admin')

@section('title')
    Nests &rarr; Egg: {{ $egg->name }}
@endsection

@section('content-header')
    <div class="admin-container">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                    <i class="fa fa-puzzle-piece" style="color: #f59e0b;"></i>
                    {{ $egg->name }}
                    <span style="font-size: 0.72rem; font-weight: 600; color: #f59e0b; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.2rem 0.65rem; border-radius: 9999px; letter-spacing: 0.05em; text-transform: uppercase;">EGG CONFIG</span>
                </h1>
                <p style="color: #94a3b8; font-size: 0.88rem; margin: 0.3rem 0 0 0;">{{ str_limit($egg->description, 80) }}</p>
            </div>
            <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
                <li><a href="{{ route('admin.index') }}" style="color: #a855f7;"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="{{ route('admin.nests') }}" style="color: #a855f7;">Nests</a></li>
                <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}" style="color: #a855f7;">{{ $egg->nest->name }}</a></li>
                <li class="active" style="color: #cbd5e1;">{{ $egg->name }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="admin-container">
{{-- Tab Navigation --}}
<div class="row">
    <div class="col-xs-12">
        <div class="admin-tab-nav">
            <a href="{{ route('admin.nests.egg.view', $egg->id) }}" class="active">
                <i class="fa fa-cog"></i> Configuration
            </a>
            <a href="{{ route('admin.nests.egg.variables', $egg->id) }}">
                <i class="fa fa-code"></i> Variables
            </a>
            <a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">
                <i class="fa fa-file-code-o"></i> Install Script
            </a>
        </div>
    </div>
</div>

{{-- Import Egg File --}}
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div style="background: rgba(244, 63, 94, 0.08); border: 1px solid rgba(244, 63, 94, 0.25); border-radius: 14px; padding: 1.15rem 1.5rem; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="flex: 1; min-width: 200px;">
                    <label style="color: #fca5a5; font-weight: 600; font-size: 0.88rem; display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.35rem;">
                        <i class="fa fa-upload"></i> Import Egg JSON
                    </label>
                    <input type="file" name="import_file" class="form-control" style="border: 0 !important; background: transparent !important; padding-left: 0 !important; color: #fca5a5 !important;" />
                    <p style="color: #94a3b8; font-size: 0.75rem; margin: 0.25rem 0 0 0;">Replace egg settings by uploading a new JSON file. Existing startup strings and Docker images remain unchanged.</p>
                </div>
                <div>
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PUT" class="btn btn-danger btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i class="fa fa-refresh"></i> Update Egg
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Main Configuration --}}
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a855f7;">
                        <i class="fa fa-sliders"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Egg Configuration</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Identity, images & startup command</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pName" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-tag" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Name <span style="color: #f43f5e;">*</span>
                                </label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Human-readable identifier for this Egg.</p>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pImage" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.4rem;">
                                    <i class="fa fa-image" style="color: #a855f7; font-size: 0.75rem;"></i> Egg Image
                                    <span style="font-size: 0.6rem; font-weight: 700; color: #a855f7; background: rgba(139, 92, 246, 0.15); padding: 0.1rem 0.5rem; border-radius: 9999px;">ARIX</span>
                                </label>
                                <input type="text" id="pImage" name="image" value="{{ $egg->image }}" class="form-control" />
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Theme thumbnail URL for this egg.</p>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pUuid" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-fingerprint" style="color: #64748b; font-size: 0.75rem; margin-right: 0.25rem;"></i> UUID
                                </label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" style="opacity: 0.6; cursor: not-allowed;" />
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pAuthor" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-user" style="color: #64748b; font-size: 0.75rem; margin-right: 0.25rem;"></i> Author
                                </label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" style="opacity: 0.6; cursor: not-allowed;" />
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pDockerImages" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-docker" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Docker Images <span style="color: #f43f5e;">*</span>
                                </label>
                                <textarea id="pDockerImages" name="docker_images" class="form-control" rows="4" style="font-family: var(--font-mono, monospace); font-size: 0.82rem;">{{ implode(PHP_EOL, $images) }}</textarea>
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">One image per line. Optional format: <code style="color: #c084fc;">Display Name|ghcr.io/my/egg</code></p>
                            </div>
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.65rem 0.95rem; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08); background: rgba(14, 12, 26, 0.4); transition: all 0.15s ease;">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" @if($egg->force_outgoing_ip) checked @endif style="accent-color: #8b5cf6; width: 16px; height: 16px; border-radius: 4px !important;" />
                                    <span style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem;">Force Outgoing IP</span>
                                </label>
                                <p style="color: #64748b; font-size: 0.72rem; margin: 0.4rem 0 0 0;">NATs outgoing traffic to the primary allocation IP. <span style="color: #fca5a5;">Disables internal networking.</span></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pDescription" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-align-left" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Description
                                </label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ $egg->description }}</textarea>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pStartup" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-terminal" style="color: #10b981; font-size: 0.75rem; margin-right: 0.25rem;"></i> Startup Command <span style="color: #f43f5e;">*</span>
                                </label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="8" style="font-family: var(--font-mono, monospace); font-size: 0.82rem;">{{ $egg->startup }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="pConfigFeatures" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-puzzle-piece" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Features
                                </label>
                                <select class="form-control" name="features[]" id="pConfigFeatures" multiple>
                                    @foreach(($egg->features ?? []) as $feature)
                                        <option value="{{ $feature }}" selected>{{ $feature }}</option>
                                    @endforeach
                                </select>
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Additional features for panel modifications. Comma-separated tags.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Process Management --}}
        <div class="col-xs-12">
            <div class="stat-card" style="padding: 0; overflow: hidden; margin-bottom: 1.5rem;">
                <div style="padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 34px; height: 34px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                        <i class="fa fa-microchip"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #ffffff;">Process Management</h3>
                        <span style="font-size: 0.72rem; color: #94a3b8;">Stop commands, config files & startup detection</span>
                    </div>
                </div>
                <div style="padding: 1.35rem 1.5rem;">
                    {{-- Warning --}}
                    <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 12px; padding: 0.85rem 1.15rem; margin-bottom: 1.25rem; display: flex; align-items: flex-start; gap: 0.65rem;">
                        <i class="fa fa-exclamation-triangle" style="color: #f59e0b; margin-top: 2px;"></i>
                        <div>
                            <p style="color: #fcd34d; font-size: 0.82rem; font-weight: 600; margin: 0 0 0.2rem 0;">Advanced Configuration</p>
                            <p style="color: #94a3b8; font-size: 0.78rem; margin: 0;">Incorrect modifications may break daemon functionality. All fields required unless inheriting from another egg.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pConfigFrom" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-copy" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Copy Settings From
                                </label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">None</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pConfigStop" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-stop-circle" style="color: #f43f5e; font-size: 0.75rem; margin-right: 0.25rem;"></i> Stop Command
                                </label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" style="font-family: var(--font-mono, monospace);" />
                                <p style="color: #64748b; font-size: 0.75rem; margin: 0.3rem 0 0 0;">Use <code style="color: #c084fc;">^C</code> for SIGINT.</p>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pConfigLogs" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-file-text" style="color: #a855f7; font-size: 0.75rem; margin-right: 0.25rem;"></i> Log Configuration
                                </label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6" style="font-family: var(--font-mono, monospace); font-size: 0.82rem;">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pConfigFiles" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-file-code-o" style="color: #10b981; font-size: 0.75rem; margin-right: 0.25rem;"></i> Configuration Files
                                </label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6" style="font-family: var(--font-mono, monospace); font-size: 0.82rem;">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                            <div class="form-group" style="margin-bottom: 1.15rem;">
                                <label for="pConfigStartup" style="color: #e2e8f0; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block;">
                                    <i class="fa fa-rocket" style="color: #f59e0b; font-size: 0.75rem; margin-right: 0.25rem;"></i> Start Configuration
                                </label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6" style="font-family: var(--font-mono, monospace); font-size: 0.82rem;">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
                    <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn btn-danger btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                        <i class="fa fa-trash-o"></i> <span class="delete-text"></span>
                    </button>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        {!! csrf_field() !!}
                        <a href="{{ route('admin.nests.egg.export', $egg->id) }}" class="btn btn-default btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem; text-decoration: none;">
                            <i class="fa fa-download"></i> Export
                        </a>
                        <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                    </div>
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
    $('#pConfigFrom').select2();
    $('#deleteButton').on('mouseenter', function (event) {
        $(this).find('.delete-text').text('Delete Egg');
    }).on('mouseleave', function (event) {
        $(this).find('.delete-text').text('');
    });
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();

            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);

            $(this).val(prepend + '    ' + append);
        }
    });
    $('#pConfigFeatures').select2({
        tags: true,
        selectOnClose: false,
        tokenSeparators: [',', ' '],
    });
    </script>
@endsection
