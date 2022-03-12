@extends('layout.default')

@section('title')
    <title>Possible Leech Cheaters - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Possible Leech Cheaters - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.cheaters.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('staff.possible-leech-cheaters') }} (Ghost Leechers)
            </span>
        </a>
    </li>
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('common.user') }}</th>
                <th>{{ __('user.member-since') }}</th>
                <th>{{ __('user.last-login') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cheaters as $cheater)
                <tr>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$cheater->user->id"
                            :username="$cheater->user->username"
                            :href="route('users.show', ['username' => $cheater->user->username])"
                            :icon="$cheater->user->group->icon"
                            :color="$cheater->user->group->color"
                            :group="$cheater->user->group->name"
                        />
                    </td>
                    <td>{{ $cheater->user->created_at ?? 'N/A' }}</td>
                    <td>{{ $cheater->user->last_login ?? 'N/A'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $cheaters->links() }}</div>
@endsection
