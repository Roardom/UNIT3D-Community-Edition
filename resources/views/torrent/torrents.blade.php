@extends('layout.default')

@section('title')
    <title>{{ __('torrent.torrents') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('torrent.torrents') }} {{ config('other.title') }}">
@endsection

@section('breadcrumb')
    <li class="active">
        <a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('torrent.torrents') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('upload_form', ['category_id' => 1]) }}">
            {{ __('common.publish') }} {{ __('torrent.torrent') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('torrents') }}">
            {{ __('torrent.list') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('cards') }}">
            {{ __('torrent.cards') }}
        </x-nav.tab>
        <x-nav.tab href="#">
            {{ __('torrent.groupings') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('rss.index') }}">
            {{ __('rss.rss') }} {{ __('rss.feeds') }}
        </x-nav.tab>
    </x-nav>
@endsection

@section('content')
    <div>
        @livewire('torrent-list-search')
    </div>
@endsection
