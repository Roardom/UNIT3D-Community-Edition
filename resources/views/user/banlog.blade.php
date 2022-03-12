@extends('layout.default')

@section('title')
    <title>Ban Log - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username  }}</span>
        </a>
    </li>
    <li>
        <a href="#" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('user.ban-log') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <table class="table table-condensed table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>{{ __('common.user') }}</th>
                <th>{{ __('user.judge') }}</th>
                <th>{{ __('user.reason-ban') }}</th>
                <th>{{ __('user.reason-unban') }}</th>
                <th>{{ __('user.created') }}</th>
                <th>{{ __('user.removed') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bans as $ban)
                <tr>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$ban->banneduser->id"
                            :username="$ban->banneduser->username"
                            :href="route('users.show', ['username' => $ban->banneduser->username])"
                            :icon="$ban->banneduser->group->icon"
                            :color="$ban->banneduser->group->color"
                            :group="$ban->banneduser->group->name"
                            :effect="$ban->banneduser->group->effect"
                        />
                    </td>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$ban->staffuser->id"
                            :username="$ban->staffuser->username"
                            :href="route('users.show', ['username' => $ban->staffuser->username])"
                            :icon="$ban->staffuser->group->icon"
                            :color="$ban->staffuser->group->color"
                            :group="$ban->staffuser->group->name"
                            :effect="$ban->staffuser->group->effect"
                        />
                    </td>
                    <td>{{ $ban->ban_reason }}</td>
                    <td>{{ $ban->unban_reason }}</td>
                    <td>{{ $ban->created_at }}</td>
                    <td>{{ $ban->removed_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">{{ __('user.no-ban') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
