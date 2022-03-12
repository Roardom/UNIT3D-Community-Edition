@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('bonus') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.points') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('bonus_store') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('bon.bonus') }} {{ __('bon.store') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    @include('bonus.buttons', ['nav' => 'bon-nav__store'])
@endsection

@section('content')
    <x-panel :heading="__('bon.exchange')">
        <table class="data-table">
            <thead>
            <tr>
                <th>{{ __('bon.item') }}</th>
                <th>{{ __('bon.points') }}</th>
                <th>{{ __('bon.exchange') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($uploadOptions as $u => $uu)
                <tr>
                    <td>{{ $uu['description'] }}</td>
                    <td>{{ $uu['cost'] }}</td>
                    <td>
                        <form
                            method="POST"
                            action="{{ route('bonus_exchange', ['id' => $uu['id']]) }}"
                        >
                            @csrf
                            <button type="submit">{{ __('bon.exchange') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @foreach ($personalFreeleech as $p => $pf)
                <tr>
                    <td>{{ $pf['description'] }}</td>
                    <td>{{ $pf['cost'] }}</td>
                    <td>
                        @if ($activefl)
                            <button type="submit" disabled>
                                {{ __('bon.activated') }}!
                            </button>
                        @else
                            <form
                                method="POST"
                                action="{{ route('bonus_exchange', ['id' => $pf['id']]) }}"
                            >
                                @csrf
                                <button type="submit">{{ __('bon.exchange') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

            @foreach ($invite as $i => $in)
                <tr>
                    <td>{{ $in['description'] }}</td>
                    <td>{{ $in['cost'] }}</td>
                    <td>
                        <form
                            method="POST"
                            action="{{ route('bonus_exchange', ['id' => $in['id']]) }}"
                        >
                            @csrf
                            <button type="submit">{{ __('bon.exchange') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection

@section('sidebar')
    <x-panel :padded="true" :heading="__('bon.your-points')">
        {{ $userbon }}
    </x-panel>
    <x-panel :padded="true" :heading="__('bon.no-refund')">
        <strong>{{ __('bon.exchange-warning') }}</strong>
    </x-panel>
@endsection
