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
        <a href="{{ route('staff.internals.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.add') }} Internal Group</span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.internals.store') }}" enctype="multipart/form-data">
        @csrf
        <label>
            {{ __('common.name') }}
            <input type="text" class="form-control" name="name" required>
        </label>
        <label>
            Icon
            <input type="text" class="form-control" name="icon" value="fa-magic">
        </label>
        <label>
            Effect
            <input type="text" class="form-control" name="effect" value="none">
        </label>
        <button type="submit">{{ __('common.submit') }}</button>
    </form>
@endsection
