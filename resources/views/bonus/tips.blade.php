@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.tips') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('bonus') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.points') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('bonus_tips') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.tips') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @include('bonus.buttons', ['nav' => 'bon-nav__tips'])
@endsection

@section('content')
    <x-panel :heading="__('bon.tips')">
        <table class="data-table">
            <thead>
            <tr>
                <th>{{ __('bon.sender') }}</th>
                <th>{{ __('bon.receiver') }}</th>
                <th>{{ __('bon.points') }}</th>
                <th>{{ __('bon.date') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bontransactions as $b)
                <tr>
                    <td>
                        <x-chip.user
                            :anon="false"
                            :user-id="$b->senderObj->id"
                            :username="$b->senderObj->username"
                            :href="route('users.show', ['username' => $b->senderObj->username])"
                            :icon="$b->senderObj->group->icon"
                            :color="$b->senderObj->group->color"
                            :group="$b->senderObj->group->name"
                            :effect="$b->senderObj->group->effect"
                        />
                    </td>
                    <td>
                        @if($b->whereNotNull('torrent_id'))
                            @php $torrent = App\Models\Torrent::select(['anon'])->find($b->torrent_id) @endphp
                        @endif
                        <x-chip.user
                            :anon="isset($torrent) && $torrent->anon === 1"
                            :user-id="$b->receiverObj->id"
                            :username="$b->receiverObj->username"
                            :href="route('users.show', ['username' => $b->receiverObj->username])"
                            :icon="$b->receiverObj->group->icon"
                            :color="$b->receiverObj->group->color"
                            :group="$b->receiverObj->group->name"
                            :effect="$b->receiverObj->group->effect"
                        />
                    </td>
                    <td>{{ $b->cost }}</td>
                    <td>{{ $b->date_actioned }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-panel>
    {{ $bontransactions->links() }}
@endsection

@section('sidebar')
    <x-panel :padded="true" :heading="__('bon.your-points')">
        {{ $userbon }}
    </x-panel>
    <x-panel :heading="__('bon.total-tips')">
        <dl class="key-value">
            <dt>{{ __('bon.you-have-received-tips') }}</dt>
            <dd>{{ $tips_received }}</dd>
            <dt>{{ __('bon.you-have-sent-tips') }}</dt>
            <dd>{{ $tips_sent }}</dd>
        </dl>
    </x-panel>
@endsection
