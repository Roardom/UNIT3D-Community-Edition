@extends('layout.default')

@section('title')
    <title>Polls - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.polls.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('poll.polls') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('poll.poll') }}
            <a href="{{ route('staff.polls.create') }}">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </a>
        </x-slot>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('poll.title') }}</th>
                    <th>{{ __('common.date') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polls as $poll)
                    <tr>
                        <td>
                            <a href="{{ route('staff.polls.show', ['id' => $poll->id]) }}">
                                {{ $poll->title }}
                            </a>
                        </td>
                        <td>{{ date('d M Y', $poll->created_at->getTimestamp()) }}</td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.polls.edit', ['id' => $poll->id]) }}">
                                    {{ __('common.edit') }}
                                </a>
                                <form action="{{ route('staff.polls.destroy', ['id' => $poll->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ __('common.delete') }}</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
