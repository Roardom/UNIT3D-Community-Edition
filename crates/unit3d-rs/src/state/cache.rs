use std::time::Duration;

use moka::future::CacheBuilder;

// use crate::models;

#[derive(Clone, derive_more::Deref)]
pub struct Cache(moka::future::Cache<CacheKey, CacheValue>);

impl Cache {
    pub fn new() -> Self {
        Cache(
            CacheBuilder::new(10_000)
                .time_to_live(Duration::from_secs(3600))
                .build(),
        )
    }
}

#[derive(Eq, Hash, PartialEq)]
pub enum CacheKey {
    // Page(i32),
}

#[derive(Clone, derive_more::TryInto, derive_more::From)]
pub enum CacheValue {
    // Page(models::Page),
}
