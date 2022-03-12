@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.internals.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Internals</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            Internal Groups
            <a href="{{ route('staff.internals.create') }}" class="btn btn-primary">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('common.name') }}</th>
                    <th>Icon</th>
                    <th>Effect</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($internals as $internal)
                    <tr>
                        <td>{{ $internal->id }}</td>
                        <td>{{ $internal->name }}</td>
                        <td>{{ $internal->icon }}</td>
                        <td>{{ $internal->effect }}</td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.internals.edit', ['id' => $internal->id]) }}">
                                    <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                </a>
                                <form
                                    action="{{ route('staff.internals.destroy', ['id' => $internal->id]) }}"
                                    method="POST"
                                >
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
