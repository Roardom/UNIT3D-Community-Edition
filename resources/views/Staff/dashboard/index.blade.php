@extends('layout.default')

@section('title')
    <title>{{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-link"></i>
                {{ __('staff.links') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('home.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.frontend') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.dashboard.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.staff-dashboard') }}
                    </a>
                </li>
                @if (auth()->user()->group->is_owner)
                    <li>
                        <a href="{{ route('staff.backups.index') }}">
                            <i class="{{ config('other.font-awesome') }} fa-hdd"></i>
                            {{ __('backup.backup') }}
                            {{ __('backup.manager') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('staff.commands.index') }}">
                            <i class="fab fa-laravel"></i> Commands
                        </a>
                    </li>
                @endif
            </ul>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-wrench"></i>
                {{ __('staff.chat-tools') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('staff.statuses.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-comment-dots"></i>
                        {{ __('staff.statuses') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.rooms.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-comment-dots"></i>
                        {{ __('staff.rooms') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.bots.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-robot"></i>
                        {{ __('staff.bots') }}
                    </a>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ route('staff.flush.chat') }}" style="padding: 10px 15px;">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-info" style="margin-bottom: 5px;">
                            <i class="{{ config('other.font-awesome') }} fa-broom"></i>
                            {{ __('staff.flush-chat') }}
                        </button>
                    </form>
                </li>
            </ul>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-wrench"></i>
                {{ __('staff.general-tools') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('staff.articles.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-newspaper"></i>
                        {{ __('staff.articles') }}
                    </a>
                </li>
                @if (auth()->user()->group->is_admin)
                    <li>
                        <a href="{{ route('staff.forums.index') }}">
                            <i class="fab fa-wpforms"></i>
                            {{ __('staff.forums') }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('staff.pages.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.pages') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.polls.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-chart-pie"></i>
                        {{ __('staff.polls') }}
                    </a>
                </li>
            </ul>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-wrench"></i>
                {{ __('staff.torrent-tools') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('staff.moderation.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.torrent-moderation') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.categories.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.torrent-categories') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.types.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.torrent-types') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.resolutions.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('staff.torrent-resolutions') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.rss.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-rss"></i>
                        {{ __('staff.rss') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.media_languages.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-columns"></i>
                        {{ __('common.media-languages') }}
                    </a>
                </li>
                <li>
                    <form role="form" method="POST" action="{{ route('staff.flush.peers') }}" style="padding: 10px 15px;">
                        @csrf
                        <button type="submit" class="btn btn-xs btn-info" style="margin-bottom: 5px;">
                            <i class="{{ config('other.font-awesome') }} fa-ghost"></i>
                            {{ __('staff.flush-ghost-peers') }}
                        </button>
                    </form>
                </li>
            </ul>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-wrench"></i>
                {{ __('staff.user-tools') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('staff.applications.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-list"></i>
                        {{ __('staff.applications') }} ({{ $apps->pending }})
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_search') }}">
                        <i class="{{ config('other.font-awesome') }} fa-users"></i>
                        {{ __('staff.user-search') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.watchlist.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-eye"></i>
                        Watchlist
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.gifts.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-gift"></i>
                        {{ __('staff.user-gifting') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.mass-pm.create') }}">
                        <i class="{{ config('other.font-awesome') }} fa-envelope-square"></i>
                        {{ __('staff.mass-pm') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.mass-actions.validate') }}">
                        <i class="{{ config('other.font-awesome') }} fa-history"></i>
                        {{ __('staff.mass-validate-users') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.cheaters.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-question"></i>
                        {{ __('staff.possible-leech-cheaters') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.seedboxes.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-server"></i>
                        {{ __('staff.seedboxes') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.internals.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-magic"></i>
                        Internals
                    </a>
                </li>
                @if (auth()->user()->group->is_admin)
                    <li>
                        <a href="{{ route('staff.groups.index') }}">
                            <i class="{{ config('other.font-awesome') }} fa-users"></i>
                            {{ __('staff.groups') }}
                        </a>
                    </li>
                @endif
            </ul>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-file"></i>
                {{ __('staff.logs') }}
            </x-slot>
            <ul class="staff-dashboard__menu">
                <li>
                    <a href="{{ route('staff.audits.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.audit-log') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.bans.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.bans-log') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.authentications.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.failed-login-log') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.invites.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.invites-log') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.notes.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.user-notes') }}
                    </a>
                </li>
                @if (auth()->user()->group->is_owner)
                    <li>
                        <a href="/staff/log-viewer">
                            <i class="{{ config('other.font-awesome') }} fa-file"></i>
                            {{ __('staff.laravel-log') }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('staff.reports.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.reports-log') }} {{ $reports->unsolved }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.warnings.index') }}">
                        <i class="{{ config('other.font-awesome') }} fa-file"></i>
                        {{ __('staff.warnings-log') }}
                    </a>
                </li>
            </ul>
        </x-panel>
    </div>
@endsection

@section('sidebar')
    <x-panel heading="Site">
        <dl class="key-value">
            <dt>Codebase</dt>
            <dd>{{ config('unit3d.codebase') }}</dd>
            <dt>Version</dt>
            <dd>{{ config('unit3d.version') }}</dd>
        </dl>
    </x-panel>
    <x-panel heading="SSL Cert">
        <dl class="key-value">
            @if (request()->secure())
                <dt>URL</dt>
                <dd>{{ config('app.url') }}</dd>
                <dt>Issued By</dt>
                <dd>{{ (!is_string($certificate)) ? $certificate->getIssuer() : "No Certificate Info Found" }}</dd>
                <dt>Expires</dt>
                <dd>{{ (!is_string($certificate)) ? $certificate->expirationDate()->diffForHumans() : "No Certificate Info Found" }}</dd>
            @else
                <dt>URL</dt>
                <dd>
                    {{ config('app.url') }}
                    <br>
                    <strong>Connection Not Secure</strong>
                </dd>
                <dt>Issued By</dt>
                <dd>N/A</dd>
                <dt>Expires</dt>
                <dd>N/A</dd>
            @endif
        </dl>
    </x-panel>
    <x-panel heading="Server Information">
        <dl class="key-value">
            <dt>OS</dt>
            <dd>{{ $basic['os'] }}</dd>
            <dt>PHP</dt>
            <dd>php{{ $basic['php'] }}</dd>
            <dt>DATABASE</dt>
            <dd>{{ $basic['database'] }}</dd>
            <dt>LARAVEL</dt>
            <dd>Ver. {{ $basic['laravel'] }}</dd>
            <dt>RAM</dt>
            <dd>{{ $ram['used'] }} / {{ $ram['total'] }} ({{ $ram['free'] }} free)</dd>
            <dt>Disk</dt>
            <dd>{{ $disk['used'] }} / {{ $disk['total'] }} ({{ $disk['free'] }} free)</dd>
            <dt> Load Average</dt>
            <dd>{{ $avg }} (Estimated)</dd>
        </dl>
    </x-panel>
    <x-panel heading="Directory Permissions">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Directory</th>
                    <th>Current</th>
                    <th>Recommended</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($file_permissions as $permission)
                    <tr>
                        <td>{{ $permission['directory'] }}</td>
                        <td>
                            @if ($permission['permission'] == $permission['recommended'])
                                <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                                {{ $permission['permission'] }}
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times-circle"></i>
                                {{ $permission['permission'] }}
                            @endif
                        </td>
                        <td>{{ $permission['recommended'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
    <x-panel heading="Torrents">
        <dl class="key-value">
            <dt>Total</dt>
            <dd>{{ $torrents->total }}</dd>
            <dt>Pending</dt>
            <dd>{{ $torrents->pending }}</dd>
            <dt>Rejected</dt>
            <dd>{{ $torrents->rejected }}</dd>
        </dl>
    </x-panel>
    <x-panel heading="Peers">
        <dl class="key-value">
            <dt>Total</dt>
            <dd>{{ $peers->total }}</dd>
            <dt>Seeders</dt>
            <dd>{{ $peers->seeders }}</dd>
            <dt>Leechers</dt>
            <dd>{{ $peers->leechers }}</dd>
        </dl>
    </x-panel>
    <x-panel heading="Users">
        <dl class="key-value">
            <dt>Total</dt>
            <dd>{{ $users->total }}</dd>
            <dt>Validating</dt>
            <dd>{{ $users->validating }}</dd>
            <dt>Banned</dt>
            <dd>{{ $users->banned }}</dd>
        </dl>
    </x-panel>
@endsection
