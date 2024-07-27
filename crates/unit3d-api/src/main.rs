#![forbid(unsafe_code)]

mod database;
mod error;
mod features;
mod middleware;
mod routes;
mod state;

use anyhow::Context;
use axum::Router;
use state::AppState;
use tower::ServiceBuilder;
use tower_http::cors::{Any, CorsLayer};
use tracing_subscriber::{layer::SubscriberExt, util::SubscriberInitExt};

#[tokio::main]
async fn main() -> anyhow::Result<()> {
    _ = dotenvy::dotenv().context(".env file not found")?;

    // Configure logging
    tracing_subscriber::registry()
        .with(
            tracing_subscriber::EnvFilter::try_from_default_env()
                .unwrap_or_else(|_| "info,tower_http=debug,unit3d_api=debug".into()),
        )
        .with(tracing_subscriber::fmt::layer())
        .init();

    let state = AppState::new().await?;
    let listener = tokio::net::TcpListener::bind("0.0.0.0:3000").await.unwrap();
    let app = Router::new()
        .merge(routes::routes(state.clone()))
        .with_state(state)
        .into_make_service();

    axum::serve(listener, app).await.unwrap();

    Ok(())
}
