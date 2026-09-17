@extends('layouts.arix', ['navbar' => 'layout', 'sideEditor' => true])

@section('title')
    Arix Layout
@endsection

@section('content')

    <form action="{{ route('admin.arix.layout') }}" method="POST">
        <div class="header" style="display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); margin-bottom: 1.25rem;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, rgba(159, 117, 255, 0.2), rgba(139, 92, 246, 0.1)); display: flex; align-items: center; justify-content: center; color: #9f75ff; flex-shrink: 0;">
                <i data-lucide="layout" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <p style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                    Layout Architecture
                    <span style="font-size: 0.62rem; font-weight: 700; color: #c084fc; background: rgba(159, 117, 255, 0.15); border: 1px solid rgba(159, 117, 255, 0.3); padding: 0.15rem 0.55rem; border-radius: 9999px; letter-spacing: 0.06em; text-transform: uppercase;">STRUCTURE</span>
                </p>
                <span class="description-text" style="color: #84809c; font-size: 0.82rem;">Select your preferred panel navigation blueprint, sidebar hierarchy, and server control modes.</span>
            </div>
        </div>
        <div>
            <p class="subtitle">General Layout</p>
            <div class="layout-grid">
                <x-arix.layout-option 
                    id="arix:layout:1" 
                    name="arix:layout"
                    value="1"
                    :oldValue="$layout" 
                    label="Sidebar"
                    img="/arix/layout/layout-1.svg"
                />
                <x-arix.layout-option 
                    id="arix:layout:2" 
                    name="arix:layout"
                    value="2"
                    :oldValue="$layout" 
                    label="Sidebar Power Actions"
                    img="/arix/layout/layout-2.svg"
                />
                <x-arix.layout-option 
                    id="arix:layout:3" 
                    name="arix:layout"
                    value="3"
                    :oldValue="$layout" 
                    label="Top Navigation"
                    img="/arix/layout/layout-3.svg"
                />
                <x-arix.layout-option 
                    id="arix:layout:4" 
                    name="arix:layout"
                    value="4"
                    :oldValue="$layout" 
                    label="Slim Sidebar"
                    img="/arix/layout/layout-4.svg"
                />
                <x-arix.layout-option 
                    id="arix:layout:5" 
                    name="arix:layout"
                    value="5"
                    :oldValue="$layout" 
                    label="Sidebar Filled Hover"
                    img="/arix/layout/layout-5.svg"
                />
            </div>
        </div>

        <div class="input-field">
            <label for="arix:logoPosition">Search or select bar</label>
            <select name="arix:searchComponent" value="{{ old('arix:searchComponent', $searchComponent) }}">
                <option value="1">Server select bar</option>
                <option value="2" @if(old('arix:searchComponent', $searchComponent) == '2') selected @endif>Searchbar</option>
            </select>
            <small>Where do you want the logo on the login screen.</small>
        </div>

        <hr />
        
        <div class="header">
            <p>Login layout settings</p>
            <span class="description-text">Change the layout settings of the auth pages of Arix Theme.</span>
        </div>
        <div>
            <p class="subtitle">Login layout</p>
            <div class="layout-grid">
                <x-arix.layout-option 
                    id="arix:loginLayout:1" 
                    name="arix:loginLayout"
                    value="1"
                    :oldValue="$loginLayout" 
                    label="Default"
                    img="/arix/layout/loginLayout-1.svg"
                />
                <x-arix.layout-option 
                    id="arix:loginLayout:2" 
                    name="arix:loginLayout"
                    value="2"
                    :oldValue="$loginLayout" 
                    label="Side Banner"
                    img="/arix/layout/loginLayout-2.svg"
                />
                <x-arix.layout-option 
                    id="arix:loginLayout:3" 
                    name="arix:loginLayout"
                    value="3"
                    :oldValue="$loginLayout" 
                    label="Floating Image"
                    img="/arix/layout/loginLayout-3.svg"
                />
                <x-arix.layout-option 
                    id="arix:loginLayout:4" 
                    name="arix:loginLayout"
                    value="4"
                    :oldValue="$loginLayout" 
                    label="Flat"
                    img="/arix/layout/loginLayout-4.svg"
                />
            </div>
        </div>

        <div class="input-field">
            <label for="arix:socialPosition">Social position</label>
            <select name="arix:socialPosition" value="{{ old('arix:socialPosition', $socialPosition) }}">
                <option value="1">Above form</option>
                <option value="2" @if(old('arix:socialPosition', $socialPosition) == '2') selected @endif>Under form</option>
            </select>
            <small>Where do you want the social buttons on the login screen.</small>
        </div>
        <div class="input-field">
            <label for="arix:logoPosition">Logo Position</label>
            <select name="arix:logoPosition" value="{{ old('arix:logoPosition', $logoPosition) }}">
                <option value="1">Above form</option>
                <option value="2" @if(old('arix:logoPosition', $logoPosition) == '2') selected @endif>Top corner</option>
            </select>
            <small>Where do you want the logo on the login screen.</small>
        </div>
        <div class="floating-button">
            {!! csrf_field() !!}
            <button type="submit" class="button button-primary">Save changes</button>
        </div>
    </form>
@endsection