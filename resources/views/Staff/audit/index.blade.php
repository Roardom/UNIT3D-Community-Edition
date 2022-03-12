@extends('layout.default')

@section('title')
    <title>Audits Log - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Audits Log - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.audits.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.audit-log') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            <i class="{{ config('other.font-awesome') }} fa-list"></i>
            {{ __('staff.audit-log') }}
        </x-slot>
        <table class="data-table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('common.action') }}</th>
                <th>Model</th>
                <th>Model ID</th>
                <th>By</th>
                <th>Changes</th>
                <th>{{ __('user.created-on') }}</th>
                <th>{{ __('common.action') }}</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($audits as $audit)
                    @php $values = json_decode($audit->record, true, 512, JSON_THROW_ON_ERROR) @endphp
                    <tr>
                        <td>{{ $audit->id }}</td>
                        <td>{{ strtoupper($audit->action) }}</td>
                        <td>{{ $audit->model_name }}</td>
                        <td>{{ $audit->model_entry_id }}</td>
                        <td>
                            <a href="{{ route('users.show', ['username' => $audit->user->username]) }}">
                                {{ $audit->user->username }}
                            </a>
                        </td>
                        <td>
                            @foreach ($values as $key => $value)
                                <span class="badge badge-extra">{{ $key }}:</span> {{ $value['old'] }} &rarr;
                                {{ $value['new'] }}<br>
                            @endforeach
                        </td>
                        <td>
                            <span class="audit-log__datetime">{{ $audit->created_at }}</span>
                            <span class="audit-log__datetimeHuman">{{ $audit->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            <form action="{{ route('staff.audits.destroy', ['id' => $audit->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            No audits
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $audits->links() }}</div>
    </x-panel>
@endsection
