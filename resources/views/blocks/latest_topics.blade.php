<x-panel>
    <x-slot name="heading">
        <i class="{{ config('other.font-awesome') }} fa-list-alt"></i>
        {{ __('blocks.latest-topics') }}
    </x-slot>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('forum.forum') }}</th>
                <th>{{ __('forum.topic') }}</th>
                <th>{{ __('forum.author') }}</th>
                <th>{{ __('forum.created') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                @if ($topic->viewable())
                    <tr>
                        <td>
                            <a href="{{ route('forums.show', ['id' => $topic->forum->id]) }}">
                                {{ $topic->forum->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('forum_topic', ['id' => $topic->id]) }}">
                                {{ $topic->name }}
                            </a>
                        </td>
                        <td>{{ $topic->first_post_user_username }}</td>
                        <td>
                            <date
                                datetime="{{ $topic->created_at }}"
                                title="{{ $topic->created_at }}"
                            >
                                {{ $topic->created_at->diffForHumans() }}
                            </date>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <x-slot name="footer">
        <a href="{{ route('forum_latest_topics') }}">
            {{ __('articles.read-more') }}
        </a>
    </x-slot>
</x-panel>
