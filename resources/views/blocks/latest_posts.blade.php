<x-panel>
    <x-slot name="heading">
        <i class="{{ config('other.font-awesome') }} fa-comments"></i>
        {{ __('blocks.latest-posts') }}
    </x-slot>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('forum.post') }}</th>
                <th>{{ __('forum.topic') }}</th>
                <th>{{ __('forum.author') }}</th>
                <th>{{ __('forum.created') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                @if ($post->topic->viewable())
                    <tr>
                        <td>
                            <a href="{{ route('forum_topic', ['id' => $post->topic->id]) }}?page={{ $post->getPageNumber() }}#post-{{ $post->id }}">
                                {{ preg_replace('#\[[^\]]+\]#', '', Str::limit(htmlspecialchars_decode($post->content) ,75, '...')) }}
                            </a>
                        </td>
                        <td>{{ $post->topic->name }}</td>
                        <td>{{ $post->user->username }}</td>
                        <td>{{ $post->updated_at->diffForHumans() }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <x-slot name="footer">
        <a href="{{ route('forum_latest_posts') }}">
            {{ __('articles.read-more') }}
        </a>
    </x-slot>
</x-panel>
