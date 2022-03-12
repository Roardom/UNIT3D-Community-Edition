@extends('layout.default')

@section('title')
    <title>{{ __('staff.mass-pm') }} - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('staff.mass-pm') }} - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.mass-pm.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.mass-pm') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <form action="{{ route('staff.mass-pm.store') }}" method="POST">
        @csrf
        <label>
            {{ __('pm.subject') }}
            <input type="text" name="subject">
        </label>
        <label>
            {{ __('pm.message') }}
            <textarea id="message" name="message" cols="30" rows="10"></textarea>
        </label>
        <button type="submit">{{ __('pm.send') }}</button>
    </form>
@endsection

@section('javascripts')
    <script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(document).ready(function () {
        $('#message').wysibb({})
      })

    </script>
@endsection
