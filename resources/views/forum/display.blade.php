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
        <a href="{{ route('forums.show', ['id' => $forum->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('forums.index') }}">
            {{ __('forum.forums') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('forum_latest_topics') }}">
            {{ __('common.latest-topics') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('forum_latest_posts') }}">
            {{ __('common.latest-posts') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('forum_subscriptions') }}">
            {{ __('common.subscriptions') }}
        </x-nav.tab>
        <x-nav.tab>
            <form role="form" method="GET" action="{{ route('forum_search_form') }}">
                <input type="hidden" name="sorting" value="created_at">
                <input type="hidden" name="direction" value="desc">
                <input type="hidden" name="category" value="{{ $forum->id }}">
                <label for="name"></label>
                <input
                    type="hidden"
                    name="name"
                    id="name"
                    value="{{ isset($params) && is_array($params) && array_key_exists('name', $params) ? $params['name'] : '' }}"
                    placeholder="{{ __('forum.category-quick-search') }}"
                >
                <button type="submit">
                    <i class="{{ config('other.font-awesome') }} fa-search"></i> {{ __('common.search') }}
                </button>
            </form>
        </x-nav.tab>
        <x-slot name="right">
            @if ($category->getPermission()->start_topic == true)
                <x-nav.tab href="{{ route('forum_new_topic_form', ['id' => $forum->id]) }}">
                    {{ __('forum.create-new-topic') }}
                </x-nav.tab>
            @endif
            @if ($category->getPermission()->show_forum == true)
                @if (auth()->user()->isSubscribed('forum',$forum->id))
                    <x-nav.tab>
                        <form
                            action="{{ route('unsubscribe_forum', ['forum' => $forum->id, 'route' => 'forum']) }}"
                            method="POST"
                        >
                            @csrf
                            <button type="submit">
                                <i class="{{ config('other.font-awesome') }} fa-bell-slash"></i>
                                {{ __('forum.unsubscribe') }}
                            </button>
                        </form>
                    </x-nav.tab>
                @else
                    <x-nav.tab>
                        <form
                            action="{{ route('subscribe_forum', ['forum' => $forum->id, 'route' => 'forum']) }}"
                            method="POST"
                        >
                            @csrf
                            <button type="submit">
                                <i class="{{ config('other.font-awesome') }} fa-bell"></i>
                                {{ __('forum.subscribe') }}
                            </button>
                        </form>
                    </x-nav.tab>
                @endif
            @endif
        </x-slot>
    </x-nav>
@endsection

@section('content')
    {{ $topics->links() }}
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
                    />
                </li>
            @endforeach
        </ul>
    </x-panel>
    {{ $topics->links() }}
    @include('forum.stats')
@endsection
