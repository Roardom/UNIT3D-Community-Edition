@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('bonus') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.points') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @include('bonus.buttons', ['nav' => 'bon-nav__bon'])
@endsection

@section('content')
    <x-panel :heading="__('bon.earnings')" x-data="{ extended: false }">
        <x-slot name="heading">
            {{ __('bon.earnings') }}
            <label style="float: right">
                {{ __('bon.extended-stats') }}:
                <input x-on:click="extended = !extended" type="checkbox" value="1" name="extended" id="extended">
            </label>
        </x-slot>
        @php
            $bonuses = array(
                [
                    'name'        => __('torrent.dying-torrent'),
                    'description' => __('torrent.last-seeder'),
                    'count'       => $dying,
                    'points'      => 2
                ],
                [
                    'name'        => __('torrent.legendary-torrent'),
                    'description' => __('common.older-than').' 12 '.__('common.months'),
                    'count'       => $legendary,
                    'points'      => 1.5
                ],
                [
                    'name'        => __('torrent.old-torrent'),
                    'description' => __('common.older-than').' 6 '.__('common.months'),
                    'count'       => $old,
                    'points'      => 1
                ],
                [
                    'name'        => __('common.huge').' '.__('torrent.torrents'),
                    'description' => __('torrent.torrent').' '.__('torrent.size').' > 100 GiB',
                    'count'       => $huge,
                    'points'      => 0.75
                ],
                [
                    'name'        => __('common.large').' '.__('torrent.torrents'),
                    'description' => '25 GiB ≤ '.__('torrent.torrent').' '.__('torrent.size').' < 100 GiB',
                    'count'       => $large,
                    'points'      => 0.50
                ],
                [
                    'name'        => __('common.everyday').' '.__('torrent.torrents'),
                    'description' => '1 GiB ≤ '.__('torrent.torrent').' '.__('torrent.size').' < 25 GiB',
                    'count'       => $regular,
                    'points'      => 0.25
                ],
                [
                    'name'        => __('torrent.legendary-seeder'),
                    'description' => __('torrent.seedtime').' ≥ 1 '.__('common.year'),
                    'count'       => $legend,
                    'points'      => 2
                ],
                [
                    'name'        => __('torrent.mvp').' '.__('torrent.seeder'),
                    'description' => '6 '.__('common.months').' ≤ '.__('torrent.seedtime').' < 1 '.__('common.year'),
                    'count'       => $mvp,
                    'points'      => 1
                ],
                [
                    'name'        => __('torrent.commited').' '.__('torrent.seeder'),
                    'description' => '3 '.__('common.months').' ≤ '.__('torrent.seedtime').' < 6 '.__('common.months'),
                    'count'       => $committed,
                    'points'      => 0.75
                ],
                [
                    'name'        => __('torrent.team-player').' '.__('torrent.seeder'),
                    'description' => '2 '.__('common.months').' ≤ '.__('torrent.seedtime').' < 3 '.__('common.months'),
                    'count'       => $teamplayer,
                    'points'      => 0.50
                ],
                [
                    'name'        => __('torrent.participant').' '.__('torrent.seeder'),
                    'description' => '1 '.__('common.month').' ≤ '.__('torrent.seedtime').' < 2 '.__('common.months'),
                    'count'       => $participant,
                    'points'      => 0.25
                ],
            );
        @endphp
        <table class="data-table">
            <thead>
                <th>{{ __('common.name') }}</th>
                <th>{{ __('common.description') }}</th>
                <th>{{ __('bon.points') }}</th>
                <th>{{ __('bon.earning') }}</th>
            </thead>
            <tbody>
                @foreach ($bonuses as $bonus)
                    <tr>
                        <td>
                            {{ $bonus['name'] }}
                        </td>
                        <td>
                            {{ \ucfirst(\strtolower($bonus['description'])) }}
                        </td>
                        <td>
                            {{ $bonus['count'] }} x {{ $bonus['points'] }}
                        </td>
                        <td>
                            {{ $bonus['count'] * $bonus['points'] }}
                            {{ __('bon.per-hour') }}<br/>
                            <span x-show="extended">
                                {{ $bonus['count'] * $bonus['points'] * 24 }}
                                {{ __('bon.per-day') }}<br/>
                                {{ $bonus['count'] * $bonus['points'] * 24 * 7 }}
                                {{ __('bon.per-week') }}<br/>
                                {{ $bonus['count'] * $bonus['points'] * 24 * 30 }}
                                {{ __('bon.per-month') }}<br/>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        {{ __('bon.total') }}
                    </td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        {{ $total }} {{ __('bon.per-hour') }}
                        <span x-show="extended">
                            {{ $total * 24 }} {{ __('bon.per-day') }}<br/>
                            {{ $total * 24 * 7 }} {{ __('bon.per-week') }}<br/>
                            {{ $total * 24 * 30 }} {{ __('bon.per-month') }}<br/>
                        </span>
                    </td>
                </tr>
                </tfoot>
        </table>
    </x-panel>
@endsection

@section('sidebar')
    <x-panel :padded="true" :heading="__('bon.your-points')">
        {{ $userbon }}
    </x-panel>
    <x-panel :heading="__('bon.earning')">
        <dl class="key-value">
            <dt>{{ __('bon.per-second') }}</dt>
            <dd>{{ $second }}</dd>
            <dt>{{ __('bon.per-minute') }}</dt>
            <dd>{{ $minute }}</dd>
            <dt>{{ __('bon.per-hour') }}</dt>
            <dd>{{ $total }}</dd>
            <dt>{{ __('bon.per-day') }}</dt>
            <dd>{{ $daily }}</dd>
            <dt>{{ __('bon.per-week') }}</dt>
            <dd>{{ $weekly }}</dd>
            <dt>{{ __('bon.per-month') }}</dt>
            <dd>{{ $monthly }}</dd>
            <dt>{{ __('bon.per-year') }}</dt>
            <dd>{{ $yearly }}</dd>
        </dl>
        <a href="{{ route('user_seeds', ['username' => auth()->user()->username]) }}"
           class="btn btn-sm btn-primary">
            {{ __('bon.review-seeds') }}
        </a>
    </x-panel>
@endsection
