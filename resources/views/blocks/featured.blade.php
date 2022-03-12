<x-panel>
    <x-slot name="heading">
        <i class="{{ config('other.font-awesome') }} fa-star"></i>
            {{ __('blocks.featured-torrents') }}
        <span id="dots" class="dots"></span>
    </x-slot>
    <x-carousel class="block-featured__carousel" :carouselId="'featured'">
        @php $meta = null @endphp
        @foreach ($featured as $feature)
            @if ($feature->torrent->category->tv_meta)
                @if ($feature->torrent->tmdb || $feature->torrent->tmdb != 0)
                    @php $meta = App\Models\Tv::with('genres', 'networks', 'seasons')->where('id', '=', $feature->torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($feature->torrent->category->movie_meta)
                @if ($feature->torrent->tmdb || $feature->torrent->tmdb != 0)
                    @php $meta = App\Models\Movie::with('genres', 'cast', 'companies', 'collection')->where('id', '=', $feature->torrent->tmdb)->first() @endphp
                @endif
            @endif
            @if ($feature->torrent->category->game_meta)
                @php $meta = MarcReichel\IGDBLaravel\Models\Game::with(['artworks' => ['url', 'image_id'], 'genres' => ['name']])->find((int) $feature->torrent->igdb) @endphp
            @endif
            <x-carousel.slide
                class="block-featured__slide"
            >
                <x-torrent.card
                    :name="$feature->torrent->name"
                    :href="route('torrent', ['id' => $feature->torrent->id])"
                    :genres="$meta->genres"
                    :plot="Str::limit(strip_tags(isset($meta) ? ($meta->overview ?: ($meta->summary ?: '')) : ''), 350, '...')"
                    :poster="$meta->poster"
                    :size="$feature->torrent->getSize()"
                    :released="$feature->torrent->created_at->diffForHumans()"
                    :seeds="$feature->torrent->seeders"
                    :leeches="$feature->torrent->leechers"
                    :completed="$feature->torrent->times_completed"
                    :category="$feature->torrent->category->name"
                    :type="$feature->torrent->type->name"
                    :resolution="$feature->torrent->resolution->name"
                    :uploaderId="$feature->torrent->user->id"
                    :uploaderName="$feature->torrent->user->username"
                    :uploaderIcon="$feature->torrent->user->group->icon"
                    :uploaderColor="$feature->torrent->user->group->color"
                    :uploaderGroup="$feature->torrent->user->group->name"
                    :uploaderEffect="$feature->torrent->user->group->effect"
                    :uploader="$feature->torrent->user"
                    :voteAverage="$meta->vote_average"
                    :voteCount="$meta->vote_count"
                    :anon="$feature->torrent->anon"
                />
                <footer class="block-featured__feature-details">
                    <p class="block-featured__featured-until">
                        @lang('blocks.featured-until'):<br>
                        <date datetime="{{ $feature->created_at->addDay(7) }}">
                            {{ $feature->created_at->addDay(7)->toFormattedDateString() }}
                            ({{ $feature->created_at->addDay(7)->diffForHumans() }}!)
                        </date>
                    </p>
                    <p class="block-featured__featured-by">
                        @lang('blocks.featured-by'): {{ $feature->user->username }}!
                    </p>
                </footer>
            </x-carousel.slide>
        @endforeach
    </x-carousel>
</x-panel>
<style>
    .block-featured__carousel {
        gap: 1rem;
        padding: 1rem;
    }

    .block-featured__slide {
        flex: 1 0 40%;
    }

    .block-featured__feature-details {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
    }

    .block-featured__featured-until,
    .block-featured__featured-by {
        text-align: center;
        font-size: 0.8rem;
    }
</style>