@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.profile') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_edit_profile_form', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.profile') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @if(!($route == 'profile' && auth()->user()->id != $user->id))
        <x-nav>
            <x-nav.tab href="{{ route('users.show', ['username' => $user->username]) }}">
                {{ __('user.profile') }}
            </x-nav.tab>
            @if(auth()->user()->id == $user->id)
                <x-slot name="right">
                    <x-nav.tab href="{{ route('user_settings', ['username' => $user->username]) }}">
                        {{ __('user.settings') }}
                    </x-nav.tab>
                    <x-nav.tab href="{{ route('user_edit_profile_form', ['username' => $user->username]) }}">
                        {{ __('user.edit-profile') }}
                    </x-nav.tab>
                </x-slot>
            @endif
        </x-nav>
    @endif

@endsection

@section('content')
    <form
        method="POST"
        action="{{ route('user_edit_profile', ['username' => $user->username]) }}"
        enctype="multipart/form-data"
        style="display: contents;"
    >
        @csrf
        <x-panel :padded="true">
            <x-slot name="heading">
                <label for="image">{{ __('user.avatar') }}</label>
            </x-slot>
            {{ __('user.formats-are-supported', ['formats' => '.jpg, .jpeg, .bmp, .png, .tiff, .gif']) }}
            <input type="file" name="image" id="image">
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <label for="title">{{ __('user.custom-title') }}</label>
            </x-slot>
            <input type="text" name="title" id="title" class="form-control" value="{{ $user->title }}">
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <label for="about">{{ __('user.about-me') }}</label>
            </x-slot>
            <textarea name="about" id="about" cols="30" rows="10">{{ $user->about }}</textarea>
        </x-panel>
        <x-panel>
            <x-slot name="heading">
                <label for="signature">{{ __('user.forum-signature') }}</label>
            </x-slot>
            <textarea name="signature" id="signature" cols="30" rows="10">{{ $user->signature }}</textarea>
        </x-panel>
        <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
    </form>
    <x-panel :heading="__('forum.current')">
        <x-forum.post
            :id="1"
            :topicId="1"
            :page="1"
            :datetime="date('Y-m-d H:i:s')"
            :datetimeHuman="date('Y-m-d H:i:s')"
            :authorId="$user->id"
            :authorUsername="$user->username"
            :authorAvatar="url($user->image == null ? 'img/profile.png' : 'files/img/'.$user->image)"
            :authorIcon="$user->group->icon"
            :authorColor="$user->group->color"
            :authorGroup="$user->group->name"
            :authorEffect="$user->group->effect"
            :authorTitle="$user->title ?: ''"
            :authorJoinDatetime="$user->created_at"
            :authorJoinDatetimeHuman="date('d M Y', $user->created_at->getTimestamp())"
            :authorTopicCount="optional($user->topics)->count() ?? 0"
            :authorPostsCount="optional($user->posts)->count() ?? 0"
            :authorSignature="$user->signature ? $user->getSignature() : ''"
            :isAuthorOnline="$user->isOnline()"
            :tipCost="1000"
            :isTopicOpen="true"
        >
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
            in culpa qui officia deserunt mollit anim id est laborum.
        </x-forum.post>
    </x-panel>
@endsection

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('#about, #signature').wysibb({})
      })
    </script>
@endsection