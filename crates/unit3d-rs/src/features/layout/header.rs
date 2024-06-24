use maud::{html, Markup, Render};

use crate::{
    database::{
        models::{Group, Peer, User, UserSetting, Warning},
        schema::{groups, peers, users},
    },
    state::{db_pool::DbConn, AppState},
};

#[derive(Clone)]
pub struct Header {
    from_db: HeaderDbData,
    title: String,
    meta: Option<Markup>,
    stylesheets: Option<Markup>,
}

impl Header {
    pub async fn new(conn: &mut DbConn, user_id: u32) -> anyhow::Result<Self> {
        Ok(Self {
            from_db: HeaderDbData::from_db(conn, user_id).await?,
            title: "test".to_string(),
            meta: None,
            stylesheets: None,
        })
    }
}

#[derive(Clone)]
struct HeaderDbData {
    user: User,
    user_group: Group,
    user_settings: Option<UserSetting>,
    warning_count: i64,
    seeding_count: i64,
    leeching_count: i64,
}

impl HeaderDbData {
    pub async fn from_db(conn: &mut DbConn, user_id: u32) -> anyhow::Result<Self> {
        use diesel::prelude::*;
        use diesel::OptionalExtension;
        use diesel_async::RunQueryDsl;

        let user: User = users::table
            .select(User::as_select())
            .find(user_id)
            .first(conn)
            .await?;

        let user_group: Group = groups::table
            .select(Group::as_select())
            .find(user.group_id)
            .first(conn)
            .await?;

        let user_settings: Option<UserSetting> = UserSetting::belonging_to(&user)
            .select(UserSetting::as_select())
            .first(conn)
            .await
            .optional()?;

        let warning_count = Warning::belonging_to(&user).count().first(conn).await?;

        let seeding_count = Peer::belonging_to(&user)
            .filter(peers::active.eq(true))
            .filter(peers::seeder.eq(true))
            .count()
            .first(conn)
            .await?;

        let leeching_count = Peer::belonging_to(&user)
            .filter(peers::active.eq(true))
            .filter(peers::seeder.eq(false))
            .count()
            .first(conn)
            .await?;

        Ok(Self {
            user,
            user_group,
            user_settings,
            warning_count,
            seeding_count,
            leeching_count,
        })
    }
}

impl Render for Header {
    fn render(&self) -> Markup {
        html! {
            meta charset="UTF-8";

            title {
                (self.title)
            }

            meta name="description" content="{{ config('other.meta_description') }}";
            meta http-equiv="X-UA-Compatible" content="IE=edge";
            meta name="viewport" content="width=device-width, initial-scale=1";
            meta name="_base_url" content="{{ route('home.index') }}";
            meta name="csrf-token" content="{{ csrf_token() }}";

            @if let Some(meta) = &self.meta {
                (meta)
            }

            link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon";
            link rel="icon" href="{{ url('/favicon.ico') }}" type="image/x-icon";

            @if let Some(standalone_css) = &self.from_db.user_settings.as_ref().and_then(|settings| settings.standalone_css.as_ref()) {
                link rel="stylesheet" href=(standalone_css);
            } @else {
                link rel="stylesheet" href="http://localhost:82/build/assets/main-LJ7cmKiP.css";

                @match &self.from_db.user_settings.as_ref().map(|settings| settings.style) {
                    Some(0..=15) => {
                        link rel="stylesheet" href="http://localhost:82/build/assets/_galactic-x23XoMgg.css";
                        link rel="stylesheet" href="http://localhost:82/build/assets/_dark-blue-4Z9uzC6Y.css";
                    },
                    _ => {
                        link rel="stylesheet" href="http://localhost:82/build/assets/_galactic-x23XoMgg.css";
                        link rel="stylesheet" href="http://localhost:82/build/assets/_dark-blue-4Z9uzC6Y.css";
                    }
                }

                @if let Some(custom_css) = &self.from_db.user_settings.as_ref().and_then(|settings| settings.custom_css.as_ref()) {
                    link rel="stylesheet" href=(custom_css);
                }
            }

            "@livewireStyles"

            @if let Some(stylesheets) = &self.stylesheets {
                (stylesheets)
            }
        }
    }
}
