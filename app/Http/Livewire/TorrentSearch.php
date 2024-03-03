<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.tx
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Http\Livewire;

use App\Helpers\TorrentTools;
use App\Models\Category;
use App\Models\Movie;
use App\Models\Torrent;
use App\Models\Tv;
use App\Models\User;
use App\Traits\CastLivewireProperties;
use App\Traits\LivewireSort;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Meilisearch\Endpoints\Indexes;

class TorrentSearch extends Component
{
    use CastLivewireProperties;
    use LivewireSort;
    use WithPagination;

    #TODO: Update URL attributes once Livewire 3 fixes upstream bug. See: https://github.com/livewire/livewire/discussions/7746

    #[Url(history: true)]
    public string $name = '';

    #[Url(history: true)]
    public string $description = '';

    #[Url(history: true)]
    public string $mediainfo = '';

    #[Url(history: true)]
    #[Validate('sometimes|exists:users,username|not_regex:/[()"\']/i')]
    public string $uploader = '';

    #[Url(history: true)]
    #[Validate('sometimes|not_regex:/[()"\']/i')]
    public string $keywords = '';

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $startYear = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $endYear = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $minSize = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public int $minSizeMultiplier = 1;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $maxSize = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public int $maxSizeMultiplier = 1;

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate(['categories.*' => 'sometimes|exists:categories,id'])]
    public array $categories = [];

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate(['types.*' => 'sometimes|exists:types,id'])]
    public array $types = [];

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate(['resolutions.*' => 'sometimes|exists:resolutions,id'])]
    public array $resolutions = [];

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate(['genres.*' => 'sometimes|exists:genres,id'])]
    public array $genres = [];

    /**
     * @var string[]
     */
    #[Validate(['regions.*' => 'sometimes|exists:regions,id'])]
    #[Url(history: true)]
    public array $regions = [];

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate(['distributors.*' => 'sometimes|exists:distributors,id'])]
    public array $distributors = [];

    #[Url(history: true)]
    #[Validate('in:any,include,exclude')]
    public string $adult = 'any';

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $tmdbId = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public string $imdbId = '';

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $tvdbId = null;

    #[Url(history: true)]
    #[Validate('sometimes|integer')]
    public ?int $malId = null;

    #[Url(history: true)]
    #[Validate('sometimes|in:playlists,id')]
    public ?int $playlistId = null;

    #[Url(history: true)]
    #[Validate('sometimes|in:collections,id')]
    public ?int $collectionId = null;

    #[Url(history: true)]
    #[Validate('sometimes|in:networks,id')]
    public ?int $networkId = null;

    #[Url(history: true)]
    #[Validate('sometimes|in:companies,id')]
    public ?int $companyId = null;

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate('sometimes|regex:/[a-z]{2}/i')]
    public array $primaryLanguages = [];

    /**
     * @var string[]
     */
    #[Url(history: true)]
    #[Validate('sometimes|integer|min:0|max:100')]
    public array $free = [];

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $doubleup = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $featured = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $refundable = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $stream = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $sd = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $highspeed = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $bookmarked = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $wished = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $internal = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $personalRelease = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $alive = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $dying = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $dead = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $graveyard = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $notDownloaded = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $downloaded = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $seeding = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $leeching = false;

    #[Url(history: true)]
    #[Validate('sometimes|boolean')]
    public bool $incomplete = false;

    #[Url(history: true)]
    #[Validate('sometimes|integer|min:0,max:100')]
    public int $perPage = 25;

    // TODO: Change fields validated per layout
    #[Url(history: true)]
    #[Validate('in:name,size,seeders,leechers,times_completed,created_at,bumped_at')]
    public string $sortField = 'bumped_at';

    #[Url(history: true)]
    #[Validate('sometimes|in:asc,desc')]
    public string $sortDirection = 'desc';

    #[Url(history: true)]
    #[Validate('sometimes|in:group,poster,list')]
    public string $view = 'list';

    final public function updating(string $field, mixed &$value): void
    {
        $this->castLivewireProperties($field, $value);
    }

    final public function updatingName(): void
    {
        $this->resetPage();
    }

    final public function updatedView(): void
    {
        $this->perPage = \in_array($this->view, ['card', 'poster']) ? 24 : 25;
    }

    #[Computed]
    final public function personalFreeleech(): bool
    {
        return cache()->get('personal_freeleech:'.auth()->id()) ?? false;
    }

    final public function filters(): string
    {
        return implode(' AND ', array_keys([
            'uploader = '.$this->uploader                                                          => $this->uploader !== '',
            'startYear <= '.$this->startYear                                                       => $this->startYear !== null,
            'endYear >= '.$this->endYear                                                           => $this->endYear !== null,
            'minSize <= '.$this->minSize                                                           => $this->minSize !== null,
            'maxSize >= '.$this->maxSize                                                           => $this->maxSize !== null,
            'categories IN ['.implode(',', $this->categories).']'                                  => $this->categories !== [],
            'categories IN ['.implode(',', $this->types).']'                                       => $this->types !== [],
            'categories IN ['.implode(',', $this->resolutions).']'                                 => $this->resolutions !== [],
            'genres IN ['.implode(',', $this->genres).']'                                          => $this->genres !== [],
            'regions IN ['.implode(',', $this->regions).']'                                        => $this->regions !== [],
            'distributors IN ['.implode(',', $this->distributors).']'                              => $this->distributors !== [],
            'keywords IN [("'.implode('"),("', TorrentTools::parseKeywords($this->keywords)).'")]' => $this->keywords !== '',
            'tmdb = '.$this->tmdbId                                                                => $this->tmdbId !== null,
            'imdb = '.$this->imdbId                                                                => $this->imdbId !== '',
            'tvdb = '.$this->tvdbId                                                                => $this->tvdbId !== null,
            'mal = '.$this->malId                                                                  => $this->malId !== null,
            'playlists = '.$this->playlistId                                                       => $this->playlistId !== null,
            'collection_id = '.$this->collectionId                                                 => $this->collectionId !== null,
            'companies = '.$this->companyId                                                        => $this->companyId !== null,
            'networks = '.$this->networkId                                                         => $this->networkId !== null,
            // TODO: 'primary_language IN ['.implode(',', $this->primaryLanguages).']' => $this->primaryLanguages !== [],
            'free IN ['.implode(',', $this->free).']' => $this->free !== [],
            // TODO: 'adult = true'                                                    => $this->adult === 'include',
            // TODO: 'adult = false'                                                   => $this->adult === 'exclude',
            'doubleup = true'           => $this->doubleup,
            'featured = true'           => $this->featured,
            'refundable = true'         => $this->refundable,
            'stream = true'             => $this->stream,
            'sd = true'                 => $this->sd,
            'highspeed = true'          => $this->highspeed,
            'bookmarks = '.auth()->id() => $this->bookmarked,
            // TODO:  ' wishes = '.auth()->id() => $this->wished,
            'internal = true'                                                                          => $this->internal,
            'personal_release = true'                                                                  => $this->personalRelease,
            'seeders > 0'                                                                              => $this->alive,
            'seeders = 1 AND times_completed > 3'                                                      => $this->dying,
            'seeders = 0'                                                                              => $this->dead,
            'seeders = 0 AND created_at < '.now()->subDays(30)->timestamp                              => $this->graveyard,
            'history.user_id = '.auth()->id()                                                          => $this->downloaded,
            'history.user_id != '.auth()->id()                                                         => $this->notDownloaded,
            'history.user_id = '.auth()->id().' AND history.active = true'                             => $this->seeding,
            'history.user_id = '.auth()->id().' AND history.active = false'                            => $this->leeching,
            'history.user_id = '.auth()->id().' AND history.active = false AND history.seeder = false' => $this->incomplete,
        ], true));
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<Torrent>
     */
    #[Computed]
    final public function torrents(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        start_measure('torrents');
        $user = auth()->user();

        //        $this->validate();

        $torrents = Torrent::search(
            $this->name,
            function (Indexes $meilisearch, string $query, array $options) {
                $options['sort'] = [
                    'sticky:desc',
                    $this->sortField.':'.$this->sortDirection,
                ];
                $options['filter'] = $this->filters();

                start_measure('search');
                $results = $meilisearch->search($query, $options);
                stop_measure('search');

                return $results;
            }
        )
            ->query(
                fn (Builder $query) => $query
                    ->with(['user:id,username,group_id', 'user.group', 'category', 'type', 'resolution'])
                    ->withCount([
                        'thanks',
                        'comments',
                        'seeds'   => fn ($query) => $query->where('active', '=', true)->where('visible', '=', true),
                        'leeches' => fn ($query) => $query->where('active', '=', true)->where('visible', '=', true),
                    ])
                    ->withExists([
                        'bookmarks'          => fn ($query) => $query->where('user_id', '=', $user->id),
                        'freeleechTokens'    => fn ($query) => $query->where('user_id', '=', $user->id),
                        'history as seeding' => fn ($query) => $query->where('user_id', '=', $user->id)
                            ->where('active', '=', 1)
                            ->where('seeder', '=', 1),
                        'history as leeching' => fn ($query) => $query->where('user_id', '=', $user->id)
                            ->where('active', '=', 1)
                            ->where('seeder', '=', 0),
                        'history as not_completed' => fn ($query) => $query->where('user_id', '=', $user->id)
                            ->where('active', '=', 0)
                            ->where('seeder', '=', 0)
                            ->whereNull('completed_at'),
                        'history as not_seeding' => fn ($query) => $query->where('user_id', '=', $user->id)
                            ->where('active', '=', 0)
                            ->where(
                                fn ($query) => $query
                                    ->where('seeder', '=', 1)
                                    ->orWhereNotNull('completed_at')
                            ),
                    ])
                    ->selectRaw("
                        CASE
                            WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie'
                            WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv'
                            WHEN category_id IN (SELECT `id` from `categories` where `game_meta` = 1) THEN 'game'
                            WHEN category_id IN (SELECT `id` from `categories` where `music_meta` = 1) THEN 'music'
                            WHEN category_id IN (SELECT `id` from `categories` where `no_meta` = 1) THEN 'no'
                        END as meta
                    ")
            )
            ->paginate(min($this->perPage, 100));

        stop_measure('torrents');

        start_measure('eager load');
        $movieIds = $torrents->getCollection()->where('meta', '=', 'movie')->pluck('tmdb');
        $tvIds = $torrents->getCollection()->where('meta', '=', 'tv')->pluck('tmdb');
        $gameIds = $torrents->getCollection()->where('meta', '=', 'game')->pluck('igdb');

        $movies = Movie::with('genres')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
        $tv = Tv::with('genres')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');
        $games = [];

        foreach ($gameIds as $gameId) {
            $games[] = \MarcReichel\IGDBLaravel\Models\Game::with(['cover' => ['url', 'image_id']])->find($gameId);
        }

        $torrents = $torrents->through(function ($torrent) use ($movies, $tv, $games) {
            $torrent->meta = match ($torrent->meta) {
                'movie' => $movies[$torrent->tmdb] ?? null,
                'tv'    => $tv[$torrent->tmdb] ?? null,
                'game'  => $games[$torrent->igdb] ?? null,
                default => null,
            };

            return $torrent;
        });

        stop_measure('eager load');

        return $torrents;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<Torrent>
     */
    #[Computed]
    final public function groupedTorrents()
    {
        $user = auth()->user();

        // Whitelist which columns are allowed to be ordered by
        if (!\in_array($this->sortField, [
            'bumped_at',
            'times_completed',
        ])) {
            $this->reset('sortField');
        }

        $groups = Torrent::query()
            ->select('tmdb')
            ->selectRaw('MAX(sticky) as sticky')
            ->selectRaw('MAX(bumped_at) as bumped_at')
            ->selectRaw('SUM(times_completed) as times_completed')
            ->selectRaw("CASE WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie' WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv' END as meta")
            ->havingNotNull('meta')
            ->where('tmdb', '!=', 0)
            ->where($this->filters())
            ->groupBy('tmdb', 'meta')
            ->latest('sticky')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(min($this->perPage, 100));

        $movieIds = $groups->getCollection()->where('meta', '=', 'movie')->pluck('tmdb');
        $tvIds = $groups->getCollection()->where('meta', '=', 'tv')->pluck('tmdb');

        $movies = Movie::with('genres', 'directors')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
        $tv = Tv::with('genres', 'creators')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');

        $torrents = Torrent::query()
            ->with(['type:id,name,position', 'resolution:id,name,position'])
            ->withCount([
                'seeds'   => fn ($query) => $query->where('active', '=', true)->where('visible', '=', true),
                'leeches' => fn ($query) => $query->where('active', '=', true)->where('visible', '=', true),
            ])
            ->withExists([
                'freeleechTokens'    => fn ($query) => $query->where('user_id', '=', $user->id),
                'bookmarks'          => fn ($query) => $query->where('user_id', '=', $user->id),
                'history as seeding' => fn ($query) => $query->where('user_id', '=', $user->id)
                    ->where('active', '=', 1)
                    ->where('seeder', '=', 1),
                'history as leeching' => fn ($query) => $query->where('user_id', '=', $user->id)
                    ->where('active', '=', 1)
                    ->where('seeder', '=', 0),
                'history as not_completed' => fn ($query) => $query->where('user_id', '=', $user->id)
                    ->where('active', '=', 0)
                    ->where('seeder', '=', 0)
                    ->whereNull('completed_at'),
                'history as not_seeding' => fn ($query) => $query->where('user_id', '=', $user->id)
                    ->where('active', '=', 0)
                    ->where(
                        fn ($query) => $query
                            ->where('seeder', '=', 1)
                            ->orWhereNotNull('completed_at')
                    ),
            ])
            ->select([
                'id',
                'name',
                'info_hash',
                'size',
                'leechers',
                'seeders',
                'times_completed',
                'category_id',
                'user_id',
                'season_number',
                'episode_number',
                'tmdb',
                'stream',
                'free',
                'doubleup',
                'highspeed',
                'featured',
                'sticky',
                'sd',
                'internal',
                'created_at',
                'bumped_at',
                'type_id',
                'resolution_id',
                'personal_release',
            ])
            ->selectRaw("CASE WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie' WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv' END as meta")
            ->where(
                fn ($query) => $query
                    ->where(
                        fn ($query) => $query
                            ->whereIn('category_id', Category::select('id')->where('movie_meta', '=', 1))
                            ->whereIntegerInRaw('tmdb', $movieIds)
                    )
                    ->orWhere(
                        fn ($query) => $query
                            ->whereIn('category_id', Category::select('id')->where('tv_meta', '=', 1))
                            ->whereIntegerInRaw('tmdb', $tvIds)
                    )
            )
            ->where($this->filters())
            ->get()
            ->groupBy('meta')
            ->map(fn ($movieOrTv, $key) => match ($key) {
                'movie' => $movieOrTv
                    ->groupBy('tmdb')
                    ->map(
                        function ($movie) {
                            $category_id = $movie->first()->category_id;
                            $movie = $movie
                                ->sortBy('type.position')
                                ->values()
                                ->groupBy(fn ($torrent) => $torrent->type->name)
                                ->map(
                                    fn ($torrentsByType) => $torrentsByType
                                        ->sortBy([
                                            ['resolution.position', 'asc'],
                                            ['internal', 'desc'],
                                            ['size', 'desc']
                                        ])
                                        ->values()
                                );
                            $movie->put('category_id', $category_id);

                            return $movie;
                        }
                    ),
                'tv' => $movieOrTv
                    ->groupBy([
                        fn ($torrent) => $torrent->tmdb,
                    ])
                    ->map(
                        function ($tv) {
                            $category_id = $tv->first()->category_id;
                            $tv = $tv
                                ->groupBy(fn ($torrent) => $torrent->season_number === 0 ? ($torrent->episode_number === 0 ? 'Complete Pack' : 'Specials') : 'Seasons')
                                ->map(fn ($packOrSpecialOrSeasons, $key) => match ($key) {
                                    'Complete Pack' => $packOrSpecialOrSeasons
                                        ->sortBy('type.position')
                                        ->values()
                                        ->groupBy(fn ($torrent) => $torrent->type->name)
                                        ->map(
                                            fn ($torrentsByType) => $torrentsByType
                                                ->sortBy([
                                                    ['resolution.position', 'asc'],
                                                    ['internal', 'desc'],
                                                    ['size', 'desc']
                                                ])
                                                ->values()
                                        ),
                                    'Specials' => $packOrSpecialOrSeasons
                                        ->groupBy(fn ($torrent) => 'Special '.$torrent->episode_number)
                                        ->sortKeys(SORT_NATURAL)
                                        ->map(
                                            fn ($episode) => $episode
                                                ->sortBy('type.position')
                                                ->values()
                                                ->groupBy(fn ($torrent) => $torrent->type->name)
                                                ->map(
                                                    fn ($torrentsByType) => $torrentsByType
                                                        ->sortBy([
                                                            ['resolution.position', 'asc'],
                                                            ['internal', 'desc'],
                                                            ['size', 'desc']
                                                        ])
                                                        ->values()
                                                )
                                        ),
                                    'Seasons' => $packOrSpecialOrSeasons
                                        ->groupBy(fn ($torrent) => 'Season '.$torrent->season_number)
                                        ->sortKeys(SORT_NATURAL)
                                        ->map(
                                            fn ($season) => $season
                                                ->groupBy(fn ($torrent) => $torrent->episode_number === 0 ? 'Season Pack' : 'Episodes')
                                                ->map(fn ($packOrEpisodes, $key) => match ($key) {
                                                    'Season Pack' => $packOrEpisodes
                                                        ->sortBy('type.position')
                                                        ->values()
                                                        ->groupBy(fn ($torrent) => $torrent->type->name)
                                                        ->map(
                                                            fn ($torrentsByType) => $torrentsByType
                                                                ->sortBy([
                                                                    ['resolution.position', 'asc'],
                                                                    ['internal', 'desc'],
                                                                    ['size', 'desc']
                                                                ])
                                                                ->values()
                                                        ),
                                                    'Episodes' => $packOrEpisodes
                                                        ->groupBy(fn ($torrent) => 'Episode '.$torrent->episode_number)
                                                        ->sortKeys(SORT_NATURAL)
                                                        ->map(
                                                            fn ($episode) => $episode
                                                                ->sortBy('type.position')
                                                                ->values()
                                                                ->groupBy(fn ($torrent) => $torrent->type->name)
                                                                ->map(
                                                                    fn ($torrentsBytype) => $torrentsBytype
                                                                        ->sortBy([
                                                                            ['resolution.position', 'asc'],
                                                                            ['internal', 'desc'],
                                                                            ['size', 'desc']
                                                                        ])
                                                                        ->values()
                                                                )
                                                        ),
                                                    default => abort(500, 'Group found that isn\'t one of: Season Pack, Episodes.'),
                                                })
                                        ),
                                    default => abort(500, 'Group found that isn\'t one of: Complete Pack, Specials, Seasons'),
                                });
                            $tv->put('category_id', $category_id);

                            return $tv;
                        }
                    ),
                default => abort(500, 'Group found that isn\'t one of: movie, tv'),
            });

        $medias = $groups->through(function ($group) use ($torrents, $movies, $tv) {
            $media = collect(['meta' => 'no']);

            switch ($group->meta) {
                case 'movie':
                    $media = $movies[$group->tmdb] ?? collect();
                    $media->meta = 'movie';
                    $media->torrents = $torrents['movie'][$group->tmdb] ?? collect();
                    $media->category_id = $media->torrents->pop();

                    break;
                case 'tv':
                    $media = $tv[$group->tmdb] ?? collect();
                    $media->meta = 'tv';
                    $media->torrents = $torrents['tv'][$group->tmdb] ?? collect();
                    $media->category_id = $media->torrents->pop();

                    break;
            }

            return $media;
        });

        return $medias;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<Torrent>
     */
    #[Computed]
    final public function groupedPosters()
    {
        // Whitelist which columns are allowed to be ordered by
        if (!\in_array($this->sortField, [
            'bumped_at',
            'times_completed',
        ])) {
            $this->reset('sortField');
        }

        $groups = Torrent::query()
            ->select('tmdb')
            ->selectRaw('MAX(sticky) as sticky')
            ->selectRaw('MAX(bumped_at) as bumped_at')
            ->selectRaw('SUM(times_completed) as times_completed')
            ->selectRaw('MIN(category_id) as category_id')
            ->selectRaw("CASE WHEN category_id IN (SELECT `id` from `categories` where `movie_meta` = 1) THEN 'movie' WHEN category_id IN (SELECT `id` from `categories` where `tv_meta` = 1) THEN 'tv' END as meta")
            ->havingNotNull('meta')
            ->where('tmdb', '!=', 0)
            ->where($this->filters())
            ->groupBy('tmdb', 'meta')
            ->latest('sticky')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(min($this->perPage, 100));

        $movieIds = $groups->getCollection()->where('meta', '=', 'movie')->pluck('tmdb');
        $tvIds = $groups->getCollection()->where('meta', '=', 'tv')->pluck('tmdb');

        $movies = Movie::with('genres', 'directors')->whereIntegerInRaw('id', $movieIds)->get()->keyBy('id');
        $tv = Tv::with('genres', 'creators')->whereIntegerInRaw('id', $tvIds)->get()->keyBy('id');

        $groups = $groups->through(function ($group) use ($movies, $tv) {
            switch ($group->meta) {
                case 'movie':
                    $group->movie = $movies[$group->tmdb] ?? null;

                    break;
                case 'tv':
                    $group->tv = $tv[$group->tmdb] ?? null;

                    break;
            }

            return $group;
        });

        return $groups;
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.torrent-search', [
            'user'              => User::with(['group'])->findOrFail(auth()->id()),
            'personalFreeleech' => $this->personalFreeleech,
            'torrents'          => match ($this->view) {
                'group'  => $this->groupedTorrents,
                'poster' => $this->groupedPosters,
                default  => $this->torrents,
            },
        ]);
    }
}
