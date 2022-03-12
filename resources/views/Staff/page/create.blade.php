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
        <a href="{{ route('staff.types.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.add') }}
                {{ trans_choice('common.a-an-art',false) }}
                {{ __('common.new-adj') }}
                {{ __('staff.page') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.pages.store') }}">
        @csrf
        <label>
            {{ __('staff.page') }} {{ __('common.name') }}
            <input type="text" name="name">
        </label>
        <label for="content">
            {{ __('common.content') }}
            <textarea name="content" id="editor" cols="30" rows="10"></textarea>
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('#content').wysibb({})
      })

    </script>
@endsection
