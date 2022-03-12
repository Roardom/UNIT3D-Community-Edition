@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.pages.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.pages') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.pages.edit', ['id' => $page->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.edit') }} {{ __('staff.page') }}: {{ $page->name }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.pages.update', ['id' => $page->id]) }}">
        @csrf
        <label>
            {{ __('staff.page') }} {{ __('common.name') }}
            <input type="text" name="name" value="{{ $page->name }}">
        </label>
        <label for="content">
            {{ __('common.content') }}
            <textarea name="content" cols="30" rows="10">{{ $page->content }}</textarea>
        </label>
        <button type="submit">{{ __('common.save') }}</button>
    </form>
@endsection

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('[name=content]').wysibb({})
      })

    </script>
@endsection
