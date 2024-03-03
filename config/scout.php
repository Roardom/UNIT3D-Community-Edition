<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "meilisearch", "typesense",
    |            "database", "collection", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => env('SCOUT_QUEUE', true),

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    |
    | This configuration option determines if your data will only be synced
    | with your search indexes after every open database transaction has
    | been committed, thus preventing any discarded data from syncing.
    |
    */

    'after_commit' => false,

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable'   => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => false,

    /*
    |--------------------------------------------------------------------------
    | Identify User
    |--------------------------------------------------------------------------
    |
    | This option allows you to control whether to notify the search engine
    | of the user performing the search. This is sometimes useful if the
    | engine supports any analytics based on this application's users.
    |
    | Supported engines: "algolia"
    |
    */

    'identify' => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id'     => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Meilisearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Meilisearch settings. Meilisearch is an open
    | source search engine with minimal configuration. Below, you can state
    | the host and key information for your own Meilisearch installation.
    |
    | See: https://www.meilisearch.com/docs/learn/configuration/instance_options#all-instance-options
    |
    */

    'meilisearch' => [
        'host'           => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key'            => env('MEILISEARCH_KEY'),
        'index-settings' => [
            App\Models\Torrent::class => [
                'searchableAttributes' => [
                    'name',
                    'description',
                    'mediainfo',
                    'bdinfo',
                ],
                'filterableAttributes' => [
                    'id',
                    'name',
                    'description',
                    'mediainfo',
                    'bdinfo',
                    'folder',
                    'size',
                    'leechers',
                    'seeders',
                    'times_completed',
                    'created_at',
                    'bumped_at',
                    'fl_until',
                    'du_until',
                    'category_id',
                    'category_name',
                    'username',
                    'imdb',
                    'tvdb',
                    'tmdb',
                    'mal',
                    'igdb',
                    'season_number',
                    'episode_number',
                    'stream',
                    'free',
                    'doubleup',
                    'refundable',
                    'highspeed',
                    'featured',
                    'status',
                    'anon',
                    'sticky',
                    'sd',
                    'internal',
                    'release_year',
                    'type_id',
                    'resolution_id',
                    'distributor_id',
                    'region_id',
                    'personal_release',
                    'info_hash',
                    'history.user_id',
                    'history.seeder',
                    'history.active',
                    'history.completed_at',
                    'companies',
                    'genres',
                    'networks',
                    'collection_id',
                    'playlists',
                    'bookmarks',
                    'files.name',
                    'files.size',
                    'keywords',
                ],
                'sortableAttributes' => [
                    'name',
                    'size',
                    'seeders',
                    'leechers',
                    'times_completed',
                    'created_at',
                    'bumped_at',
                    'sticky',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Typesense Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Typesense settings. Typesense is an open
    | source search engine using minimal configuration. Below, you will
    | state the host, key, and schema configuration for the instance.
    |
    */

    'typesense' => [
        'client-settings' => [
            'api_key' => env('TYPESENSE_API_KEY', 'xyz'),
            'nodes'   => [
                [
                    'host'     => env('TYPESENSE_HOST', 'localhost'),
                    'port'     => env('TYPESENSE_PORT', '8108'),
                    'path'     => env('TYPESENSE_PATH', ''),
                    'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
                ],
            ],
            'nearest_node' => [
                'host'     => env('TYPESENSE_HOST', 'localhost'),
                'port'     => env('TYPESENSE_PORT', '8108'),
                'path'     => env('TYPESENSE_PATH', ''),
                'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
            ],
            'connection_timeout_seconds'   => env('TYPESENSE_CONNECTION_TIMEOUT_SECONDS', 2),
            'healthcheck_interval_seconds' => env('TYPESENSE_HEALTHCHECK_INTERVAL_SECONDS', 30),
            'num_retries'                  => env('TYPESENSE_NUM_RETRIES', 3),
            'retry_interval_seconds'       => env('TYPESENSE_RETRY_INTERVAL_SECONDS', 1),
        ],
        'model-settings' => [
            App\Models\Torrent::class => [
                'collection-schema' => [
                    'fields' => [
                        [
                            'name' => 'id',
                            'type' => 'string',
                        ],
                        [
                            'name' => 'name',
                            'type' => 'string',
                        ],
                        [
                            'name'     => 'description',
                            'type'     => 'string',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'mediainfo',
                            'type'     => 'string',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'bdinfo',
                            'type'     => 'string',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'folder',
                            'type'     => 'string',
                            'optional' => true,
                        ],
                        [
                            'name' => 'size',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'leechers',
                            'type' => 'int32',
                        ],
                        [
                            'name' => 'seeders',
                            'type' => 'int32',
                        ],
                        [
                            'name' => 'times_completed',
                            'type' => 'int32',
                        ],
                        [
                            'name' => 'created_at',
                            'type' => 'int64',
                        ],
                        [
                            'name'     => 'bumped_at',
                            'type'     => 'int64',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'fl_until',
                            'type'     => 'int64',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'du_until',
                            'type'     => 'int64',
                            'optional' => true,
                        ],
                        [
                            'name' => 'imdb',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'tvdb',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'tmdb',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'mal',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'igdb',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'season_number',
                            'type' => 'int64',
                        ],
                        [
                            'name' => 'stream',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'free',
                            'type' => 'int32',
                        ],
                        [
                            'name' => 'doubleup',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'refundable',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'highspeed',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'featured',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'status',
                            'type' => 'int32',
                        ],
                        [
                            'name' => 'anon',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'sticky',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'sd',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'internal',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'release_year',
                            'type' => 'int32',
                        ],
                        [
                            'name'     => 'distributor_id',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'region_id',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name' => 'personal_release',
                            'type' => 'bool',
                        ],
                        [
                            'name' => 'info_hash',
                            'type' => 'string',
                        ],
                        [
                            'name' => 'history',
                            'type' => 'object[]',
                        ],
                        [
                            'name' => 'username',
                            'type' => 'string',
                        ],
                        [
                            'name'     => 'category_id',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name' => 'category_name',
                            'type' => 'string',
                        ],
                        [
                            'name'     => 'type_id',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'resolution_id',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name'     => 'collection',
                            'type'     => 'int32',
                            'optional' => true,
                        ],
                        [
                            'name' => 'companies',
                            'type' => 'int32[]',
                        ],
                        [
                            'name' => 'networks',
                            'type' => 'int32[]',
                        ],
                        [
                            'name' => 'playlists',
                            'type' => 'int32[]',
                        ],
                        [
                            'name' => 'bookmarks',
                            'type' => 'int32[]',
                        ],
                        [
                            'name' => 'files',
                            'type' => 'object[]',
                        ],
                        [
                            'name' => 'keywords',
                            'type' => 'string[]',
                        ],
                        [
                            'name'     => '__soft_deleted',
                            'type'     => 'object[]',
                            'optional' => true,
                        ],
                    ],
                    'default_sorting_field' => 'created_at',
                ],
                'search-parameters' => [
                    'query_by' => 'name'
                ],
            ],
        ],
    ],
];
