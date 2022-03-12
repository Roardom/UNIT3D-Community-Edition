@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.internals.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Internals</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.internals.edit', ['name' => $internal->name, 'id' => $internal->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.edit') }} {{ $internal->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <form
        method="POST"
        action="{{ route('staff.internals.update', ['name' => $internal->name, 'id' => $internal->id]) }}"
    >
        @csrf
        <label>
            Name
            <input type="text" name="name" value="{{ $internal->name }}" />
        </label>
        <label>
            Icon
            <input type="text" name="icon" value="{{ $internal->icon }}" />
        </label>
        <label>
            Effect
            <input type="text" name="effect" value="{{ $internal->effect }}" />
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection