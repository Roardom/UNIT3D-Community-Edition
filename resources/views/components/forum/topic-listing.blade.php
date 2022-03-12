@props([
    'name'                     => '',
    'link'                     => '',
    'authorUsername'           => '',
    'authorLink'               => '',
    'postCount'                => 0,
    'viewCount'                => 0,
    'isPinned'                 => false,
    'isClosed'                 => false,
    'isApproved'               => false,
    'isDenied'                 => false,
    'isSolved'                 => false,
    'isInvalid'                => false,
    'isBug'                    => false,
    'isSuggestion'             => false,
    'isImplemented'            => false,
    'latestPostAuthorUsername' => '',
    'latestPostAuthorLink'     => '',
    'latestPostDatetime'       => '',
    'latestPostDatetimeHuman'  => '',
    'forumName'                => '',
])

@php
    $tags = array(
        ['visible' => $isClosed,      'name' => __('forum.closed')     ],
        ['visible' => $isApproved,    'name' => __('forum.approved')   ],
        ['visible' => $isDenied,      'name' => __('forum.denied')     ],
        ['visible' => $isSolved,      'name' => __('forum.solved')     ],
        ['visible' => $isInvalid,     'name' => __('forum.invalid')    ],
        ['visible' => $isBug,         'name' => __('forum.bug')        ],
        ['visible' => $isSuggestion,  'name' => __('forum.suggestion') ],
        ['visible' => $isImplemented, 'name' => __('forum.implemented')],
    )
@endphp

<article class="topic-listing">
    <header class="topic-listing__header">
        <h2 class="topic-listing__heading">
            <a
                class="topic-listing__link"
                href="{{ $link }}"
            >
                {{ $name }}
            </a>
            @foreach($tags as $tag)
                @if ($tag['visible'])
                    <span class="topic-listing__tag">
                    {{ $tag['name'] }}
                </span>
                @endif
            @endforeach
        </h2>
        <address class="topic-listing__author">
            <a href="{{ $authorLink }}">
                {{ $authorUsername }}
            </a>
        </address>
    </header>
    <figure class="topic-listing__figure">
        @if ($isPinned)
            <span class="topic-listing__icon">
                <i class="{{ config('other.font-awesome') }} fa-thumbtack fa-2x"></i>
            </span>
        @else
            <img
                class="topic-listing__icon"
                src="{{ url('img/f_icon_read.png') }}"
                alt="read"
            >
        @endif
        @if ($forumName)
            <figcaption class="topic-listing__forum">
                {{ $forumName }}
            </figcaption>
        @endif
    </figure>
    <dl class="topic-listing__post-stats">
        <dt>{{ __('forum.replies') }}</dt>
        <dd>{{ $postCount}}</dd>
    </dl>
    <dl class="topic-listing__view-stats">
        <dt>{{ __('forum.views') }}</dt>
        <dd>{{ $viewCount }}</dd>
    </dl>
    <article class="topic-listing__latest-post">
        <address class="topic-listing__latest-author">
            <a
                class="topic-listing__latest-author-link"
                href="{{ $latestPostAuthorLink }}"
            >
                {{ $latestPostAuthorUsername }}
            </a>
        </address>
        <time
            class="topic-listing__latest-datetime"
            datetime="{{ $latestPostDatetime }} ?? ''"
        >
            {{ $latestPostDatetimeHuman }}
        </time>
    </article>
{{--</article>--}}
