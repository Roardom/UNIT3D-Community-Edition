<div
    class="quick-search"
    x-data="{ showResults: false, search: 'movie' }"
    @click.outside="$wire.set('movie', ''); $wire.set('series', ''); $wire.set('person', ''); showResults = false;"
    @focusin="showResults = true;"
>
    <div class="quick-search__inputs">
        <input
            class="quick-search__input"
            wire:model.debounce.250ms="movie"
            type="text"
            placeholder="Movie"
            autocomplete="off"
            x-show="search == 'movie'"
            x-ref="movieSearch"
            @focusin="$wire.set('series', ''); $wire.set('person', '');"
        >
        <input
            wire:model.debounce.250ms="series"
            class="quick-search__input"
            type="text"
            placeholder="Series"
            autocomplete="off"
            x-show="search == 'tv'"
            x-ref="tvSearch"
            x-cloak
            @focusin="$wire.set('movie', ''); $wire.set('person', '');"
        >
        <input
            wire:model.debounce.250ms="person"
            class="quick-search__input"
            type="text"
            placeholder="Person"
            autocomplete="off"
            x-show="search == 'person'"
            x-ref="personSearch"
            x-cloak
            @focusin="$wire.set('movie', ''); $wire.set('series', '');"
        />
        <div class="quick-search__radios">
            <label
                class="quick-search__radio-label"
                @click="search == 'movie'; $nextTick(() => $refs.movieSearch.focus());"
            >
                <input class="quick-search__radio"  type="radio" name="quick-search" checked>
                <i
                    class="quick-search__radio-icon {{ \config('other.font-awesome') }} fa-camera-movie"
                    title="{{ __('mediahub.movies') }}"
                ></i>
            </label>
            <label
                class="quick-search__radio-label"
                @click="search = 'tv'; $nextTick(() => $refs.tvSearch.focus());"
            >
                <input class="quick-search__radio"  type="radio" name="quick-search">
                <i
                    class="quick-search__radio-icon {{ \config('other.font-awesome') }} fa-tv-retro"
                    title="{{ __('mediahub.shows') }}"
                ></i>
            </label>
            <label
                class="quick-search__radio-label"
                @click="search = 'person'; $nextTick(() => $refs.personSearch.focus());"
            >
                <input class="quick-search__radio" type="radio" name="quick-search">
                <i
                    class="quick-search__radio-icon {{ \config('other.font-awesome') }} fa-user"
                    title="{{ __('mediahub.persons') }}"
                ></i>
            </label>
        </div>
        @if (strlen($movie) > 2  || strlen($series) > 2  || strlen($person) > 2)
            <div class="quick-search__results">
                @forelse ($search_results as $search_result)
                    <article class="quick-search__result">
                        @if (strlen($movie) > 2 )
                            <a
                                class="quick-search__result-link"
                                href="{{ route('torrents.similar', ['category_id' => '1', 'tmdb' => $search_result->id]) }}"
                            >
                                <img
                                    class="quick-search__image"
                                    src="{{ $search_result->poster }}"
                                    alt="{{ __('torrent.poster') }}"
                                />
                                <h2 class="quick-search__result-text">
                                    {{ $search_result->title }}
                                    <time
                                        class="quick-search__result-year"
                                        datetime="{{ $search_result->release_date }}"
                                    >
                                        {{ substr($search_result->release_date, 0, 4) }}
                                    </time>
                                </h2>
                            </a>
                        @elseif (strlen($series) > 2 )
                            <a
                                class="quick-search__result-link"
                                href="{{ route('torrents.similar', ['category_id' => '2', 'tmdb' => $search_result->id]) }}"
                            >
                                <img
                                    class="quick-search__image"
                                    src="{{ $search_result->poster }}"
                                    alt="{{ __('torrent.poster') }}"
                                />
                                <h2 class="quick-search__result-text">
                                    {{ $search_result->name }}
                                    <time
                                        class="quick-search__result-year"
                                        datetime="{{ $search_result->first_air_date }}"
                                    >
                                        {{ substr($search_result->first_air_date, 0, 4) }}
                                    </time>
                                </h2>
                            </a>
                        @elseif (strlen($person) > 2 )
                            <a
                                class="quick-search__result-link"
                                href="{{ route('mediahub.persons.show', ['id' => $search_result->id]) }}"
                            >
                                <img
                                    class="quick-search__image"
                                    src="{{ $search_result->still }}"
                                    alt="{{ __('torrent.poster') }}"
                                />
                                <h2 class="quick-search__result-text">
                                    {{ $search_result->name }}
                                </h2>
                            </a>
                    </article>
                    @endif
                @empty
                    <article class="quick-search__result--empty">
                        <p class="quick-search__result-text">No results found</p>
                    </article>
                @endforelse
            </div>
        @else
            <div x-cloak x-show="showResults" class="quick-search__results">
                <article class="quick-search__result--keep-typing">
                    <p class="quick-search__result-text">Keep typing to get results</p>
                </article>
            </div>
        @endif
    </div>
</div>
