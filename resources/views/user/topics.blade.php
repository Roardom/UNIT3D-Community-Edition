@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.topics') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_topics', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.topics') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('user_posts', ['username' => $user->username]) }}">
            {{ __('user.posts') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('user_topics', ['username' => $user->username]) }}">
            {{ __('user.topics') }}
        </x-nav.tab>
    </x-nav>
@endsection

@section('content')
    @if (!auth()->user()->isAllowed($user,'forum','show_topic'))
        <x-panel :heading="__('user.private-profile')">
            {{ __('user.not-authorized') }}
        </x-panel>
    @else
        <ul class="topic-listings">
            @foreach ($results->filter(fn ($topic) => $topic->viewable()) as $topic)
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
        {{ $results->links() }}
    @endif
@endsection
