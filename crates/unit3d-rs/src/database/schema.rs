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
    groups (id) {
        id -> Integer,
        #[max_length = 255]
        name -> Varchar,
        #[max_length = 255]
        slug -> Varchar,
        position -> Integer,
        level -> Integer,
        download_slots -> Nullable<Integer>,
        #[max_length = 255]
        description -> Nullable<Varchar>,
        #[max_length = 255]
        color -> Varchar,
        #[max_length = 255]
        icon -> Varchar,
        #[max_length = 255]
        effect -> Varchar,
        is_internal -> Bool,
        is_editor -> Bool,
        is_owner -> Bool,
        is_admin -> Bool,
        is_modo -> Bool,
        is_trusted -> Bool,
        is_immune -> Bool,
        is_freeleech -> Bool,
        is_double_upload -> Bool,
        is_refundable -> Bool,
        can_upload -> Bool,
        is_incognito -> Bool,
        autogroup -> Bool,
        min_uploaded -> Nullable<Unsigned<Bigint>>,
        min_seedsize -> Nullable<Unsigned<Bigint>>,
        min_avg_seedtime -> Nullable<Unsigned<Bigint>>,
        min_ratio -> Nullable<Decimal>,
        min_age -> Nullable<Unsigned<Bigint>>,
        system_required -> Bool,
        min_uploads -> Nullable<Unsigned<Bigint>>,
    }
}

diesel::table! {
    notifications (id) {
        #[max_length = 36]
        id -> Char,
        #[sql_name = "type"]
        #[max_length = 255]
        type_ -> Varchar,
        notifiable_id -> Unsigned<Integer>,
        #[max_length = 255]
        notifiable_type -> Varchar,
        data -> Text,
        read_at -> Nullable<Datetime>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    pages (id) {
        id -> Integer,
        #[max_length = 255]
        name -> Nullable<Varchar>,
        content -> Nullable<Text>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    participants (id) {
        id -> Unsigned<Integer>,
        conversation_id -> Unsigned<Integer>,
        user_id -> Unsigned<Integer>,
        read -> Bool,
        deleted_at -> Nullable<Timestamp>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    peers (id) {
        id -> Unsigned<Bigint>,
        #[max_length = 20]
        peer_id -> Binary,
        #[max_length = 16]
        ip -> Binary,
        port -> Unsigned<Smallint>,
        #[max_length = 64]
        agent -> Varchar,
        uploaded -> Unsigned<Bigint>,
        downloaded -> Unsigned<Bigint>,
        left -> Unsigned<Bigint>,
        seeder -> Bool,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
        torrent_id -> Unsigned<Integer>,
        user_id -> Unsigned<Integer>,
        connectable -> Bool,
        active -> Bool,
        visible -> Bool,
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
    tickets (id) {
        id -> Unsigned<Bigint>,
        user_id -> Unsigned<Integer>,
        category_id -> Integer,
        priority_id -> Integer,
        staff_id -> Nullable<Unsigned<Integer>>,
        user_read -> Nullable<Tinyint>,
        staff_read -> Nullable<Tinyint>,
        #[max_length = 255]
        subject -> Varchar,
        body -> Longtext,
        closed_at -> Nullable<Timestamp>,
        reminded_at -> Nullable<Timestamp>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
        deleted_at -> Nullable<Timestamp>,
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

diesel::table! {
    user_notifications (id) {
        id -> Integer,
        user_id -> Unsigned<Integer>,
        block_notifications -> Bool,
        show_bon_gift -> Bool,
        show_mention_forum_post -> Bool,
        show_mention_article_comment -> Bool,
        show_mention_request_comment -> Bool,
        show_mention_torrent_comment -> Bool,
        show_subscription_topic -> Bool,
        show_subscription_forum -> Bool,
        show_forum_topic -> Bool,
        show_following_upload -> Bool,
        show_request_bounty -> Bool,
        show_request_comment -> Bool,
        show_request_fill -> Bool,
        show_request_fill_approve -> Bool,
        show_request_fill_reject -> Bool,
        show_request_claim -> Bool,
        show_request_unclaim -> Bool,
        show_torrent_comment -> Bool,
        show_torrent_tip -> Bool,
        show_torrent_thank -> Bool,
        show_account_follow -> Bool,
        show_account_unfollow -> Bool,
        json_account_groups -> Json,
        json_bon_groups -> Json,
        json_mention_groups -> Json,
        json_request_groups -> Json,
        json_torrent_groups -> Json,
        json_forum_groups -> Json,
        json_following_groups -> Json,
        json_subscription_groups -> Json,
    }
}

diesel::table! {
    user_settings (id) {
        id -> Unsigned<Integer>,
        user_id -> Unsigned<Integer>,
        censor -> Bool,
        chat_hidden -> Bool,
        #[max_length = 255]
        locale -> Varchar,
        style -> Unsigned<Tinyint>,
        torrent_layout -> Unsigned<Tinyint>,
        torrent_filters -> Bool,
        #[max_length = 255]
        custom_css -> Nullable<Varchar>,
        #[max_length = 255]
        standalone_css -> Nullable<Varchar>,
        show_poster -> Bool,
        #[max_length = 255]
        torrent_sort_field -> Varchar,
        torrent_search_autofocus -> Bool,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    users (id) {
        id -> Unsigned<Integer>,
        #[max_length = 255]
        username -> Varchar,
        #[max_length = 255]
        email -> Varchar,
        #[max_length = 255]
        password -> Varchar,
        two_factor_secret -> Nullable<Text>,
        two_factor_recovery_codes -> Nullable<Text>,
        two_factor_confirmed_at -> Nullable<Timestamp>,
        #[max_length = 255]
        passkey -> Varchar,
        group_id -> Integer,
        active -> Bool,
        uploaded -> Unsigned<Bigint>,
        downloaded -> Unsigned<Bigint>,
        #[max_length = 255]
        image -> Nullable<Varchar>,
        #[max_length = 255]
        title -> Nullable<Varchar>,
        about -> Nullable<Mediumtext>,
        signature -> Nullable<Text>,
        fl_tokens -> Unsigned<Integer>,
        seedbonus -> Decimal,
        invites -> Unsigned<Integer>,
        hitandruns -> Unsigned<Integer>,
        #[max_length = 255]
        rsskey -> Varchar,
        chatroom_id -> Unsigned<Integer>,
        read_rules -> Bool,
        can_chat -> Bool,
        can_comment -> Bool,
        can_download -> Bool,
        can_request -> Bool,
        can_invite -> Bool,
        can_upload -> Bool,
        #[max_length = 255]
        remember_token -> Nullable<Varchar>,
        #[max_length = 100]
        api_token -> Nullable<Varchar>,
        last_login -> Nullable<Datetime>,
        last_action -> Nullable<Datetime>,
        disabled_at -> Nullable<Datetime>,
        deleted_by -> Nullable<Unsigned<Integer>>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
        chat_status_id -> Unsigned<Integer>,
        deleted_at -> Nullable<Timestamp>,
        own_flushes -> Tinyint,
        email_verified_at -> Nullable<Timestamp>,
    }
}

diesel::table! {
    warnings (id) {
        id -> Unsigned<Integer>,
        user_id -> Unsigned<Integer>,
        warned_by -> Unsigned<Integer>,
        torrent -> Nullable<Unsigned<Integer>>,
        reason -> Text,
        expires_on -> Nullable<Datetime>,
        active -> Bool,
        deleted_by -> Nullable<Unsigned<Integer>>,
        deleted_at -> Nullable<Timestamp>,
        created_at -> Nullable<Timestamp>,
        updated_at -> Nullable<Timestamp>,
    }
}

diesel::joinable!(featured_torrents -> torrents (torrent_id));
diesel::joinable!(featured_torrents -> users (user_id));
diesel::joinable!(notifications -> users (notifiable_id));
diesel::joinable!(participants -> users (user_id));
diesel::joinable!(peers -> torrents (torrent_id));
diesel::joinable!(peers -> users (user_id));
diesel::joinable!(playlist_torrents -> torrents (torrent_id));
diesel::joinable!(torrents -> users (user_id));
diesel::joinable!(users -> groups (group_id));
diesel::joinable!(user_notifications -> users (user_id));
diesel::joinable!(user_settings -> users (user_id));
diesel::joinable!(warnings -> torrents (torrent));

diesel::allow_tables_to_appear_in_same_query!(
    featured_torrents,
    groups,
    notifications,
    pages,
    participants,
    peers,
    playlist_torrents,
    tickets,
    torrents,
    user_notifications,
    user_settings,
    users,
    warnings,
);
