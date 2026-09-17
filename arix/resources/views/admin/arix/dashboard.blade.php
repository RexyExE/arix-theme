@extends('layouts.arix', ['navbar' => 'components', 'sideEditor' => true])

@section('title')
    Arix Dashboard
@endsection

@section('content')
    <form action="{{ route('admin.arix.dashboard') }}" method="POST">
        <div class="header" style="margin-bottom: 1.25rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06);">
            <a href="{{ route('admin.arix.components') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.8rem; font-weight: 600; color: #a855f7; margin-bottom: 0.85rem; text-decoration: none; padding: 0.35rem 0.75rem; border-radius: 9999px; background: rgba(168, 85, 247, 0.1); border: 1px solid rgba(168, 85, 247, 0.2); width: fit-content;">
                <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
                Back to components
            </a>
            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: #a855f7; flex-shrink: 0;">
                    <i data-lucide="grip" style="width: 20px; height: 20px;"></i>
                </div>
                <div>
                    <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                        Dashboard Canvas
                        <span style="font-size: 0.62rem; font-weight: 700; color: #a855f7; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">DRAG & DROP</span>
                    </p>
                    <span class="description-text" style="color: #94a3b8; font-size: 0.82rem;">Arrange and order server overview widgets, graphs, banners, and SFTP details on the live preview canvas.</span>
                </div>
            </div>
        </div>

        <div id="components">
            <x-arix.drag-n-drop
                wide
                name="banner"
                label="Egg Banner"
                src="/arix/dashboard/banner.png"
            />
            <x-arix.drag-n-drop
                wide
                name="statCards"
                label="Statistics cards"
                src="/arix/dashboard/statCards.png"
            />
            <x-arix.drag-n-drop
                name="infoAdvanced"
                label="Advanced information card"
                src="/arix/dashboard/infoAdvanced.png"
            />
            <x-arix.drag-n-drop
                wide
                name="graphs"
                label="Graphs"
                src="/arix/dashboard/graphs.png"
            />
            <x-arix.drag-n-drop
                name="info"
                label="Simple information card"
                src="/arix/dashboard/info.png"
            />
            <x-arix.drag-n-drop
                name="SFTP"
                label="SFTP Details"
                src="/arix/dashboard/SFTP.png"
            />
            <x-arix.drag-n-drop
                long
                name="sideGraphs"
                label="Vertical Graphs"
                src="/arix/dashboard/sideGraphs.png"
            />
        </div>

        @php
            $widgets = old('arix:dashboardWidgets', $siteConfiguration['arix']['dashboardWidgets'] ?? []);
        @endphp
        <div id="widget-inputs">
            @foreach ($widgets as $index => $widget)
                <input type="hidden" name="arix:dashboardWidgets[{{ $index }}]" value="{{ $widget }}" placeholder="Widget {{ $index + 1 }}" />
            @endforeach
        </div>
        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>
    <!-- Draggable JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.1.4/build/umd/index.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const containers = [document.getElementById('components'), document.getElementById('dropzone')].filter(Boolean);

            const draggable = new Draggable.Sortable(containers, {
                draggable: '.draggable-item',
                handle: '.draggable-area'
            });

            draggable.on('drag:start', (event) => {
                event.source.classList.add('is-dragging');
            });
            draggable.on('drag:stop', (event) => {
                event.source.classList.remove('is-dragging');
            });

            @php
                $widgets_json = json_encode(array_values($widgets));
            @endphp
            const widgets = {!! $widgets_json !!};
            widgets.forEach(function(widgetName) {
                const item = document.querySelector(`#components .draggable-item[data-name="${widgetName}"]`);
                if (item) {
                    document.getElementById('dropzone').appendChild(item);
                }
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                const widgetInputs = document.getElementById('widget-inputs');
                widgetInputs.innerHTML = '';
                const dropzoneItems = document.querySelectorAll('#dropzone .draggable-item');
                dropzoneItems.forEach(function(item, idx) {
                    const name = item.getAttribute('data-name');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `arix:dashboardWidgets[${idx}]`;
                    input.value = name;
                    widgetInputs.appendChild(input);
                });
            });
        });

        function resetDragItem(name) {
            const item = document.querySelector(`.draggable-item[data-name="${name}"]`);
            if (!item) return;
            const dropzone = document.getElementById('dropzone');
            const components = document.getElementById('components');
            if (dropzone.contains(item)) {
                components.appendChild(item);
            }
        }
    </script>
    <style>
        #components {
            display: flex;
            flex-direction: column;
            row-gap: 20px;
            min-height: 400px;
        }
        .draggable-item {
            position: relative;
        }
        .draggable-item .draggable-area {
            border-radius: 5px;
            background: var(--gray800);
            border: 1px solid var(--gray600);
            padding: 8px;
            cursor: grab;
            transition: 300ms;
        }
        .draggable-item .draggable-area img{
            width: 100%;
        }
        .draggable-mirror.draggable-item .draggable-area img{
            max-width: 400px;
        }
        #components .draggable-item button {
            display: none;
        }
        .draggable-item button{
            pointer-events: none;
            position: absolute;
            top: 1rem;
            right: 1rem;
            opacity: 0;
            transition: 0.3s;
        }
        .draggable-item:hover button {
            pointer-events: auto;
            opacity: 1;
        }
        .draggable-item:hover .draggable-area,
        .draggable-item.is-dragging .draggable-area {
            border-color: var(--primary);
        }
        .draggable-item span{
            display: block;
            font-size: var(--text-sm);
            font-weight: 500;
            margin-bottom:0.3rem;
        }
        .draggable-item.column-2{
            grid-column: span 2;
        }
        .draggable-item.row-2{
            grid-row: span 2;
        }
        #dropzone {
            height: 100%;
            border-radius: 10px;
            overflow-y: auto;
            background: var(--gray800);
            border: 1px solid var(--gray500);
            padding: 10px;
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            align-items: start;
            grid-auto-rows: min-content;
        }
        #dropzone .draggable-item span{
            display: none;
        }
        .draggable-mirror{
            opacity: 0.8;
            filter: brightness(1.5);
            z-index: 10;
        }
        .draggable-mirror.draggable-item span,
        .draggable-mirror.draggable-item button {
            display: none;
        }
    </style>
@endsection

@section('dropzone')
    <div id="dropzone" class="draggable-container">
        <!-- Dragged items will appear here -->
    </div>
@endsection