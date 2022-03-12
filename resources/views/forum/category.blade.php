@extends('layout.default')

@section('title')
    <title>{{ $forum->name }} - {{ __('forum.forums') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('forum.display-forum') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('forums.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('forum.forums') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('forums.categories.show', ['id' => $forum->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        {{--            @include('forum.buttons')--}}
        <x-slot name="right">
            <x-nav.tab>
                <form role="form" method="GET" action="{{ route('forum_search_form') }}">
                    <input type="hidden" name="sorting" value="updated_at">
                    <input type="hidden" name="direction" value="desc">
                    <input type="hidden" name="category" value="{{ $forum->id }}">
                    <label for="name"></label>
                    <input type="hidden" name="name" id="name"
                           value="{{ isset($params) && is_array($params) && array_key_exists('name', $params) ? $params['name'] : '' }}"
                           placeholder="{{ __('forum.category-quick-search') }}"
                    >
                    <button type="submit">{{ __('common.search') }}</button>
                </form>
            </x-nav.tab>
        </x-slot>
    </x-nav>
@endsection

@section('content')
    <x-panel :heading="$forum->description">
        <ul class="topic-listings">
            @foreach ($topics as $topic)
                <li class="topic-listings__item">
                    <x-forum.topic-listing
                        :name="$topic->name"
                        :link="route('forum_topic', ['id' => $topic->id])"
                        :authorUsername="$topic->first_post_user_username"
                        :authorLink="route('users.show', ['username' => $topic->first_post_user_username])"
                        :postCount="$topic->num_post - 1"
                        :viewCount="$topic->views"
                        :isPinned="$topic->pinned == 1"
                        :isClosed="$topic->state == 'close'"
                        :isApproved="$topic->approved == '1'"
                        :isDenied="$topic->denied == '1'"
                        :isSolved="$topic->solved == '1'"
                        :isInvalid="$topic->invalid == '1'"
                        :isBug="$topic->bug == '1'"
                        :isSuggestion="$topic->suggestion == '1'"
                        :isImplemented="$topic->implemented == '1'"
                        :latestPostAuthorUsername="$topic->last_post_user_username"
                        :latestPostAuthorLink="route('users.show', ['username' => $topic->last_post_user_username])"
                        :latestPostDatetime="$topic->last_reply_at"
                        :latestPostDatetimeHuman="optional($topic->last_reply_at)->diffForHumans() ?? __('common.unknown')"
                        :forumName="$topic->forum->name"
                    />
                </li>
            @endforeach
        </ul>
    </x-panel>
    {{ $topics->links() }}
    @include('forum.stats')
@endsection
