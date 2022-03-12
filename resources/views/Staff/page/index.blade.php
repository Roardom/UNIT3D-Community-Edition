@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.pages.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.pages') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('staff.pages') }}
            <a href="{{ route('staff.pages.create') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.title') }}</th>
                    <th>{{ __('common.date') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>
                            <a href="{{ route('pages.show', ['id' => $page->id]) }}">
                                {{ $page->name }}
                            </a>
                        </td>
                        <td>
                            {{ $page->created_at }} ({{ $page->created_at->diffForHumans() }})
                        </td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.pages.edit', ['id' => $page->id]) }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                </a>
                                <form action="{{ route('staff.pages.destroy', ['id' => $page->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
