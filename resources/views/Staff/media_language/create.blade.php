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
        <a href="{{ route('staff.media_languages.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.add') }} {{ __('common.media-language') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.media_languages.store') }}">
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" name="name">
        </label>
        <label>
            {{ __('common.code') }}
            <input type="text" name="code">
        </label>
        <button type="submit">{{ __('common.add') }}</button>
    </form>
@endsection
