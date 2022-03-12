@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.followers') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_followers', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.followers') }}</span>
        </a>
    </li>
@endsection

@section('content')
        @if (!auth()->user()->isAllowed($user,'follower','show_follower'))
            <div class="container pl-0 text-center">
                <div class="jumbotron shadowed">
                    <div class="container">
                        <h1 class="mt-5 text-center">
                            <i class="{{ config('other.font-awesome') }} fa-times text-danger"></i>{{ __('user.private-profile') }}
                        </h1>
                        <div class="separator"></div>
                        <p class="text-center">{{ __('user.not-authorized') }}</p>
                    </div>
                </div>
            </div>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('user.avatar') }}</th>
                        <th>{{ __('user.user') }}</th>
                        <th>{{ __('common.created_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $follower)
                        <tr>
                            <td>
                                <a href="{{ route('users.show', ['username' => $follower->user->username]) }}">
                                    <img
                                        src="{{ url($follower->user->image ? 'files/img/'.$follower->user->image : 'img/profile.png') }}"
                                        alt="avatar"
                                        title="{{ $follower->user->username }}"
                                        style="height: 50px"
                                    >
                                </a>
                            </td>
                            <td>
                                <x-chip.user
                                    :anon="false"
                                    :userId="$follower->user->id"
                                    :username="$follower->user->username"
                                    :href="route('users.show', ['username' => $follower->user->username])"
                                    :icon="$follower->user->group->icon"
                                    :color="$follower->user->group->color"
                                    :group="$follower->user->group->name"
                                    :effect="$follower->user->group->effect"
                                />
                            </td>
                            <td>{{ $follower->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $results->links() }}
        @endif
@endsection
