use std::ops::Deref;

use anyhow::Context;

use axum::response::{IntoResponse, Response};
use diesel_async::pooled_connection::deadpool::{self, Object, Pool};
use diesel_async::pooled_connection::AsyncDieselConnectionManager;
use diesel_async::AsyncMysqlConnection;

use crate::error::Error;

pub type DbConn = Object<AsyncMysqlConnection>;

#[derive(Clone)]
pub struct DatabasePool(Pool<AsyncMysqlConnection>);

impl DatabasePool {
    pub fn new() -> anyhow::Result<Self> {
        let db_url =
            std::env::var("DATABASE_URL").context("Could not retrieve database URL from .env")?;

        // create a new connection pool with the default config
        let config = AsyncDieselConnectionManager::<AsyncMysqlConnection>::new(db_url);
        let pool = Pool::builder(config)
            .max_size(64)
            .build()
            .context("Could not build the database connection pool")?;

        Ok(Self(pool))
    }

    pub async fn get_conn(&self) -> Result<DbConn, Error> {
        self.0.get().await.map_err(|e| Error::PoolError(e))
    }
}

impl Deref for DatabasePool {
    type Target = Pool<AsyncMysqlConnection>;

    fn deref(&self) -> &Self::Target {
        &self.0
    }
}
