@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.bots.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.bots') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel :heading="__('staff.bots')">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.position') }}</th>
                    <th>{{ __('common.icon') }}</th>
                    <th>{{ __('common.command') }}</th>
                    <th>{{ __('common.status') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bots as $bot)
                    <tr>
                        <td>{{ $bot->name }}</td>
                        <td>{{ $bot->position }}</td>
                        <td>
                            <img
                                class="chat-bots__icon"
                                src="/vendor/joypixels/png/64/{{ $bot->emoji }}.png"
                                alt="emoji"
                            >
                        </td>
                        <td>{{ $bot->command }}</td>
                        <td>
                            @if(!$bot->is_systembot)
                                @if($bot->active)
                                    <form
                                        role="form"
                                        method="POST"
                                        action="{{ route('staff.bots.disable', ['id' => $bot->id]) }}"
                                    >
                                        @csrf
                                        <button type="submit" class="chat-bots__status-toggle">
                                            <i
                                                title="{{ __('common.disable') }}"
                                                class="{{ config('other.font-awesome') }} fa-bell-on chat-bots__status-toggle-icon"
                                            ></i>
                                        </button>
                                    </form>
                                @else
                                    <form
                                        role="form"
                                        method="POST"
                                        action="{{ route('staff.bots.enable', ['id' => $bot->id]) }}"
                                    >
                                        @csrf
                                        <button type="submit" class="chat-bots__status-toggle">
                                            <i
                                                title="{{ __('common.enable') }}"
                                                class="{{ config('other.font-awesome') }} fa-bell-slash chat-bots__status-toggle-icon"
                                            ></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if ($bot->active)
                                    <i
                                        title="Enabled"
                                        class="{{ config('other.font-awesome') }} fa-bell-on"
                                    ></i>
                                @else
                                    <i
                                        title="Disabled"
                                        class="{{ config('other.font-awesome') }} fa-bell-slash"
                                    ></i>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div class="data-table__actions">
                                <a href="{{ route('staff.bots.edit', ['id' => $bot->id]) }}">
                                    <i
                                        :title="__('common.edit')"
                                        class="{{ config('other.font-awesome') }} fa-pencil"
                                    ></i>
                                </a>
                                <form action="{{ route('staff.bots.destroy', ['id' => $bot->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @if(!$bot->is_protected)
                                        <button type="submit">
                                            <i
                                                :title="__('common.delete')"
                                                class="{{ config('other.font-awesome') }} fa-trash"
                                            ></i>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
