@extends('layout.default')

@section('title')
    <title>{{ $article->title }} - {{ __('articles.articles') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ substr(strip_tags($article->content), 0, 200) }}...">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('articles.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('articles.articles') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('articles.show', ['id' => $article->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $article->title }}</span>
        </a>
    </li>
@endsection

@section('content')
    <header class="page__header">
        <h1 class="page__title">{{ $article->title }}</h1>
        <time class="page__published" datetime="{{ $article->created_at }}">
            {{ $article->created_at->toDayDateTimeString() }}
        </time>
    </header>

    <p>@joypixels($article->getContentHtml())</p>

    <section class="comments-section">
        <x-panel class="comments">
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-comment"></i> {{ __('common.comments') }}
            </x-slot>
            @foreach($article->comments as $comment)
                <x-comment
                    :id="$comment->id"
                    :avatar="$comment->user->image ?: '/img/profile.png'"
                    :username="$comment->user->username"
                    :user-id="$comment->user->id"
                    :anonymous="$comment->anon"
                    :group-icon="$comment->user->group->icon"
                    :group-color="$comment->user->group->color"
                    :group="$comment->user->group->name"
                    :datetime="$comment->created_at"
                    :datetime-human="$comment->created_at->diffForHumans()"
                >
                    @joypixels($comment->getContentHtml())
                </x-comment>
            @endforeach
            @each('partials.comment', $article->comments, 'comment')
        </x-panel>
        <x-panel class="comments__add" :heading="__('common.your-comment').':'">
            <form role="form" method="POST" action="{{ route('comment_article', ['id' => $article->id]) }}">
                @csrf
                <textarea id="content" name="content" cols="30" rows="5" class="form-control"></textarea>
                <button type="submit" class="btn btn-danger">{{ __('common.submit') }}</button>
                <label>
                    <input type="hidden" name="anonymous" value="0">
                    <input type="checkbox" name="anonymous" value="1">
                    {{ __('common.anonymous') }} {{ __('common.comment') }}
                </label>
            </form>
        </x-panel>
    </section>
    @each('partials.modals', $article->comments, 'comment')
    <style>
        .page__header {
            text-align: center;
        }
    </style>
@endsection
