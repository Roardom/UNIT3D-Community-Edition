@extends('layout.default')

@section('title')
    <title>{{ $user->username }} {{ __('user.gifts') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('bonus') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.points') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('bonus_gifts') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.gifts') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @include('bonus.buttons', ['nav' => 'bon-nav__gifts'])
@endsection

@section('content')
    <x-panel :heading="__('bon.gifts')">
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
                @foreach($gifttransactions as $b)
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
                            <x-chip.user
                                :anon="false"
                                :user-id="$b->receiverObj->id"
                                :username="$b->receiverObj->username"
                                :href="route('users.show', ['username' => $b->receiverObj->username])"
                                :icon="$b->receiverObj->group->icon"
                                :color="$b->receiverObj->group->color"
                                :group="$b->receiverObj->group->name"
                                :effect="$b->receiverObj->group->effect"
                            />
                        <td>{{ $b->cost }}</td>
                        <td>{{ $b->date_actioned }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
    {{ $gifttransactions->links() }}
@endsection

@section('sidebar')
    <x-panel :padded="true" :heading="__('bon.your-points')">
        {{ $userbon }}
    </x-panel>
    <x-panel :heading="__('bon.total-gifts')">
        <dl class="key-value">
            <dt>{{ __('bon.you-have-received-gifts') }}</dt>
            <dd>{{ $gifts_received }}</dd>
            <dt>{{ __('bon.you-have-sent-gifts') }}</dt>
            <dd>{{ $gifts_sent }}</dd>
        </dl>
    </x-panel>
@endsection
