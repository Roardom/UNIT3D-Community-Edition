@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.requested') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_requested', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title"
                  class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.requested') }}</span>
        </a>
    </li>
@endsection

@section('content')
    @if (
        !auth()->user()->isAllowed($user,'request','show_requested')
        || ($user->private_profile == 1 && auth()->user()->id != $user->id && !auth()->user()->group->is_modo)
    )
        <x-panel :padded="true" :heading="__('user.private-profile')">
            {{ __('user.not-authorized') }}
        </x-panel>
    @else
        <table class="data-table">
            <thead>
                <th>{{ __('torrent.category') }}</th>
                <th>{{ __('torrent.type') }}</th>
                <th>{{ __('request.request') }}</th>
                <th>{{ __('request.votes') }}</th>
                <th>{{ __('common.comments') }}</th>
                <th>{{ __('request.bounty') }}</th>
                <th>{{ __('request.age') }}</th>
                <th>{{ __('common.status') }}</th>
            </thead>
            <tbody>
                @foreach ($torrentRequests as $torrentRequest)
                    <tr>
                        <td>
                            <i
                                class="{{ $torrentRequest->category->icon }} torrent-icon"
                                title="{{ $torrentRequest->category->name }} {{ __('request.request') }}"
                            ></i>
                        </td>
                        <td>{{ $torrentRequest->type->name }}</td>
                        <td>
                            <a href="{{ route('request', ['id' => $torrentRequest->id]) }}">
                                {{ $torrentRequest->name }}
                            </a>
                        </td>
                        <td>{{ $torrentRequest->votes }}</td>
                        <td>{{ $torrentRequest->comments->count() }}</td>
                        <td>{{ $torrentRequest->bounty }}</td>
                        <td>{{ $torrentRequest->created_at->diffForHumans() }}</td>
                        <td>
                            @if ($torrentRequest->claimed != null && $torrentRequest->filled_hash == null)
                                {{ __('request.claimed') }}
                            @elseif ($torrentRequest->filled_hash != null && $torrentRequest->approved_by == null)
                                {{ __('request.pending') }}
                            @elseif ($torrentRequest->filled_hash == null)
                                {{ __('request.unfilled') }}
                            @else
                                {{ __('request.filled') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $torrentRequests->links() }}
    @endif
@endsection
