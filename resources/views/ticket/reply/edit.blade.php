@extends('layout.with-main')

@section('title')
    <title>{{ __('common.edit') }} - {{ $ticket->subject }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('tickets.index') }}" class="breadcrumb__link">
            {{ __('ticket.helpdesk') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('tickets.show', ['ticket' => $ticket]) }}" class="breadcrumb__link">
            {{ $ticket->subject }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.edit') }}
    </li>
@endsection

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">
            {{ __('common.edit') }}:
            {{ $ticket->subject }}
        </h2>
        <div class="panel__body">
            <form
                class="form"
                method="POST"
                action="{{ route('tickets.replies.update', ['ticket' => $ticket, 'ticketReply' => $ticketReply]) }}"
            >
                @csrf
                @method('PATCH')
                @livewire('bbcode-input', ['name' => 'content', 'label' => __('pm.reply'), 'content' => $ticketReply->content])
                <p class="form__group">
                    <input type="hidden" name="anon" value="0" />
                    <input type="checkbox" id="anon" name="anon" class="form__checkbox" />
                    <label for="anon" class="form__label">{{ __('common.anonymous') }}?</label>
                </p>
                <button class="form__button form__button--filled">
                    {{ __('common.submit') }}
                </button>
            </form>
        </div>
    </section>
@endsection
