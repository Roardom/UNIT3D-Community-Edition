@extends('layout.default')

@section('title')
    <title>Failed Login Log - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Invites Log - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.authentications.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.failed-login-log') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel :heading="__('staff.failed-login-log')">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.no') }}</th>
                    <th>{{ __('user.user-id') }}</th>
                    <th>{{ __('common.username') }}</th>
                    <th>{{ __('common.ip') }}</th>
                    <th>{{ __('user.created-on') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attempts as $attempt)
                    <tr>
                        <td>
                            {{ $attempt->id }}
                        </td>
                        <td>
                            {{ $attempt->user_id ?? 'Not Found' }}
                        </td>
                        <td>
                            @if ($attempt->user_id == null)
                                {{ $attempt->username }}
                            @else
                                <a class="text-bold"
                                   href="{{ route('users.show', ['username' => $attempt->username]) }}">
                                    {{ $attempt->username }}
                                </a>
                            @endif
                        </td>
                        <td>
                            {{ $attempt->ip_address }}
                        </td>
                        <td>
                            {{ $attempt->created_at }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            No failed logins
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $attempts->links() }}</div>
    </x-panel>
@endsection
