use crate::features::components::{DateTimeComponent, Markdown};
use crate::features::layout::DefaultLayoutChild;
use crate::state::localizer::{Locale, Translations};
use crate::{database::schema::pages, state::db_pool::DatabaseConnection};
use axum_extra::routing::TypedPath;
use maud::html;
use serde::Deserialize;

use crate::database::models::Page;

#[derive(TypedPath, Deserialize)]
#[typed_path("/pages/:id")]
pub struct PageShowPath {
    id: i32,
}

pub async fn show(
    PageShowPath { id }: PageShowPath,
    DatabaseConnection(mut conn): DatabaseConnection,
    Locale(translations): Locale,
) -> DefaultLayoutChild {
    use diesel::prelude::*;
    use diesel_async::RunQueryDsl;

    PageShowTemplate {
        translations,
        page: pages::table.find(id).first(&mut conn).await.unwrap(),
    }
    .into()
}

pub struct PageShowTemplate {
    translations: Translations,
    page: Page,
}

impl Into<DefaultLayoutChild> for PageShowTemplate {
    fn into(self) -> DefaultLayoutChild {
        DefaultLayoutChild {
            title: "test".to_string(),
            meta: None,
            stylesheets: None,
            main: html! {
                section.panelV2 {
                    h2.panel__heading {
                        (self.page.name.unwrap_or("(No title)".to_string()))
                    }
                    div {
                        (self.translations.get("hello-world"))
                    }
                    div.panel__body.bbcode-rendered {
                        (Markdown(self.page.content.unwrap_or_default()))
                    }
                }
            },
            sidebar: Some(html! {
                section.panelV2 {
                    h2.panel__heading {
                        "info"
                    }
                    dl.key-value {
                        .key-value__group {
                            dt {
                                "Created at"
                            }
                            dd {
                                (DateTimeComponent(self.page.created_at))
                            }
                        }
                        .key-value__group {
                            dt {
                                "Updated at"
                            }
                            dd {
                                time datetime=(self.page.updated_at.unwrap()) title=(self.page.updated_at.unwrap()) {
                                    (self.page.updated_at.unwrap())
                                }
                            }
                        }
                    }
                }
            }),
            page_id: "page--show".to_string(),
        }
    }
}
