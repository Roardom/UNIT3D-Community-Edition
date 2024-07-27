use axum::{
    extract::{Request, State},
    middleware::Next,
    response::Response,
};

use crate::state::AppState;

pub async fn handle(State(state): State<AppState>, request: Request, next: Next) -> Response {
    let response = next.run(request).await;

    response
}
