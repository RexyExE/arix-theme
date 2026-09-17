@extends('layouts.arix', ['navbar' => 'components', 'sideEditor' => false])

@section('title')
    Arix Layout
@endsection

@php
    $serverRowOptions = [
        ['img' => '/arix/components/ServerRow-1.svg', 'value' => 1, 'label' => 'Enable'],
        ['img' => '/arix/components/ServerRow-2.svg', 'value' => 2, 'label' => 'Disable'],
        ['img' => '/arix/components/ServerRow-3.svg', 'value' => 3, 'label' => 'Disable'],
    ];
    $statCardsOptions = [
        ['img' => '/arix/components/Console.svg', 'value' => 1, 'label' => 'No statistics cards'],
        ['img' => '/arix/components/StatsCards-1.svg', 'value' => 2, 'label' => 'Statistics cards top'],
        ['img' => '/arix/components/StatsCards-2.svg', 'value' => 3, 'label' => 'Statistics cards bottom'],
    ];
    $sideGraphOptions = [
        ['img' => '/arix/components/Console.svg', 'value' => 1, 'label' => 'No vertical graphs'],
        ['img' => '/arix/components/SideGraphs-1.svg', 'value' => 2, 'label' => 'Vertical graphs left'],
        ['img' => '/arix/components/SideGraphs-2.svg', 'value' => 3, 'label' => 'Vertical graphs right'],
    ];
    $graphsOptions = [
        ['img' => '/arix/components/Console.svg', 'value' => 1, 'label' => 'No horizontal graphs'],
        ['img' => '/arix/components/Graphs-1.svg', 'value' => 2, 'label' => 'Horizontal graphs top'],
        ['img' => '/arix/components/Graphs-2.svg', 'value' => 3, 'label' => 'Horizontal graphs bottom'],
    ];
@endphp

@section('content')

    <form action="{{ route('admin.arix.components') }}" method="POST" class="content-box content-box-wide">
        <div class="header" style="display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); margin-bottom: 1.25rem;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.1)); display: flex; align-items: center; justify-content: center; color: #10b981; flex-shrink: 0;">
                <i data-lucide="layout-grid" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    Component Gallery
                    <span style="font-size: 0.62rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">UI KIT</span>
                </p>
                <span class="description-text" style="color: #94a3b8; font-size: 0.82rem;">Customize server card designs, console graphs layout, statistics widgets, and server rows.</span>
            </div>
        </div>
        
        <x-arix.form-wrapper 
            title="Dashboard page" 
            description="Customize the dashboard server page easily with a drag and drop"
        >
            <a class="drag-n-drop-banner" href="{{ route('admin.arix.dashboard') }}">
                <h3>Customize dashboard page with drag and drop!</h3>
                <p>Open Dashboard Editor <i data-lucide="arrow-right"></i></p>
            </a>
        </x-arix.form-wrapper>

        <x-arix.form-wrapper 
            title="Server cards" 
            description="Choose a different style for the server cards shown on the homepage"
        >
            <x-arix.option-picture-2
                id="arix:serverRow" 
                :value="$serverRow"
                :options="$serverRowOptions"
            />
        </x-arix.form-wrapper>

        <x-arix.form-wrapper 
            title="Console page" 
            description="Customize what and how stats is shown on the console page"
        >
            <x-arix.option-picture-2
                id="arix:statsCards" 
                :value="$statsCards"
                :options="$statCardsOptions"
            />
            <x-arix.option-picture-2
                id="arix:sideGraphs" 
                :value="$sideGraphs"
                :options="$sideGraphOptions"
            />
            <x-arix.option-picture-2
                id="arix:graphs" 
                :value="$graphs"
                :options="$graphsOptions"
            />
        </x-arix.form-wrapper>

        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>
@endsection