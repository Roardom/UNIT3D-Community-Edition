// // use diesel::prelude::*;

// use crate::database::schema::{user_settings, users};

// #[derive(Queryable, Clone, Debug)]
// struct AuthenticatedUser {
//     id: u32,
//     username: String,
//     locale: String,
//     uploaded: u64,
//     downloaded: u64,
//     standalone_css: Option<String>,
//     custom_css: Option<String>,
//     style: u8,
//     freeleech_token_count: u32,
//     // warning_count: Option<i64>,
//     // seeding_count: Option<i64>,
//     // leeching_count: Option<i64>,
//     // is_modo: Option<bool>,
//     // icon: Option<String>,
//     // effect: Option<String>,
//     // color: Option<String>,
// }

// impl CurrentUser {
//     pub async fn from_db(app: AppState) -> anyhow::Result<Self> {
//         use diesel_async::RunQueryDsl;
//         let conn = &mut *app.db.get().await?;

//         let (id, username, uploaded, downloaded, freeleech_token_count) = users::table
//             .filter(users::id.eq(3))
//             .select((
//                 users::id,
//                 users::username,
//                 users::uploaded,
//                 users::downloaded,
//                 users::fl_tokens,
//             ))
//             .first::<(u32, String, u64, u64, u32)>(conn)
//             .await?;

//         let (locale, standalone_css, custom_css, style) = user_settings::table
//             .filter(user_settings::user_id.eq(3))
//             .select((
//                 user_settings::locale,
//                 user_settings::standalone_css,
//                 user_settings::custom_css,
//                 user_settings::style,
//             ))
//             .first::<(String, Option<String>, Option<String>, u8)>(conn)
//             .await?;

//         Ok(CurrentUser {
//             id,
//             username,
//             uploaded,
//             downloaded,
//             freeleech_token_count,
//             locale,
//             standalone_css,
//             custom_css,
//             style,
//         })
//     }
// }
