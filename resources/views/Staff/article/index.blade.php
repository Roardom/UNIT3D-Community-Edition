@extends('layout.default')

@section('title')
    <title>Articles - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.articles.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.articles') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('staff.articles') }}
            <a href="{{ route('staff.articles.create') }}">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table articles-table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>{{ __('common.comments') }}</th>
                <th>{{ __('common.action') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr class="articles-table__article">
                        <td>
                            <a href="{{ route('staff.articles.edit', ['id' => $article->id]) }}">
                                {{ $article->title }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('users.show', ['username' => $article->user->username]) }}">
                                {{ $article->user->username }}
                            </a>
                        </td>
                        <td>{{ $article->created_at }}</td>
                        <td>{{ $article->comments->count() }}</td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.articles.edit', ['id' => $article->id]) }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                </a>
                                <form
                                    action="{{ route('staff.articles.destroy', ['id' => $article->id]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $articles->links() }}</div>
    </x-panel>
@endsection
