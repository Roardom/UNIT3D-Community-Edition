@extends('layout.default')

@section('title')
    <title>Bans - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Bans - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.bans.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.bans-log') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel heading="{{ __('common.user') }} {{ __('user.bans') }}">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('common.user') }}</th>
                    <th>{{ __('user.judge') }}</th>
                    <th>{{ __('user.reason-ban') }}</th>
                    <th>{{ __('user.reason-unban') }}</th>
                    <th>{{ __('user.created') }}</th>
                    <th>{{ __('user.removed') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bans as $b)
                    <tr>
                        <td>
                            {{ $b->id }}
                        </td>
                        <td class="user-name">
                            <a class="name"
                               href="{{ route('users.show', ['username' => $b->banneduser->username]) }}">{{ $b->banneduser->username }}</a>
                        </td>
                        <td class="user-name">
                            <a class="name"
                               href="{{ route('users.show', ['username' => $b->staffuser->username]) }}">{{ $b->staffuser->username }}</a>
                        </td>
                        <td>
                            {{ $b->ban_reason }}
                        </td>
                        <td>
                            {{ $b->unban_reason }}
                        </td>
                        <td>
                            {{ $b->created_at }}
                        </td>
                        <td>
                            {{ $b->removed_at }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            No bans
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $bans->links() }}</div>
    </x-panel>
@endsection
