@props([
    'name'           => '',
    'href'           => '#',
    'genres'         => [],
    'plot'           => '',
    'poster'         => '',
    'size'           => '',
    'released'       => '',
    'seeds'          => '',
    'leeches'        => '',
    'completed'      => '',
    'category'       => '',
    'type'           => '',
    'resolution'     => '',
    'uploaderId'     => null,
    'uploaderName'   => '',
    'uploaderIcon'   => '',
    'uploaderColor'  => 'inherit',
    'uploaderGroup'  => '',
    'uploaderEffect' => '',
    'voteAverage'    => '',
    'voteCount'      => '',
    'anon'           => false,
])

<article class="torrent-card">
    <header class="torrent-card__header">
        <div class="torrent-card__left-header">
            <span class="torrent-card__category">{{ $category }}</span>
            <span class="torrent-card__meta-seperator"> • </span>
            <span class="torrent-card__resolution">{{ $resolution }}</span>
            <span class="torrent-card__meta-seperator"> </span>
            <span class="torrent-card__type">{{ $type }}</span>
            <span class="torrent-card__meta-seperator"> • </span>
            <span class="torrent-card__size">{{ $size }}</span>
        </div>
        <div class="torrent-card__right-header">
            <span class="torrent-card__seeds">
                <i class="fas fa-arrow-up"></i>
                {{ $seeds }}
            </span>
            <span class="torrent-card__meta-seperator"> • </span>
            <span class="torrent-card__leeches">
                <i class="fas fa-arrow-down"></i>
                {{ $leeches }}
            </span>
            <span class="torrent-card__meta-seperator"> • </span>
            <span class="torrent-card__completed">
                <i class="fas fa-check"></i>
                {{ $completed }}
            </span>
        </div>
    </header>
    <aside class="torrent-card__aside">
        <figure class="torrent-card__figure">
            <img class="torrent-card__image" src="{{ $poster }}" alt="{{ $name }}"/>
        </figure>
    </aside>
    <div class="torrent-card__body">
        <h2 class="torrent-card__title">
            <a class="torrent-card__link" href="{{ $href }}">{{ $name }}</a>
        </h2>
        <div class="torrent-card__genres">
            @foreach($genres as $genre)
                <a class="torrent-card__genre" href="{{ $genre->id }}">
                    {{ $genre->name }}
                </a>
                @if (! $loop->last)
                    <span class="torrent-card__meta-seperator"> • </span>
                @endif
            @endforeach
        </div>
        <p class="torrent-card__plot">
            {{ $plot }}
        </p>
    </div>
    <footer class="torrent-card__footer">
        <div class="torrent-card__left-footer">
            <address class="torrent-card__uploader">
                <x-chip.user
                    :anon="$anon"
                    :user-id="$uploaderId"
                    :username="$uploaderName"
                    :href="route('users.show', ['username' => $uploaderName])"
                    :icon="$uploaderIcon"
                    :color="$uploaderColor"
                    :group="$uploaderName"
                    :effect="$uploaderEffect"
                />
            </address>
        </div>
        <div class="torrent-card__right-footer">
            <date>{{ $released }}</date>
            <span class="torrent-card__meta-seperator"> • </span>
            <span
                class="torrent-card__rating"
                title="{{ $voteAverage }}/10 ({{ $voteCount }} {{ __('torrent.votes') }})"
            >
                <i class="{{ \config('other.font-awesome') }} fa-star"></i>
                {{ $voteAverage }}
            </span>
        </div>
    </footer>
</article>

<style>
    .torrent-card {
        height: 320px;
        min-width: 320px;
        width: 100%;
        --torrent-card-bg: var(--panel-bg);
        --torrent-card-fg: var(--panel-fg);
        --torrent-card-border: var(--panel-border);
        --torrent-card-head-bg: var(--panel-head-bg);
        --torrent-card-head-fg: var(--panel-head-fg);
        --torrent-card-link-fg: var(--panel-head-fg);
        --torrent-card-genre-fg: var(--panel-head-fg);
        border: var(--torrent-card-border);
        background-color: var(--panel-bg);
        box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.20);
        border-radius: 4px;
        contain: content;
        font-family: var(--font);
        display: grid;
        grid-template-rows: 40px 240px 40px;
        grid-template-areas: "header header" "poster body" "footer footer";
    }

    .torrent-card__header {
        grid-area: header;
    }
    .torrent-card__footer {
        grid-area: footer;
    }

    .torrent-card__header,
    .torrent-card__footer {
        /*width: 100%;*/
        /*height: 40px;*/
        display: flex;
        justify-content: space-between;
        padding: 10px;
        font-size: 0.75rem;
        color: var(--torrent-card-head-fg);
        font-family: var(--font);
        background-color: var(--torrent-card-head-bg);
        margin: 0;
        overflow: hidden;
        white-space: nowrap;
    }

    .torrent-card__body {
        grid-area: body;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 0.75rem;
        color: var(--panel-fg);
    }

    .torrent-card__aside {
        grid-area: poster;
    }

    .torrent-card__figure {
        height: 240px;
    }

    .torrent-card__image {
        max-height: 100%;
    }

    .torrent-card__title {
        margin: 0;
        font-size: 0.9rem;
    }

    .torrent-card__link {
        display: inline-block;
        font-size: 0.9rem;
        line-height: 1.5;
        font-weight: bold;
        color: var(--torrent-card-link-fg);
    }

    .torrent-card__genre {
        color: var(--torrent-card-genre-fg);
        letter-spacing: 2px;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .torrent-card__plot {
        overflow-y: auto;
        font-size: 0.8rem;
        line-height: 1.5;
    }

    .torrent-card__uploader {
        margin: 0;
        padding: 0;
        display: inline;
    }
</style>