@props([
    'name'                 => '',
    'link'                 => '',
    'description'          => '',
    'topicCount'           => 0,
    'postCount'            => 0,
    'latestLink'           => '',
    'latestName'           => '',
    'latestDatetime'       => '',
    'latestDatetimeHuman'  => '',
    'latestAuthorUsername' => '',
    'latestAuthorLink'     => '',
    'latestExists'      => false,
])

<article class="subforum-listing">
    <header class="subforum-listing__header">
        <h3 class="subforum-listing__heading">
            <a
                class="subforum-listing__link"
                href="{{ $link }}"
            >
                {{ $name }}
            </a>
        </h3>
        <p class="subforum-listing__description">
            {{ $description }}
        </p>
    </header>
    <figure class="subforum-listing__figure">
        <img
            class="subforum-listing__icon"
            src="{{ url('img/forum.png') }}"
            alt=""
        >
    </figure>
    <dl class="subforum-listing__topic-stats">
        <dt>{{ __('forum.topics') }}</dt>
        <dd>{{ $topicCount }}</dd>
    </dl>
    <dl class="subforum-listing__post-stats">
        <dt>{{ __('forum.posts') }}</dt>
        <dd>{{ $postCount }}</dd>
    </dl>
    <article class="subforum-listing__latest-topic">
        @if ($latestExists)
            <h4 class="subforum-listing__latest-heading">
                <a
                    class="subforum-listing__latest-link"
                    href="{{ $latestLink }}"
                >
                    {{ $latestName }}
                </a>
            </h4>
        @endif
        <time
            class="subforum-listing__latest-datetime"
            datetime="{{ $latestDatetime }}"
        >
            {{ $latestDatetimeHuman }}
        </time>
        @if ($latestExists)
            <address class="subforum-listing__latest-author">
                <a
                    class="subforum-listing__latest-author-link"
                    href="{{ $latestAuthorLink }}"
                >
                    {{ $latestAuthorUsername }}
                </a>
            </address>
        @endif
    </article>
</article>
