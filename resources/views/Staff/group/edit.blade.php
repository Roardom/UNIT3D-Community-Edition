@extends('layout.default')

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('staff.groups.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.user') }} Groups</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.groups.create', ['group' => $group->name, 'id' => $group->id]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.edit') }} User Group</span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST"
          action="{{ route('staff.groups.update', ['group' => $group->name, 'id' => $group->id]) }}">
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" name="name" value="{{ $group->name }}" />
        </label>
        <label>
            {{ __('common.position') }}
            <input type="text" name="position" value="{{ $group->position }}" />
        </label>
        <label>
            Level
            <input type="text" name="level" value="{{ $group->level }}" />
        </label>
        <label>
            DL Slots
            <input type="text" name="download_slots" value="{{ $group->download_slots }}" />
        </label>
        <label>
            Color
            <input type="text" name="color" value="{{ $group->color }}" />
        </label>
        <label>
            Level
            <input type="text" name="icon" value="{{ $group->icon }}" />
        </label>
        <label>
            Effect
            <input type="text" name="effect" value="{{ $group->effect }}" />
        </label>
        <label>
            <input type="hidden" name="is_internal" value="0">
            <input type="checkbox" name="is_internal" value="1" {{ $group->is_internal ? 'checked' : '' }}>
            Internal
        </label>
        <label>
            <input type="hidden" name="is_modo" value="0">
            <input type="checkbox" name="is_modo" value="1" {{ $group->is_modo ? 'checked' : '' }}>
            Modo
        </label>
        <label>
            <input type="hidden" name="is_admin" value="0">
            <input type="checkbox" name="is_admin" value="1" {{ $group->is_admin ? 'checked' : '' }}>
            Admin
        </label>
        <label>
            <input type="hidden" name="is_owner" value="0">
            <input type="checkbox" name="is_owner" value="1" {{ $group->is_owner ? 'checked' : '' }}>
            Owner
        </label>
        <label>
            <input type="hidden" name="is_trusted" value="0">
            <input type="checkbox" name="is_trusted" value="1" {{ $group->is_trusted ? 'checked' : '' }}>
            Trusted
        </label>
        <label>
            <input type="hidden" name="is_immune" value="0">
            <input type="checkbox" name="is_immune" value="1" {{ $group->is_immune ? 'checked' : '' }}>
            Immune
        </label>
        <label>
            <input type="hidden" name="is_freeleech" value="0">
            <input type="checkbox" name="is_freeleech" value="1" {{ $group->is_freeleech ? 'checked' : '' }}>
            Freeleech
        </label>
        <label>
            <input type="hidden" name="is_double_upload" value="0">
            <input type="checkbox" name="is_double_upload" value="1" {{ $group->is_double_upload ? 'checked' : '' }}>
            Double Upload
        </label>
        <label>
            <input type="hidden" name="is_incognito" value="0">
            <input type="checkbox" name="is_incognito" value="1" {{ $group->is_incognito ? 'checked' : '' }}>
            Incognito
        </label>
        <label>
            <input type="hidden" name="can_upload" value="0">
            <input type="checkbox" name="can_upload" value="1" {{ $group->can_upload ? 'checked' : '' }}>
            Upload
        </label>
        <label>
            <input type="hidden" name="autogroup" value="0">
            <input type="checkbox" name="autogroup" value="1" {{ $group->autogroup ? 'checked' : '' }}>
            Autogroup
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection
