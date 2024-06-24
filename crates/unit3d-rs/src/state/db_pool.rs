use anyhow::{Context, Result};

use axum::extract::{FromRef, FromRequestParts};
use diesel_async::pooled_connection::deadpool::{Object, Pool};
use diesel_async::pooled_connection::AsyncDieselConnectionManager;
use diesel_async::AsyncMysqlConnection;
use http::request::Parts;
use http::StatusCode;

pub type DbConn = Object<AsyncMysqlConnection>;

#[derive(Clone)]
pub struct DatabasePool(Pool<AsyncMysqlConnection>);

impl DatabasePool {
    pub fn new() -> Result<Self> {
        let db_url =
            std::env::var("DATABASE_URL").context("Could not retrieve database URL from .env")?;

        // create a new connection pool with the default config
        let config = AsyncDieselConnectionManager::<AsyncMysqlConnection>::new(db_url);
        let pool = Pool::builder(config)
            .max_size(32)
            .build()
            .context("Could not build the database connection pool")?;

        Ok(Self(pool))
    }
}

pub struct DatabaseConnection(pub Object<AsyncMysqlConnection>);

#[async_trait::async_trait]
impl<S> FromRequestParts<S> for DatabaseConnection
where
    S: Send + Sync,
    DatabasePool: FromRef<S>,
{
    type Rejection = (StatusCode, String);

    async fn from_request_parts(_parts: &mut Parts, state: &S) -> Result<Self, Self::Rejection> {
        let pool = DatabasePool::from_ref(state);

        let conn = pool.0.get().await.map_err(internal_error)?;

        Ok(Self(conn))
    }
}

/// Utility function for mapping any error into a `500 Internal Server Error`
/// response.
pub fn internal_error<E>(err: E) -> (StatusCode, String)
where
    E: std::error::Error,
{
    (StatusCode::INTERNAL_SERVER_ERROR, err.to_string())
}
