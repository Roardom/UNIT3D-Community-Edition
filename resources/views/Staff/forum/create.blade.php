@extends('layout.default')

@section('title')
    <title>Add Forums - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Add Forums - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.forums.create') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">Add Forum</span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.forums.store') }}">
        @csrf
        <label>
            Forum Type
            <select name="forum_type">
                <option value="category">Category</option>
                <option value="forum">Forum</option>
            </select>
        </label>
        <label>
            Title
            <input type="text" name="title">
        </label>
        <label>
            Description
            <textarea name="description" cols="30" rows="10"></textarea>
        </label>
        <label>
            Parent forum
            <select name="parent_id">
                <option value="0">New Category</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">New Forum In {{ $c->name }} Category</option>
                @endforeach
            </select>
        </label>
        <label>
            {{ __('common.position') }}
            <input type="text" name="position" placeholder="The position number">
        </label>

        <h3>Permissions</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Groups</th>
                    <th>View the forum</th>
                    <th>Read topics</th>
                    <th>Start new topic</th>
                    <th>Reply to topics</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>
                        <input type="checkbox" name="permissions[{{ $group->id }}][show_forum]" value="1" checked>
                    </td>
                    <td>
                        <input type="checkbox" name="permissions[{{ $group->id }}][read_topic]" value="1" checked>
                    </td>
                    <td>
                        <input type="checkbox" name="permissions[{{ $group->id }}][start_topic]" value="1" checked>
                    </td>
                    <td>
                        <input type="checkbox" name="permissions[{{ $group->id }}][reply_topic]" value="1" checked>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="submit">Save Forum</button>
    </form>
@endsection
