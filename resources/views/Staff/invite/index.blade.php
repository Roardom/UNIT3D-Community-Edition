@extends('layout.default')

@section('title')
    <title>Invites Log - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
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
        <a href="{{ route('staff.invites.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.invites-log') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('user.sender') }}</th>
                <th>{{ __('common.email') }}</th>
                <th>Token</th>
                <th>{{ __('user.created-on') }}</th>
                <th>{{ __('user.expires-on') }}</th>
                <th>{{ __('user.accepted-by') }}</th>
                <th>{{ __('user.accepted-at') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invites as $invite)
                <tr>
                    <td>{{ $invite->id }}</td>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$invite->sender->id"
                            :username="$invite->sender->username"
                            :href="route('users.show', ['username' => $invite->sender->username])"
                            :icon="$invite->sender->group->icon"
                            :color="$invite->sender->group->color"
                            :group="$invite->sender->group->name"
                        />
                    </td>
                    <td>{{ $invite->email }}</td>
                    <td>{{ $invite->code }}</td>
                    <td>{{ $invite->created_at }}</td>
                    <td>{{ $invite->expires_on }}</td>
                    <td>
                        @if ($invite->accepted_by != null && $invite->accepted_by != 1)
                            <x-chip.user
                                :anon="false"
                                :userId="$invite->receiver->id"
                                :username="$invite->receiver->username"
                                :href="route('users.show', ['username' => $invite->receiver->username])"
                                :icon="$invite->receiver->group->icon"
                                :color="$invite->receiver->group->color"
                                :group="$invite->receiver->group->name"
                            />
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $invite->accepted_at ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No invites exist</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>{{ $invites->links() }}</div>
@endsection
