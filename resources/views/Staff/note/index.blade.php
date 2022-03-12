@extends('layout.default')

@section('title')
    <title>{{ __('common.user') }} Notes - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="User Notes - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.notes.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.user-notes') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('common.user') }}</th>
                <th>{{ __('common.staff') }}</th>
                <th>{{ __('common.message') }}</th>
                <th>{{ __('user.created-on') }}</th>
                <th>{{ __('common.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notes as $note)
                <tr>
                    <td>{{ $note->id }}</td>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$note->noteduser->id"
                            :username="$note->noteduser->username"
                            :href="route('users.show', ['username' => $note->noteduser->username])"
                            :icon="$note->noteduser->group->icon"
                            :color="$note->noteduser->group->color"
                            :group="$note->noteduser->group->name"
                        />
                    </td>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :userId="$note->staffuser->id"
                            :username="$note->staffuser->username"
                            :href="route('users.show', ['username' => $note->staffuser->username])"
                            :icon="$note->staffuser->group->icon"
                            :color="$note->staffuser->group->color"
                            :group="$note->staffuser->group->name"
                        />
                    </td>
                    <td>{{ $note->message }}</td>
                    <td>
                        {{ $note->created_at }}
                        ({{ $note->created_at->diffForHumans() }})
                    </td>
                    <td>
                        <form action="{{ route('staff.notes.destroy', ['id' => $note->id]) }}" method="POST">
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
                    <td colspan="6">No notes exist</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div>{{ $notes->links() }}</div>
@endsection
