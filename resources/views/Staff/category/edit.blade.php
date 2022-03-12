@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.categories.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.torrent-categories') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.categories.edit', ['id' => $category->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.edit') }}
                {{ __('torrent.torrent') }}
                {{ __('torrent.category') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <form
        role="form"
        method="POST"
        action="{{ route('staff.categories.update', ['id' => $category->id]) }}"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" name="name" value="{{ $category->name }}">
        </label>
        <label>
            {{ __('common.position') }}
            <input type="text" name="position" value="{{ $category->position }}">
        </label>
        <label>
            {{ __('common.icon') }} (FontAwesome)
            <input type="text" name="icon" value="{{ $category->icon }}">
        </label>
        <label for="image">
            {{ __('common.select') }}
            {{ trans_choice('common.a-an-art',false) }}
            {{ __('common.image') }}
            (If Not Using A FontAwesome Icon)
            <input type="file" name="image">
        </label>
        <label>
            <input type="hidden" name="movie_meta" value="0">
            <input type="checkbox" name="movie_meta" value="1" {{ $category->movie_meta ? 'checked' : '' }}>
            Movie metadata?
        </label>
        <label>
            <input type="hidden" name="tv_meta" value="0">
            <input type="checkbox" name="tv_meta" value="1" {{ $category->tv_meta ? 'checked' : '' }}>
            TV metadata?
        </label>
        <label>
            <input type="hidden" name="game_meta" value="0">
            <input type="checkbox" name="game_meta" value="1" {{ $category->game_meta ? 'checked' : '' }}>
            Game metadata?
        </label>
        <label>
            <input type="hidden" name="music_meta" value="0">
            <input type="checkbox" name="music_meta" value="1" {{ $category->music_meta ? 'checked' : '' }}>
            Music metadata?
        </label>
        <label>
            <input type="hidden" name="no_meta" value="0">
            <input type="checkbox" name="no_meta" value="1" {{ $category->no_meta ? 'checked' : '' }}>
            No metadata?
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection
