@extends('layout.default')

@section('title')
    <title>Commands - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Commands - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.commands.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Commands</span>
        </a>
    </li>
@endsection

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
        <x-panel heading="Maintenance mode">
            <ul class="staff-dashboard__menu">
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/maintance-enable') }}">
                        @csrf
                        <button
                            type="submit"
                            title="This commands enables maintenance mode while whitelisting only your IP Address."
                        >
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Enable Maintenance Mode
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/maintance-disable') }}">
                        @csrf
                        <button
                            type="submit"
                            title="This commands disables maintenance mode. Bringing the site backup for all to access."
                        >
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Disable Maintenance Mode
                        </button>
                    </form>
                </li>
            </ul>
        </x-panel>
        <x-panel heading="Caching">
            <ul class="staff-dashboard__menu">
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/clear-cache') }}">
                        @csrf
                        <button
                            type="submit"
                            title="This commands clears your sites cache. This cache depends on what driver you are using."
                        >
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Clear cache
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/clear-view-cache') }}">
                        @csrf
                        <button type="submit" title="This commands clears your sites compiled views cache.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Clear view cache
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/clear-route-cache') }}">
                        @csrf
                        <button type="submit" title="This commands clears your sites compiled routes cache.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Clear route cache
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/clear-config-cache') }}">
                        @csrf
                        <button type="submit" title="This commands clears your sites compiled configs cache.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Clear config cache
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/clear-all-cache') }}">
                        @csrf
                        <button type="submit" title="This commands clears ALL of your sites cache.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Clear all cache
                        </button>
                    </form>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/set-all-cache') }}">
                        @csrf
                        <button type="submit" title="This commands sets ALL of your sites cache.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Set all cache
                        </button>
                    </form>
                </li>
            </ul>
        </x-panel>
        <x-panel heading="Email">
            <ul class="staff-dashboard__menu">
                <li>
                    <form role="form" method="POST" action="{{ url('/dashboard/commands/test-email') }}">
                        @csrf
                        <button type="submit" title="This commands tests your email configuration.">
                            <i class='{{ config('other.font-awesome') }} fa-terminal'></i>
                            Send test email
                        </button>
                    </form>
                </li>
            </ul>
        </x-panel>
    </div>
@endsection
