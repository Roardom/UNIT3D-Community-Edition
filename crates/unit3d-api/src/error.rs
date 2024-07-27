// use axum::response::{ErrorResponse, IntoResponse};
// use http::StatusCode;

// /// Utility function for mapping any error into a `500 Internal Server Error`
// /// response.
// fn internal_error<E>(err: E) -> ErrorResponse
// where
//     E: std::error::Error,
// {
//     (StatusCode::INTERNAL_SERVER_ERROR, err.to_string()).into_response()
// }

use axum::{
    http::StatusCode,
    response::{IntoResponse, Response},
};

#[derive(thiserror::Error, Debug)]
pub enum Error {
    #[error("Database error.")]
    DieselError(#[from] diesel::result::Error),
    #[error("Pool error.")]
    PoolError(#[from] diesel_async::pooled_connection::deadpool::PoolError),
}

impl IntoResponse for Error {
    fn into_response(self) -> Response {
        match self {
            Self::DieselError(err) => (StatusCode::INTERNAL_SERVER_ERROR, err.to_string()),
            Self::PoolError(err) => (StatusCode::INTERNAL_SERVER_ERROR, err.to_string()),
        }
        .into_response()
    }
}
