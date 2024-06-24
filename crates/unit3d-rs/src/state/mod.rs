use axum::extract::FromRef;

mod cache;
pub mod db_pool;
pub mod localizer;

use cache::Cache;
use db_pool::DatabasePool;
use localizer::Localizer;

#[derive(Clone, FromRef)]
pub struct AppState {
    /// Database connection pool
    pub db: DatabasePool,
    /// Concurrent cache
    pub cache: Cache,
    /// Localization
    pub locales: Localizer,
}

impl AppState {
    pub async fn new() -> anyhow::Result<Self> {
        Ok(AppState {
            db: DatabasePool::new()?,
            cache: Cache::new(),
            locales: Localizer::new()?,
        })
    }
}
