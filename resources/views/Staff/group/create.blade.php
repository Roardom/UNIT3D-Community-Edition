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
        <a href="{{ route('staff.groups.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Add User Group</span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.groups.store') }}">
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" name="name" value="" placeholder="{{ __('common.name') }}" />
        </label>
        <label>
            {{ __('common.position') }}
            <input type="number" name="position" value="" placeholder="{{ __('common.position') }}" />
        </label>
        <label>
            Level
            <input type="number" name="level" value="" placeholder="Level" />
        </label>
        <label>
            Color
            <input type="text" name="color" value="" placeholder="HEX Color ID" />
        </label>
        <label>
            Icon
            <input type="text" name="icon" value="" placeholder="FontAwesome Icon" />
        </label>
        <label>
            Effect
            <input type="text" name="effect" value="none" placeholder="GIF Effect" />
        </label>
        <label>
            <input type="hidden" name="is_internal" value="0">
            <input type="checkbox" name="is_internal" value="1">
            Internal
        </label>
        <label>
            <input type="hidden" name="is_modo" value="0">
            <input type="checkbox" name="is_modo" value="1">
            Modo
        </label>
        <label>
            <input type="hidden" name="is_admin" value="0">
            <input type="checkbox" name="is_admin" value="1">
            Admin
        </label>
        <label>
            <input type="hidden" name="is_owner" value="0">
            <input type="checkbox" name="is_owner" value="1">
            owner
        </label>
        <label>
            <input type="hidden" name="is_trusted" value="0">
            <input type="checkbox" name="is_trusted" value="1">
            Trusted
        </label>
        <label>
            <input type="hidden" name="is_immune" value="0">
            <input type="checkbox" name="is_immune" value="1">
            Immune
        </label>
        <label>
            <input type="hidden" name="is_freeleech" value="0">
            <input type="checkbox" name="is_freeleech" value="1">
            Freeleech
        </label>
        <label>
            <input type="hidden" name="is_double_upload" value="0">
            <input type="checkbox" name="is_double_upload" value="1">
            Double Upload
        </label>
        <label>
            <input type="hidden" name="is_incognito" value="0">
            <input type="checkbox" name="is_incognito" value="1">
            Incognito
        </label>
        <label>
            <input type="hidden" name="can_upload" value="0">
            <input type="checkbox" name="can_upload" value="1">
            Upload
        </label>
        <label>
            <input type="hidden" name="autogroup" value="0">
            <input type="checkbox" name="autogroup" value="1">
            Autogroup
        </label>
        <button type="submit">{{ __('common.add') }}</button>
    </form>
@endsection
