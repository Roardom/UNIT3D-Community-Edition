@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.rooms.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.chat-rooms') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel>
        <x-slot name="heading">
            {{ __('common.chat-rooms') }}
            <button data-toggle="modal" data-target="#addChatroom">
                <i class="{{ config('other.font-awesome') }} fa-plus"></i>
            </button>
        </x-slot>
        <div id="addChatroom" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog{{ modal_style() }}">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center;">
                        <h3>{{ __('common.add') }} {{ __('common.chat-room') }}</h3>
                    </div>
                    <form role="form" method="POST" action="{{ route('staff.rooms.store') }}">
                        @csrf
                        <div class="modal-body" style="text-align: center;">
                            <h4>Please enter the name of the chatroom you would like to create.</h4>
                            <label for="chatroom_name"> {{ __('common.name') }}:</label> <label for="name"></label><input
                                    style="margin:0 auto; width:300px;" type="text" class="form-control" name="name"
                                    id="name"
                                    placeholder="Enter {{ __('common.name') }} Here..." required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-md btn-primary" data-dismiss="modal">{{ __('common.cancel') }}</button>
                            <input class="btn btn-md btn-success" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('common.name') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($chatrooms as $chatroom)
                <tr>
                    <td>{{ $chatroom->id }}</td>
                    <td>{{ $chatroom->name }}</td>
                    <td>
                        <div class="data-table__actions">
                            <button data-toggle="modal" data-target="#editChatroom-{{ $chatroom->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                            </button>
                            <button data-toggle="modal" data-target="#deleteChatroom-{{ $chatroom->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                            </button>
                        </div>
                        @include('Staff.chat.room.chatroom_modals', ['chatroom' => $chatroom])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-panel>
@endsection
