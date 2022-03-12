@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.media_languages.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ __('common.media-languages') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('common.media-languages') }}
            {{ __('staff.media-languages-desc') }}
            <a href="{{ route('staff.media_languages.create') }}">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.code') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($media_languages as $media_language)
                    <tr>
                        <td>
                            <a href="{{ route('staff.media_languages.edit', ['id' => $media_language->id]) }}">
                                {{ $media_language->name }}
                            </a>
                        </td>
                        <td>{{ $media_language->code }}</td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.media_languages.edit', ['id' => $media_language->id]) }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
