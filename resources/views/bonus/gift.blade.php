@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('bonus') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.points') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('bonus_gift') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.send-gift') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @include('bonus.buttons', ['nav' => 'bon-nav__gift'])
@endsection

@section('content')
    <x-panel :padded="true" :heading="__('bon.gift-to')">
        <form role="form" method="POST" action="{{ route('bonus_send_gift') }}" id="send_bonus">
            @csrf
            <label for="to_username">
                {{ __('pm.select') }}
                <input
                    name="to_username"
                    placeholder="{{ __('common.username') }}"
                    required
                >
            </label>
            <label for="bonus_points">
                {{ __('bon.amount') }}
                <input
                    placeholder="{{ __('common.enter') }} {{ strtolower(__('common.amount')) }}"
                    name="bonus_points"
                    type="number"
                    required
                >
            </label>
            <label for="bonus_message">
                {{ __('pm.message') }}
                <textarea
                    name="bonus_message"
                    cols="50"
                    rows="10"
                ></textarea>
            </label>
            <input type="submit" value="{{ __('common.submit') }}">
        </form>
    </x-panel>
@endsection

@section('sidebar')
    <x-panel :padded="true" :heading="__('bon.your-points')">
        {{ $userbon }}
    </x-panel>
    <x-panel :padded="true" :heading="__('bon.no-refund')">
        <strong>{{ __('bon.exchange-warning') }}</strong>
    </x-panel>
@endsection
