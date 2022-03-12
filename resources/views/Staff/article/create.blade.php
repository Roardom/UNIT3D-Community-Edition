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
    <li>
        <a href="{{ route('staff.articles.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.articles') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.articles.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ __('common.add') }} {{ __('staff.articles') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel heading="{{ __('common.add') }} {{__('common.article') }}">
        <form role="form" method="POST" action="{{ route('staff.articles.store') }}" enctype="multipart/form-data">
            @csrf
            <label>
                {{ __('common.title') }}
                <input type="text" name="title" required>
            </label>
            <label for="image">
                {{ __('common.image') }}
                <input type="file" name="image">
            </label>
            <label for="content">
                {{ __('staff.article-content') }}
                <textarea name="content" id="content" cols="30" rows="10"></textarea>
            </label>
            <button type="submit">{{ __('common.submit') }}</button>
        </form>
    </x-panel>
@endsection

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('#content').wysibb({})
      })

    </script>
@endsection
