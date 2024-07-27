// @generated automatically by Diesel CLI.

diesel::table! {
    featured_torrents (id) {
        id -> Unsigned<Integer>,
        user_id -> Unsigned<Integer>,
        torrent_id -> Unsigned<Integer>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    playlist_torrents (id) {
        id -> Unsigned<Bigint>,
        position -> Nullable<Integer>,
        playlist_id -> Integer,
        torrent_id -> Unsigned<Integer>,
        tmdb_id -> Integer,
    }
}

diesel::table! {
    torrents (id) {
        id -> Unsigned<Integer>,
        #[max_length = 255]
        name -> Varchar,
        description -> Text,
        mediainfo -> Nullable<Text>,
        bdinfo -> Nullable<Longtext>,
        #[max_length = 255]
        file_name -> Varchar,
        num_file -> Integer,
        #[max_length = 255]
        folder -> Nullable<Varchar>,
        size -> Double,
        nfo -> Nullable<Blob>,
        leechers -> Integer,
        seeders -> Integer,
        times_completed -> Integer,
        category_id -> Nullable<Integer>,
        user_id -> Unsigned<Integer>,
        imdb -> Unsigned<Integer>,
        tvdb -> Unsigned<Integer>,
        tmdb -> Unsigned<Integer>,
        mal -> Unsigned<Integer>,
        #[max_length = 255]
        igdb -> Varchar,
        season_number -> Nullable<Integer>,
        episode_number -> Nullable<Integer>,
        stream -> Bool,
        free -> Smallint,
        doubleup -> Bool,
        refundable -> Bool,
        highspeed -> Bool,
        featured -> Bool,
        status -> Smallint,
        moderated_at -> Nullable<Datetime>,
        moderated_by -> Nullable<Integer>,
        anon -> Smallint,
        sticky -> Smallint,
        sd -> Bool,
        internal -> Bool,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
        bumped_at -> Nullable<Datetime>,
        deleted_at -> Nullable<Timestamp>,
        fl_until -> Nullable<Datetime>,
        du_until -> Nullable<Datetime>,
        release_year -> Nullable<Unsigned<Smallint>>,
        type_id -> Integer,
        resolution_id -> Nullable<Integer>,
        distributor_id -> Nullable<Integer>,
        region_id -> Nullable<Integer>,
        personal_release -> Integer,
        balance -> Nullable<Bigint>,
        balance_offset -> Nullable<Bigint>,
        #[max_length = 20]
        info_hash -> Binary,
    }
}

diesel::joinable!(featured_torrents -> torrents (torrent_id));
diesel::joinable!(playlist_torrents -> torrents (torrent_id));

diesel::allow_tables_to_appear_in_same_query!(
    featured_torrents,
    playlist_torrents,
    torrents,
);
