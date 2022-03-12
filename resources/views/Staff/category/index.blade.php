@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.categories.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.torrent-categories') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('torrent.categories') }}
            <a href="{{ route('staff.categories.create') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
            <tr>
                <th>{{ __('common.position') }}</th>
                <th>{{ __('common.name') }}</th>
                <th>{{ __('common.icon') }}</th>
                <th>{{ __('common.image') }}</th>
                <th>Movie Meta</th>
                <th>TV Meta</th>
                <th>Game Meta</th>
                <th>Music Meta</th>
                <th>No Meta</th>
                <th>{{ __('common.action') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->position }}</td>
                        <td>
                            <a href="{{ route('staff.categories.edit', ['id' => $category->id]) }}">
                                {{ $category->name }}
                            </a>
                        </td>
                        <td>
                            <i class="{{ $category->icon }}"></i>
                        </td>
                        <td>
                            @if ($category->image != null)
                                <img alt="{{ $category->name }}" src="{{ url('files/img/' . $category->image) }}">
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                        <td>
                            @if ($category->movie_meta)
                                <i class="{{ config('other.font-awesome') }} fa-check" style="color: green"></i>
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                            @endif
                        </td>
                        <td>
                            @if ($category->tv_meta)
                                <i class="{{ config('other.font-awesome') }} fa-check" style="color: green"></i>
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                            @endif
                        </td>
                        <td>
                            @if ($category->game_meta)
                                <i class="{{ config('other.font-awesome') }} fa-check" style="color: green"></i>
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                            @endif
                        </td>
                        <td>
                            @if ($category->music_meta)
                                <i class="{{ config('other.font-awesome') }} fa-check" style="color: green"></i>
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                            @endif
                        </td>
                        <td>
                            @if ($category->no_meta)
                                <i class="{{ config('other.font-awesome') }} fa-check" style="color: green"></i>
                            @else
                                <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                            @endif
                        </td>
                        <td class="data-table__actions">
                            <a href="{{ route('staff.categories.edit', ['id' => $category->id]) }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                            </a>
                            <form
                                action="{{ route('staff.categories.destroy', ['id' => $category->id]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
