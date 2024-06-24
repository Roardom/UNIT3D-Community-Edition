use std::convert::Infallible;

mod child;
mod footer;
mod header;

use anyhow::Context;
use axum::{
    extract::{Request, State},
    middleware::Next,
    response::{Html, IntoResponse, IntoResponseParts, Response, ResponseParts},
};
use footer::Footer;
use header::Header;
use http::header::CONTENT_LENGTH;
use maud::{html, Markup, Render, DOCTYPE};

use crate::state::db_pool::{DatabaseConnection, DbConn};

#[derive(Clone)]
struct DefaultLayout {
    child: DefaultLayoutChild,
    base: DefaultLayoutBase,
}

impl DefaultLayout {
    async fn new(
        conn: &mut DbConn,
        child: DefaultLayoutChild,
        user_id: u32,
    ) -> anyhow::Result<Self> {
        Ok(Self {
            child,
            base: DefaultLayoutBase::from_db(conn, user_id).await?,
        })
    }
}

pub async fn wrap_in_layout(
    DatabaseConnection(mut conn): DatabaseConnection,
    request: Request,
    next: Next,
) -> Response {
    let mut response = next.run(request).await;

    // TODO: Extract token from cookies
    let user_id = 3;

    if let Some(child) = response.extensions_mut().remove::<DefaultLayoutChild>() {
        let with_layout = DefaultLayout::new(&mut conn, child, user_id)
            .await
            .context("Hopefully no db errors. This might happen.")
            .unwrap()
            .render()
            .into_string();

        let new_body = Html(with_layout);

        let (mut parts, _) = response.into_parts();

        parts.headers.remove(CONTENT_LENGTH);

        (parts, new_body).into_response()
    } else {
        response
    }
}

#[derive(Clone)]
pub struct DefaultLayoutChild {
    pub title: String,
    pub meta: Option<Markup>,
    pub stylesheets: Option<Markup>,
    pub main: Markup,
    pub sidebar: Option<Markup>,
    pub page_id: String,
}

impl IntoResponseParts for DefaultLayoutChild {
    type Error = Infallible;

    fn into_response_parts(self, mut res: ResponseParts) -> Result<ResponseParts, Self::Error> {
        res.extensions_mut().insert(self);

        Ok(res)
    }
}

impl IntoResponse for DefaultLayoutChild {
    fn into_response(self) -> Response {
        (self, ()).into_response()
    }
}

#[derive(Clone)]
pub struct DefaultLayoutBase {
    header: Header,
    footer: Footer,
}

impl DefaultLayoutBase {
    pub async fn from_db(conn: &mut DbConn, user_id: u32) -> anyhow::Result<Self> {
        Ok(Self {
            header: Header::new(conn, user_id).await?,
            footer: Footer::from_db(conn).await?,
        })
    }
}

impl Render for DefaultLayout {
    fn render(&self) -> Markup {
        html! {
            (DOCTYPE)
            html lang="en" {
                head {
                    (self.base.header)
                }
                body {
                    .alerts {
                        "@if (config('other.freeleech') == true || config('other.invite-only') == false || config('other.doubleup') == true)"
                            section .alert.special-event-alert x-data="timer()" x-init="start()" {
                                .alert__content {
                                    span {
                                        " @if (config('other.freeleech') == true)"
                                                "🌐 {{ __('common.freeleech_activated') }} 🌐"
                                        " @endif"

                                        " @if (config('other.invite-only') == false)"
                                            "🌐 {{ __('common.openreg_activated') }} 🌐"
                                        " @endif"

                                        " @if (config('other.doubleup') == true)"
                                                "🌐 {{ __('common.doubleup_activated') }} 🌐"
                                        " @endif"
                                    }
                                    div {
                                        span x-text="days" { "00" }
                                        span { "{{ __('common.day') }}" }
                                        span x-text="hours" { "00" }
                                        span { "{{ __('common.hour') }}" }
                                        span x-text="minutes" { "00" }
                                        span { "{{ __('common.minute') }}" }
                                        span { "{{ __('common.and') }}" }
                                        span x-text="seconds" { "00" }
                                        span { "{{ __('common.second') }}" }
                                    }
                                }
                            }
                        "@endif"
                    }
                    header {
                        "insert top nav here"
                        nav.secondary-nav {
                            ol.breadcrumbsV2 {
                                li.breadcrumbV2 {
                                    a.breadcrumb__link href="/" {
                                        i."fas fa-home" {}
                                    }
                                }
                                "insert breadcrumbs here"
                            }
                            ul.nav-tabsV2 {
                                "insert nav tabs here"
                            }
                        }
                        #ERROR_COPY style="display: none" {
                            "insert errors here"
                        }
                    }
                    main class=(self.child.page_id) {
                        @if let Some(sidebar) = &self.child.sidebar {
                            article.sidebar2 {
                                div {
                                    (self.child.main)
                                }
                                aside {
                                    (sidebar)
                                }
                            }
                        } @else {
                            (self.child.main)
                        }
                    }
                    (self.base.footer)
                    "insert all js stuff here"
                }
            }
        }
    }
}
