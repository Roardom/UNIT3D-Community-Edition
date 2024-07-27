use crate::{features::torrents, middleware::authenticate, state::AppState};
use axum::{
    middleware::{from_fn, from_fn_with_state},
    routing::get,
    Router,
};
use axum_extra::routing::RouterExt;

pub fn routes(state: AppState) -> Router<AppState> {
    Router::new()
        .merge(public_routes())
        .merge(authenticated_routes(state))
}

fn public_routes() -> Router<AppState> {
    Router::new().route("/ping", get(|| async { "pong" }))
}

fn authenticated_routes(state: AppState) -> Router<AppState> {
    Router::new()
        .typed_get(torrents::filter)
        .layer(from_fn_with_state(state.clone(), authenticate::handle))
}
