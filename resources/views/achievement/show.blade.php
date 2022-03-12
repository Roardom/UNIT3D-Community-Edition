@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.achievements') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('achievements.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}
                {{ __('user.achievements') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @if(auth()->user()->group && auth()->user()->group->is_modo == 1)
        @include('user.buttons.achievement')
    @endif
@endsection

@if (!auth()->user()->isAllowed($user,'achievement','show_achievement'))
    @section('content')
        <h1>{{ __('user.private-profile') }}</h1>
        <p>{{ __('user.not-authorized') }}</p>
    @endsection
@else
    @section('content')
        <x-panel class="achievements__unlocked" heading="{{ __('user.unlocked-achievements') }}">
            @foreach($achievements as $achievement)
                <x-achievement.card
                    :current-points="$achievement->points"
                    :total-points="$achievement->details->points"
                    :name="$achievement->details->name"
                    :description="$achievement->details->description"
                />
            @endforeach
        </x-panel>
    @endsection

    @section('sidebar')
        <x-panel class="achievement__statistics" heading="{{ __('user.achievement-statistics') }}">
            <dl>
                <dt>{{ __('user.unlocked-achievements') }}:</dt>
                <dd>{{ $user->unlockedAchievements()->count() }}</dd>
                <dt>{{ __('user.locked-achievements') }}:</dt>
                <dd>{{ $user->lockedAchievements()->count() }}</dd>
            </dl>
        </x-panel>
    @endsection
@endif