@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.posts') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_posts', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.posts') }}</span>
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
        @if (!auth()->user()->isAllowed($user,'forum','show_post'))
            <x-panel :heading="__('user.private-profile')">
                {{ __('user.not-authorized') }}
            </x-panel>
        @else
            @foreach($results->filter(fn ($post) => $post->topic->viewable()) as $post)
                <x-forum.post
                    :id="$post->id"
                    :topicId="$post->topic->id"
                    :topicName="$post->topic->name"
                    :page="$post->getPageNumber()"
                    :datetime="$post->created_at"
                    :datetimeHuman="$post->created_at->diffForHumans()"
                    :authorId="$post->user->id"
                    :authorUsername="$post->user->username"
                    :authorAvatar="url($post->user->image == null ? 'img/profile.png' : 'files/img/'.$p->user->image)"
                    :authorIcon="$post->user->group->icon"
                    :authorColor="$post->user->group->color"
                    :authorGroup="$post->user->group->name"
                    :authorEffect="$post->user->group->effect"
                    :authorTitle="$post->user->title"
                    :authorJoinDatetime="$post->user->created_at"
                    :authorJoinDatetimeHuman="date('d M Y', $post->user->created_at->getTimestamp())"
                    :authorTopicCount="optional($post->user->topics)->count() ?? 0"
                    :authorPostsCount="optional($post->user->posts)->count() ?? 0"
                    :authorSignature="$post->user->signature ? $post->user->getSignature() : ''"
                    :isAuthorOnline="$post->user->isOnline()"
                    :tipCost="optional($post->tips)->sum('cost') ?? 0"
                    :isTopicOpen="$post->topic->state == 'open'"
                    :contentBbcode="$post->content"
                >
                    @joypixels($post->getContentHtml())
                </x-forum.post>
            @endforeach
            {{ $results->links() }}
        @endif
@endsection
