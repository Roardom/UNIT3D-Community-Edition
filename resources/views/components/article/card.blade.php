@props([
    'id' => 1,
    'title' => '',
    'datetime' => '',
    'datetimeHuman' => '',
    'image' => '',
    'content' => '',
])

<article class="article-preview">
    <header class="article-preview__header">
        <h2 class="article-preview__title">
            <a
                class="article-preview__link"
                href="{{ route('articles.show', ['id' => $id]) }}"
            >
                {{ $title }}
            </a>
        </h2>
        <time
            class="article-preview__published-date"
            datetime="{{ $datetime }}"
            title="{{ $datetime }}"
        >
            {{ $datetimeHuman }}
        </time>
        <img
            class="article-preview__image"
            src="{{ url($image) }}"
            alt=""
        >
    </header>
    <p class="article-preview__content">
        @joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($content, 500, '...'), 150))
    </p>
</article>