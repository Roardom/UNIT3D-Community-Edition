use std::convert::Infallible;

use axum::response::{IntoResponse, IntoResponseParts, Response, ResponseParts};
use maud::Markup;

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
