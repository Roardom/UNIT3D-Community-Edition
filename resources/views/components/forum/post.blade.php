@props([
    'id' => '',
    'topicId' => '',
    'topicName' => '',
    'page' => -1,
    'datetime' => '',
    'datetimeHuman' => '',
    'authorId' => '',
    'authorUsername' => '',
    'authorAvatar' => '',
    'authorLink' => '',
    'authorIcon' => '',
    'authorColor' => '',
    'authorGroup' => '',
    'authorEffect' => '',
    'isAuthorOnline' => '',
    'authorPmLink' => '',
    'authorTitle' => '',
    'authorJoinDatetime' => '',
    'authorJoinDatetimeHuman' => '',
    'authorTopicsCount' => 0,
    'authorPostsCount' => 0,
    'authorSignature' => '',
    'tipCost' => 0,
    'isTopicOpen' => false,
    'contentBbcode' => '',
])

<article class="post" id="post-{{ $id }}">
    <header class="post__header">
        <time
            class="post__datetime"
            datetime="{{ $datetime }}"
            title="{{ $datetime }}"
        >
            {{ $datetimeHuman }}
        </time>
        <span class="post__topic">
            {{ __('forum.in') }}
            <a href="{{ route('forum_topic', ['id' => $topicId]) }}">{{ $topicName }}</a>
        </span>
        @if($tipCost > 0)
            <dl class="post__tip-stats">
                <dt>{{ __('torrent.bon-tipped') }}</dt>
                <dd>{{ $tipCost }}</dd>
            </dl>
        @endif
        <ul class="post__toolbar">
            <li class="post__toolbar-item">
                <form
                    class="post__tip"
                    role="form"
                    method="POST"
                    action="{{ route('tip_poster') }}"
                >
                    @csrf
                    <input type="hidden" name="recipient" value="{{ $authorId }}">
                    <input type="hidden" name="post" value="{{ $id }}">
                    <input
                        class="post__tip-input"
                        type="number"
                        name="tip"
                        value="0"
                        placeholder="0"
                        list="quick-tip-values"
                    >
                    <button class="post__tip-button" type="submit">
                        {{ __('forum.tip-this-post') }}
                    </button>
                    <datalist id="quick-tip-values">
                        <option value="10">
                        <option value="20">
                        <option value="50">
                        <option value="100">
                        <option value="200">
                        <option value="500">
                        <option value="1000">
                    </datalist>
                </form>
            </li>
            <li class="post__toolbar-item">
                @livewire('like-button', ['post' => $id])
            </li>
            <li class="post__toolbar-item">
                @livewire('dislike-button', ['post' => $id])
            </li>
            <li class="post__toolbar-item">
                <a
                    class="post__permalink"
                    href="{{ route('forum_topic', ['id' => $topicId]) }}?page={{ $page }}#post-{{ $id }}"
                    title="{{ __('forum.permalink') }}"
                >
                    <i class="{{ \config('other.font-awesome') }} fa-link"></i>
                </a>
            </li>
            @if ($isTopicOpen)
                <li class="post__toolbar-item">
                    <button
                        class="post__quote"
                        title="{{ __('forum.quote') }}"
                        x-on:click="$('#topic-response').wysibb().insertAtCursor('[quote={{ '@'.$authorUsername }}]{{ $contentBbcode }}[/quote]', true);"
                    >
                        <i class="{{ \config('other.font-awesome') }} fa-quote-left"></i>
                    </button>
                </li>
            @endif
            @if (auth()->user()->group->is_modo || $authorId === auth()->user()->id)
                <li class="post__toolbar-item">
                    <a
                        class="post__edit"
                        href="{{ route('forum_post_edit_form', ['id' => $topicId, 'postId' => $id]) }}"
                        title="{{ __('common.edit') }}"
                    >
                        <i class="{{ \config('other.font-awesome') }} fa-pencil"></i>
                    </a>
                </li>
            @endif
            @if (auth()->user()->group->is_modo || ($authorId === auth()->user()->id && $isTopicOpen))
                <li class="post__toolbar-item">
                    <form
                        class="post__delete"
                        role="form"
                        method="POST"
                        action="{{ route('forum_post_delete', ['id' => $topicId, 'postId' => $id]) }}"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            class="post__delete-button"
                            type="submit"
                            title="{{ __('common.delete') }}"
                        >
                            <i class="{{ \config('other.font-awesome') }} fa-trash"></i>
                        </button>
                    </form>
                </li>
            @endif
        </ul>
    </header>
    <aside class="post__aside">
        <figure class="post__figure">
            <img
                class="post__avatar"
                src="{{ $authorAvatar }}"
                alt="{{ $authorUsername }}"
            >
        </figure>
        <x-chip.user
            class="post__author"
            :anon="false"
            :userId="$authorId"
            :username="$authorUsername"
            :href="route('users.show', ['username' => $authorUsername])"
            :icon="$authorIcon"
            :color="$authorColor"
            :group="$authorGroup"
            :effect="$authorEffect"
        >
            <x-slot name="appended-icons">
                @if ($isAuthorOnline)
                    <i class="{{ config('other.font-awesome') }} fa-circle text-green" title="Online"></i>
                @else
                    <i class="{{ config('other.font-awesome') }} fa-circle text-red" title="Offline"></i>
                @endif
                <a href="{{ route('create', ['receiver_id' => $authorId, 'username' => $authorUsername]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-envelope text-info"></i>
                </a>
            </x-slot>
        </x-chip.user>
        @if ($authorTitle)
            <p class="post__author-title">
                {{ $authorTitle }}
            </p>
        @endif
        <dl class="post__author-join">
            <dt>Joined</dt>
            <dd>
                <date
                    class="post__author-join-datetime"
                    datetime="{{ $authorJoinDatetime }}"
                    title="{{ $authorJoinDatetime }}"
                >
                    {{ $authorJoinDatetimeHuman }}
                </date>
            </dd>
        </dl>
        @if($authorTopicsCount)
            <dl class="post__author-topics">
                <dt>
                    <a href="{{ route('user_topics', ['username' => $authorUsername]) }}">
                    {{ __('forum.topics') }}
                    </a>
                </dt>
                <dd>{{ $authorTopicsCount }}</dd>
            </dl>
        @endif
        @if($authorPostsCount)
            <dl class="post__author-posts">
                <dt>
                    <a href="{{ route('user_posts', ['username' => $authorUsername]) }}">
                        {{ __('forum.posts') }}
                    </a>
                </dt>
                <dd>{{ $authorPostsCount }}</dd>
            </dl>
        @endif
    </aside>
    <p
        class="post__content"
        data-bbcode="{{ $contentBbcode }}"
    >
        {{ $slot }}
    </p>
    @if ($authorSignature)
        <footer class="post__footer" x-init>
            <p class="post__signature">
                {!! $authorSignature !!}
            </p>
        </footer>
    @endif
</article>