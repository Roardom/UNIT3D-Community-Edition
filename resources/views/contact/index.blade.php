@extends('layout.default')

@section('title')
    <title>{{ __('common.contact') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.contact') }} {{ config('other.title') }}.">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('contact.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.contact') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container box">
        <div class="sidebar2">
            <main>
                <x-panel.padded :heading="__('common.contact')">
                    <form role="form" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <label>
                            <input
                                type="text"
                                name="contact-name"
                                placeholder="{{ __('common.name') }}"
                                value="{{ auth()->user()->username }}"
                                required
                            >
                        </label>
                        <label>
                            <input
                                type="email"
                                name="email"
                                placeholder="{{ __('common.email') }}"
                                value="{{ auth()->user()->email }}"
                                required
                            >
                        </label>
                        <label>
                            <textarea
                                name="message"
                                placeholder="{{ __('common.message') }}"
                                class="form-control"
                                cols="30"
                                rows="10"
                            >
                            </textarea>
                        </label>
                        <button type="submit">{{ __('common.submit') }}</button>
                    </form>
                </x-panel.padded>
            </main>
            <aside>
                <x-panel.padded>
                    <x-slot name="heading">
                        <i class="{{ config('other.font-awesome') }} fa-star"></i>
                        {{ __('common.contact-header') }}
                        <i class="{{ config('other.font-awesome') }} fa-star"></i>
                    </x-slot>
                    {{ __('common.contact-desc') }}.
                </x-panel.padded>
            </aside>
        </div>
    </div>
@endsection
