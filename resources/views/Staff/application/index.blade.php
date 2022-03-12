@extends('layout.default')

@section('title')
    <title>Applications - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Applications - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.applications.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.applications') }}</span>
        </a>
    </li>
@endsection

@section('content')
        <x-panel :heading="__('staff.applications')">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('common.user') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('staff.application-type') }}</th>
                        <th>{{ __('gallery.images') }}</th>
                        <th>{{ __('staff.links') }}</th>
                        <th>{{ __('common.created_at') }}</th>
                        <th>{{ __('common.status') }}</th>
                        <th>{{ __('common.moderated-by') }}</th>
                        <th>{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>{{ $application->user->username ?? 'N/A' }}</td>
                            <td>{{ $application->email }}</td>
                            <td>{{ $application->type }}</td>
                            <td>{{ $application->imageProofs->count() }}</td>
                            <td>{{ $application->urlProofs->count() }}</td>
                            <td>
                                {{ $application->created_at->toDayDateTimeString() }}
                                ({{ $application->created_at->diffForHumans() }})
                            </td>
                            <td>
                                @if ($application->status == 0)
                                    <span class="application--pending">PENDING</span>
                                @elseif ($application->status == 1)
                                    <span class="application--approved">APPROVED</span>
                                @else
                                    <span class="application--rejected">REJECTED</span>
                                @endif
                            </td>
                            <td>{{ $application->moderated->username ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('staff.applications.show', ['id' => $application->id]) }}">
                                    {{ __('common.view') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="applications--empty">
                            <td colspan="10">
                                {{ __('common.no')}} {{__('staff.applications') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-center">
                {{ $applications->links() }}
            </div>
        </x-panel>
@endsection
