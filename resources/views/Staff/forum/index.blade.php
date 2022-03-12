@extends('layout.default')

@section('title')
    <title>Forums - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Forums - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.forums.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('forum.forums') }}
            <a href="{{ route('staff.forums.create') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.type') }}</th>
                    <th>{{ __('common.position') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        <a href="{{ route('staff.forums.edit', ['id' => $category->id]) }}">{{ $category->name }}</a>
                    </td>
                    <td>{{ __('common.category') }}</td>
                    <td>{{ $category->position }}</td>
                    <td>
                        <div class="data-table__actions">
                            <a href="{{ route('staff.forums.edit', ['id' => $category->id]) }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                            </a>
                            <form action="{{ route('staff.forums.destroy', ['id' => $category->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @foreach ($category->getForumsInCategory()->sortBy('position') as $forum)
                    <tr>
                        <td>
                            <a href="{{ route('staff.forums.edit', ['id' => $forum->id]) }}">---- {{ $forum->name }}</a>
                        </td>
                        <td>{{ __('forum.forum') }}</td>
                        <td>{{ $forum->position }}</td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.forums.edit', ['id' => $forum->id]) }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                </a>
                                <form action="{{ route('staff.forums.destroy', ['id' => $forum->id]) }}" method="POST">
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
            @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
