@extends('layout.default')

@section('title')
    <title>{{ $user->username }} - {{ __('user.send-invite') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('invites.index', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('user.send-invite') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('invites.index', ['username' => $user->username]) }}">
            {{ __('user.invites') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('invites.create') }}">
            {{ __('user.send-invite') }}
        </x-nav.tab>
    </x-nav>
@endsection

@section('content')
    @if (config('other.invite-only') == false)
        <x-panel :padded="true" :heading="__('user.invites-disabled')">
            {{ __('user.invites-disabled-desc') }}
        </x-panel>
    @elseif ($user->can_invite == 0)
        <x-panel :padded="true" :heading="__('user.invites-banned')">
            {{ __('user.invites-banned-desc') }}
        </x-panel>
    @else
        <x-panel :padded="true" :heading="__('user.invites-count', ['count' => $user->invites])">
            {{ __('user.important') }}:
            <ul>
                {!! __('user.invites-rules') !!}
            </ul>
        </x-panel>

        <x-panel :heading="__('user.invite-friend')">
            <form action="{{ route('invites.store') }}" method="POST">
                @csrf
                <label>
                    {{ __('common.email') }}
                    <input name="email" type="email" id="email" size="10" required>
                </label>
                <label>
                    {{ __('common.message') }}
                    <textarea name="message" cols="50" rows="10" id="message"></textarea>
                </label>
                <button type="submit">{{ __('common.submit') }}</button>
            </form>
        </x-panel>
    @endif
@endsection
