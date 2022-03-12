@extends('layout.default')

@section('title')
    <title>Gifting - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Gifting - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.gifts.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.user-gifting') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <form action="{{ route('staff.gifts.store') }}" method="POST">
        @csrf
        <label>
            {{ __('common.username') }}
            <input name="username" placeholder="{{ __('common.username') }}" required>
        </label>
        <label>
            {{ __('bon.bon') }}
            <input type="number" name="seedbonus" value="0">
        </label>
        <label>
            {{ __('user.invites') }}
            <input type="number" name="invites" value="0">
        </label>
        <label>
            {{ __('torrent.freeleech-token') }}
            <input type="number" name="fl_tokens" value="0">
        </label>
        <button type="submit">{{ __('bon.send-gift') }}</button>
    </form>
@endsection
