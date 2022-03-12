@extends('layout.default')

@section('title')
    <title>{{ __('articles.articles') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('articles.meta-articles') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('articles.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('articles.articles') }}</span>
        </a>
    </li>
@endsection

@section('content')
    @foreach ($articles as $article)
        <x-article.card
            :id="$article->id"
            :title="$article->title"
            :datetime="$article->created_at"
            :datetime-human="$article->created_at->diffForHumans()"
            :image="$article->image ? 'files/img/'.$article->image : 'img/missing-image.png'"
            :content="$article->content"
        />
    @endforeach
    <div class="text-center">
        {{ $articles->links() }}
    </div>
@endsection
