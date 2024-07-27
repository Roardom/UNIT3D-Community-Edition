use axum::extract::FromRef;

pub mod config;
pub mod database_pool;

use config::Config;
use database_pool::DatabasePool;

#[derive(Clone, FromRef)]
pub struct AppState {
    pub config: Config,
    /// Database connection pool
    pub db: DatabasePool,
}

impl AppState {
    pub async fn new() -> anyhow::Result<Self> {
        Ok(AppState {
            config: Config::new()?,
            db: DatabasePool::new()?,
        })
    }
}
