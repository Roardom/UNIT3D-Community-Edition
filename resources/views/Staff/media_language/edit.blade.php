@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.media_languages.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.media-languages') }}
            </span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.media_languages.edit', ['id' => $media_language->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.edit') }} {{ __('common.media-language') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <form method="POST" action="{{ route('staff.media_languages.update', ['id' => $media_language->id]) }}">
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" name="name" value="{{ $media_language->name }}">
        </label>
        <label>
            {{ __('common.code') }}
            <input type="text" name="code" value="{{ $media_language->code }}">
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection
