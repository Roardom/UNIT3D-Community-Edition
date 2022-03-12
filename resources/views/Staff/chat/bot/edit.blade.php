@extends('layout.default')

@section('title')
    <title>{{ __('bot.edit-bot') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.bots.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bot.bots') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.bots.edit', ['id' => $bot->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bot.edit-bot') }}</span>
        </a>
    </li>
@endsection


@section('content')
    <form role="form" method="POST" action="{{ route('staff.bots.update', ['id' => $bot->id]) }}">
        @csrf
        @method('PATCH')
        <label>
            {{ __('bot.name') }}
            <input type="text" name="name" value="{{ $bot->name }}">
        </label>
        <label>
            {{ __('common.position') }}
            <input type="number" name="position" value="{{ $bot->position }}" class="form-control">
        </label>
        <label>
            {{ __('bot.command') }}
            <input type="text" name="command" value="{{ $bot->command }}">
        </label>
        <label>
            {{ __('bot.info') }}
            <input type="text" name="info" value="{{ $bot->info }}">
        </label>
        <label>
            {{ __('bot.about') }}
            <input type="text" name="about" value="{{ $bot->about }}">
        </label>
        <label>
            {{ __('bot.emoji-code') }}
            <input type="text" name="emoji" value="{{ $bot->emoji }}">
        </label>
        <label>
            {{ __('bot.icon') }}
            <input type="text" name="icon" value="{{ $bot->icon }}">
        </label>
        <label>
            {{ __('bot.color') }}
            <input type="text" name="color" value="{{ $bot->color }}">
        </label>
        <label>
            {{ __('bot.help') }}
            <textarea name="help" cols="30" rows="10" class="form-control">{{ $bot->help }}</textarea>
        </label>
        <button type="submit">{{ __('common.edit') }}</button>
    </form>
@endsection
