// TODO: remove default impl

use serde::Serialize;

#[derive(Serialize)]
pub struct Collection<T> {
    pub data: Vec<T>,
    pub links: Links,
    pub meta: Meta,
}

#[derive(Serialize, Default)]
pub struct Links {
    pub first: Option<String>,
    pub last: Option<String>,
    pub prev: Option<String>,
    pub next: Option<String>,
    #[serde(rename = "self")]
    pub _self: String,
}

#[derive(Serialize, Default)]
pub struct Meta {
    pub current_page: u32,
    pub from: u32,
    pub last_page: u32,
    pub links: Vec<Link>,
}

#[derive(Serialize, Default)]
pub struct Link {
    pub url: Option<String>,
    pub label: String,
    pub active: bool,
}
