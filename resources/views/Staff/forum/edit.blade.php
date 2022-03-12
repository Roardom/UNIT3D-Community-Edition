@extends('layout.default')

@section('title')
    <title>{{ __('common.edit') }} Forums - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('common.edit') }} Forums - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('staff.dashboard.index') }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('staff.staff-dashboard') }}</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ route('staff.forums.edit', ['id' => $forum->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ __('common.edit') }} {{ $forum->name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('staff.forums.update', ['id' => $forum->id]) }}">
        @csrf
        <label>
            Title
            <input type="text" name="title" class="form-control" value="{{ $forum->name }}">
        </label>
        <label>
            Description
            <textarea name="description" cols="30" rows="10">{{ $forum->description }}</textarea>
        </label>
        <label>
            Forum Type
            <select name="forum_type" class="form-control">
                @if ($forum->getCategory() == null)
                    <option value="category" selected>Category (Current)</option>
                    <option value="forum">Forum</option>
                @else
                    <option value="category">Category</option>
                    <option value="forum" selected>Forum (Current)</option>
                @endif
            </select>
        </label>
        <label>
            Parent forum
            <select name="parent_id" class="form-control">
                @if ($forum->getCategory() != null)
                    <option value="{{ $forum->parent_id }}" selected>{{ $forum->getCategory()->name }}
                        (Current)
                    </option>
                @endif
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            {{ __('common.position') }}
            <input type="text" name="position" placeholder="The position number" value="{{ $forum->position }}">
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
                            <input
                                type="checkbox"
                                {{ $group->getPermissionsByForum($forum)->show_forum ? 'checked' : '' }}
                                name="permissions[{{ $group->id }}][show_forum]"
                                value="1"
                            >
                        </td>
                        <td>
                            <input
                                type="checkbox"
                                {{ $group->getPermissionsByForum($forum)->read_topic ? 'checked' : '' }}
                                name="permissions[{{ $group->id }}][read_topic]"
                                value="1"
                            >
                        </td>
                        <td>
                            <input
                                type="checkbox"
                                {{ $group->getPermissionsByForum($forum)->start_topic ? 'checked' : '' }}
                                name="permissions[{{ $group->id }}][start_topic]"
                                value="1"
                            >
                        </td>
                        <td>
                            <input
                                type="checkbox"
                                {{ $group->getPermissionsByForum($forum)->reply_topic ? 'checked' : '' }}
                                name="permissions[{{ $group->id }}][reply_topic]"
                                value="1"
                            >
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-default">Save Forum</button>
    </form>
@endsection
