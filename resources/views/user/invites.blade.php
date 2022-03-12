@extends('layout.default')

@section('title')
    <title>{{ $owner->username }} - {{ __('user.invites') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $owner->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $owner->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('invites.index', ['username' => $owner->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $owner->username }} {{ __('user.invites') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('invites.index', ['username' => $owner->username]) }}">
            {{ __('user.invites') }}
        </x-nav.tab>
        @if(auth()->user()->id == $owner->id)
            <x-nav.tab href="{{ route('invites.create') }}">
                {{ __('user.send-invite') }}
            </x-nav.tab>
        @endif
    </x-nav>
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('user.sender') }}</th>
                <th>{{ __('common.email') }}</th>
                <th>{{ __('user.code') }}</th>
                <th>{{ __('user.created-on') }}</th>
                <th>{{ __('user.expires-on') }}</th>
                <th>{{ __('user.accepted-by') }}</th>
                <th>{{ __('user.accepted-at') }}</th>
                <th>{{ __('common.resend') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invites as $invite)
                <tr>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$invite->sender->id"
                            :username="$invite->sender->username"
                            :href="route('users.show', ['username' => $invite->sender->username])"
                            :icon="$invite->sender->group->icon"
                            :color="$invite->sender->group->color"
                            :group="$invite->sender->group->name"
                            :effect="$invite->sender->group->effect"
                        />
                    </td>
                    <td>{{ $invite->email }}</td>
                    <td>{{ $invite->code }}</td>
                    <td>{{ $invite->created_at }}</td>
                    <td>{{ $invite->expires_on }}</td>
                    <td>
                        @if ($invite->accepted_by != null && $invite->accepted_by != 1)
                            <x-chip.user
                                :anon="false"
                                :userId="$invite->receiver->id"
                                :username="$invite->receiver->username"
                                :href="route('users.show', ['username' => $invite->receiver->username])"
                                :icon="$invite->receiver->group->icon"
                                :color="$invite->receiver->group->color"
                                :group="$invite->receiver->group->name"
                                :effect="$invite->receiver->group->effect"
                            />
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $invite->accepted_at ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('invites.send', ['id' => $invite->id]) }}" method="POST">
                            @csrf
                            <button type="submit" @if ($invite->accepted_at !== null) disabled @endif>
                                <i class="{{ config('other.font-awesome') }} fa-sync-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">{{ __('user.no-logs') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $invites->links() }}
@endsection
