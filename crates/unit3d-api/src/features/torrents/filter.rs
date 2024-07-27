use std::{
    default,
    fmt::{format, Display},
    str::FromStr,
};

use crate::{
    database::schema::torrents,
    error::Error,
    features::resource::{Collection, Links},
    state::AppState,
};
use axum::{
    debug_handler,
    extract::{Query, State},
    response::ErrorResponse,
    Json,
};
use axum_extra::routing::TypedPath;
use chrono::NaiveDateTime;
use serde::{Deserialize, Serialize};

use crate::database::models::Torrent;

#[derive(TypedPath, Deserialize)]
#[typed_path("/api/torrents/filter")]
pub struct TorrentFilterPath;

#[derive(Deserialize)]
#[serde(rename_all = "camelCase")]
pub struct Filters {
    per_page: Option<u8>,
    #[serde(default)]
    sort_field: SortField,
    #[serde(default)]
    sort_direction: SortDirection,
    name: Option<String>,
    description: Option<String>,
    mediainfo: Option<String>,
    bdinfo: Option<String>,
    uploader: Option<String>,
    keywords: Option<String>,
    start_year: Option<u16>,
    end_year: Option<u16>,
    categories: Option<Vec<u32>>,
    types: Option<Vec<u32>>,
    resolutions: Option<Vec<u32>>,
    genres: Option<Vec<u32>>,
    tmdb_id: Option<u32>,
    imdb_id: Option<u32>,
    tvdb_id: Option<u32>,
    mal_id: Option<u32>,
    playlist_id: Option<u32>,
    collection_id: Option<u32>,
    free: Option<u8>,
    doubleup: Option<bool>,
    featured: Option<bool>,
    refundable: Option<bool>,
    stream: Option<bool>,
    sd: Option<bool>,
    highspeed: Option<bool>,
    internal: Option<bool>,
    personal_release: Option<bool>,
    alive: Option<bool>,
    dying: Option<bool>,
    dead: Option<bool>,
    file_name: Option<String>,
    season_number: Option<u32>,
    episode_number: Option<u32>,
}

#[derive(Default, Deserialize)]
enum SortDirection {
    #[default]
    Asc,
    Desc,
}

impl FromStr for SortDirection {
    type Err = ();

    fn from_str(s: &str) -> Result<Self, Self::Err> {
        match s {
            "desc" => Ok(Self::Desc),
            _ => Ok(Self::Asc),
        }
    }
}

#[derive(Default, Deserialize)]
enum SortField {
    Name,
    Size,
    Seeders,
    Leechers,
    TimesCompleted,
    CreatedAt,
    #[default]
    BumpedAt,
}

#[derive(Serialize)]
pub struct TorrentResource {
    #[serde(rename = "type")]
    resource_type: String,
    id: String,
    attributes: TorrentResourceAttributes,
}

#[derive(Serialize)]
struct TorrentResourceAttributes {
    // meta: Meta,
    name: String,
    release_year: Option<u16>,
    // category: String,
    // #[serde(rename = "type")]
    // torrent_type: String,
    // resolution: String,
    media_info: Option<String>,
    bd_info: Option<String>,
    description: String,
    info_hash: String,
    size: f64,
    num_file: i32,
    // files: Vec<TorrentFileResource>,
    freeleech: String,
    double_upload: bool,
    refundable: bool,
    internal: u8,
    featured: bool,
    personal_release: u8,
    // uploader: String,
    seeders: i32,
    leechers: i32,
    times_completed: i32,
    tmdb_id: u32,
    imdb_id: u32,
    tvdb_id: u32,
    mal_id: u32,
    igdb_id: String,
    category_id: Option<i32>,
    type_id: i32,
    resolution_id: Option<i32>,
    created_at: Option<NaiveDateTime>,
    download_link: String,
    details_link: String,
}

#[derive(Serialize)]
struct Meta {
    poster: String,
    genres: String,
}

#[derive(Serialize)]
struct TorrentFileResource {
    index: u32,
    name: String,
    size: u64,
}

impl FromStr for SortField {
    type Err = ();

    fn from_str(s: &str) -> Result<Self, Self::Err> {
        match s {
            "name" => Ok(Self::Name),
            "size" => Ok(Self::Size),
            "seeders" => Ok(Self::Seeders),
            "leechers" => Ok(Self::Leechers),
            "times_completed" => Ok(Self::TimesCompleted),
            "created_at" => Ok(Self::CreatedAt),
            _ => Ok(Self::BumpedAt),
        }
    }
}

// #[debug_handler]
pub async fn filter(
    _: TorrentFilterPath,
    State(state): State<AppState>,
    Query(filters): Query<Filters>,
) -> Result<Json<Collection<TorrentResource>>, Error> {
    use diesel::prelude::*;
    use diesel_async::RunQueryDsl;

    let mut conn = state.db.get_conn().await?;

    let mut query = torrents::table.into_boxed();

    if let Some(name) = filters.name {
        query = query.filter(torrents::name.like("%".to_owned() + &name.replace(" ", "%") + "%"));
    }

    if let Some(description) = filters.description {
        query = query.filter(torrents::description.like(description.replace(" ", "%")));
    }

    query = match filters.sort_direction {
        SortDirection::Asc => match filters.sort_field {
            SortField::Name => query.order_by(torrents::name.asc()),
            SortField::Size => query.order_by(torrents::size.asc()),
            SortField::Seeders => query.order_by(torrents::seeders.asc()),
            SortField::Leechers => query.order_by(torrents::leechers.asc()),
            SortField::TimesCompleted => query.order_by(torrents::times_completed.asc()),
            SortField::CreatedAt => query.order_by(torrents::created_at.asc()),
            SortField::BumpedAt => query.order_by(torrents::bumped_at.asc()),
        },
        SortDirection::Desc => match filters.sort_field {
            SortField::Name => query.order_by(torrents::name.desc()),
            SortField::Size => query.order_by(torrents::size.desc()),
            SortField::Seeders => query.order_by(torrents::seeders.desc()),
            SortField::Leechers => query.order_by(torrents::leechers.desc()),
            SortField::TimesCompleted => query.order_by(torrents::times_completed.desc()),
            SortField::CreatedAt => query.order_by(torrents::created_at.desc()),
            SortField::BumpedAt => query.order_by(torrents::bumped_at.desc()),
        },
    };

    query = query.limit(20);

    let torrents = query
        .load::<Torrent>(&mut conn)
        .await
        .map_err(|e| Error::DieselError(e))?
        .iter()
        .map(|torrent| TorrentResource {
            resource_type: "torrent".to_string(),
            id: torrent.id.to_string(),
            attributes: TorrentResourceAttributes {
                // meta: (),
                name: torrent.name.clone(),
                release_year: torrent.release_year,
                // category: (),
                // torrent_type: (),
                // resolution: (),
                media_info: torrent.mediainfo.clone(),
                bd_info: torrent.bdinfo.clone(),
                description: torrent.description.clone(),
                info_hash: hex_encode(torrent.info_hash.clone()),
                size: torrent.size,
                num_file: torrent.num_file,
                freeleech: format!("{}%", torrent.free),
                double_upload: torrent.doubleup,
                refundable: torrent.refundable,
                internal: torrent.internal as u8,
                featured: torrent.featured,
                personal_release: torrent.personal_release.try_into().unwrap_or(1),
                // uploader: (),
                seeders: torrent.seeders,
                leechers: torrent.leechers,
                times_completed: torrent.times_completed,
                tmdb_id: torrent.tmdb,
                imdb_id: torrent.imdb,
                tvdb_id: torrent.tvdb,
                mal_id: torrent.mal,
                igdb_id: torrent.igdb.clone(),
                category_id: torrent.category_id,
                type_id: torrent.type_id,
                resolution_id: torrent.resolution_id,
                created_at: torrent.created_at,
                download_link: format!("{}/torrent/download/", state.config.app_url),
                details_link: format!("{}/torrents/{}", state.config.app_url, torrent.id),
            },
        })
        .collect();

    Ok(Json(Collection {
        links: Links::default(),
        meta: crate::features::resource::Meta::default(),
        data: torrents,
    }))
}

/// Encodes a byte array into a string of ascii-encoded hex digits.
#[inline(always)]
pub fn hex_encode(bytes: Vec<u8>) -> String {
    let mut string = Vec::with_capacity(bytes.len() * 2);

    for byte in bytes {
        let char_1 = byte >> 4;
        let char_2 = byte & 0x0F;

        string.extend([
            match char_1 {
                0x0..=0x9 => char_1 + b'0',
                0xA..=0xF => char_1 - 0xA + b'A',
                _ => unreachable!(),
            },
            match char_2 {
                0x0..=0x9 => char_2 + b'0',
                0xA..=0xF => char_2 - 0xA + b'A',
                _ => unreachable!(),
            },
        ]);
    }

    String::from_utf8(string).unwrap()
}
