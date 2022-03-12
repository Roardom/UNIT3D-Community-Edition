@extends('layout.default')

@section('title')
    <title>{{ __('forum.forums') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ config('other.title') }} - {{ __('forum.forums') }}">
@endsection


@section('breadcrumb')
    <li class="active">
        <a href="{{ route('forums.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('forum.forums') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab>
            <form role="form" method="GET" action="{{ route('forum_search_form') }}">
                <input type="hidden" name="sorting" value="created_at">
                <input type="hidden" name="direction" value="desc">
                <label for="name"></label>
                <input
                    type="hidden"
                    name="name"
                    id="name"
                    value="{{ isset($params) && is_array($params) && array_key_exists('name', $params) ? $params['name'] : '' }}"
                    placeholder="{{ __('forum.topic-quick-search') }}"
                >
                <button type="submit">
                    <i class="{{ config('other.font-awesome') }} fa-search"></i> {{ __('common.search') }}
                </button>
            </form>
        </x-nav.tab>
    </x-nav>
@endsection

@section('content')
    @foreach ($categories as $category)
        @if (
            $category->getPermission() != null
            && $category->getPermission()->show_forum == true
            && $category->getForumsInCategory()->count() > 0
        )
            <x-panel>
                <x-slot name="heading">
                    <a href="{{ route('forums.categories.show', ['id' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </x-slot>
                <ul class="subForum-listings">
                    @foreach ($category->getForumsInCategory()->sortBy('position') as $subforum)
                        @if($subforum->getPermission() != null && $subforum->getPermission()->show_forum == true)
                            <li class="subforum-listings__item">
                                <x-forum.subforum-listing
                                    :name="$subforum->name"
                                    :link="route('forums.show', ['id' => $subforum->id])"
                                    :description="$subforum->description"
                                    :topicCount="$subforum->num_topic ?: 0"
                                    :postCount="$subforum->num_post ?: 0"
                                    :latestLink="route('forum_topic', ['id' => $subforum->last_topic_id ?? 1])"
                                    :latestName="$subforum->last_topic_name"
                                    :latestDatetime="$subforum->updated_at"
                                    :latestDatetimeHuman="$subforum->updated_at->diffForHumans()"
                                    :latestAuthorUsername="$subforum->last_post_user_username"
                                    :latestAuthorLink="route('users.show', ['username' => $subforum->last_post_user_username ?? 1])"
                                    :latestExists="$subforum->last_topic_id !== null && $subforum->last_post_user_username !== null"
                                />
                            </li>
                        @endif
                    @endforeach
                </ul>
            </x-panel>
        @endif
    @endforeach
    @include('forum.stats')
@endsection