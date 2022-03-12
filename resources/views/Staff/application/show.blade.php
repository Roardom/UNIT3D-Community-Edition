@extends('layout.default')

@section('title')
    <title>Application - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Application - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.applications.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.applications') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.applications.show', ['id' => $application->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.applications') }}</span>
        </a>
    </li>
@endsection

@section('content')
    <x-panel heading="{{ __('auth.application') }} {{ $application->id }}">
        <dl class="key-value">
            <dt>{{ __('common.email') }}</dt>
            <dd>{{ $application->email }}</dd>
            <dt>{{ __('staff.application-type') }}</dt>
            <dd>{{ $application->type }}</dd>
            <dt>{{ __('common.created_at') }}</dt>
            <dd>
                {{ $application->created_at->toDayDateTimeString() }}
                ({{ $application->created_at->diffForHumans() }})
            </dd>
            <dt>{{ __('gallery.images') }}</dt>
            <dd>
                @foreach($application->imageProofs as $img_proof)
                    <a href="{{ $img_proof->image }}" target="_blank">
                        <button type="button">
                            {{ __('staff.application-image-proofs') }} {{ $loop->iteration }}
                        </button>
                    </a>
                @endforeach
            </dd>
            <dt>{{ __('user.profile') }} {{ __('staff.links') }}</dt>
            <dd>
                <ul>
                    @foreach($application->urlProofs as $url_proof)
                        <li>
                            <a href="{{ $url_proof->url }}" target="_blank">
                                {{ __('user.profile') }} {{ __('staff.links') }} {{ $loop->iteration }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </dd>
            <dt>{{ __('staff.application-referrer') }}</dt>
            <dd>{{ $application->referrer }}</dd>
            <dt>{{ __('common.status') }}</dt>
            <dd>
                @if ($application->status == 0)
                    <span class="application--pending">{{ __('request.pending') }}</span>
                @elseif ($application->status == 1)
                    <span class="application--approved">{{ __('request.approve') }}</span>
                @else
                    <span class="application--rejected">{{ __('request.reject') }}</span>
                @endif
            </dd>
            @if($application->status != 0)
                <dt>{{ __('common.moderated-by') }}</dt>
                <dd>{{ $application->moderated->username }}</dd>
            @else
                <dt>{{ __('common.action') }}</dt>
                <dd>
                    <button type="button" data-toggle="modal" data-target="#approve-application">
                        <i class="{{ config('other.font-awesome') }} fa-check"></i>
                        {{ __('request.approve') }}
                    </button>
                    <div id="approve-application" class="modal fade" role="dialog">
                        <form
                            method="POST"
                            action="{{ route('staff.applications.approve', ['id' => $application->id]) }}"
                        >
                            @csrf
                            <div class="modal-dialog{{ modal_style() }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">
                                            {{ __('request.approve') }}
                                            {{ __('common.this') }}
                                            {{ __('staff.application') }}
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <input
                                            id="email"
                                            name="email"
                                            type="hidden"
                                            value="{{ $application->email }}"
                                        >
                                        <label for="message">{{ __('common.message') }}</label>
                                        <label for="approve">
                                            <textarea rows="5" cols="50" name="approve" id="approve">
                                                Application Approved!
                                            </textarea>
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit">
                                            <i class="{{ config('other.font-awesome') }} fa-check"></i>
                                            {{ __('request.approve') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" data-toggle="modal" data-target="#deny-application">
                        <i class="{{ config('other.font-awesome') }} fa-times"></i>
                        {{ __('request.reject') }}
                    </button>
                    <div id="deny-application" class="modal fade" role="dialog">
                        <form
                            method="POST"
                            action="{{ route('staff.applications.reject', ['id' => $application->id]) }}"
                        >
                            @csrf
                            <div class="modal-dialog{{ modal_style() }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">
                                            {{ __('request.reject') }}
                                            {{ __('common.this') }}
                                            {{ __('staff.application') }}
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <input
                                            id="email"
                                            name="email"
                                            type="hidden"
                                            value="{{ $application->email }}"
                                        >
                                        <label for="message">{{ __('common.message') }}</label>
                                        <label for="deny">
                                            <textarea rows="5" cols="50" name="deny" id="deny">
                                                Insufficient Proofs.
                                            </textarea>
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" type="submit">
                                            <i class="{{ config('other.font-awesome') }} fa-times"></i>
                                            {{ __('request.reject') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </dd>
            @endif
        </dl>
    </x-panel>
@endsection
