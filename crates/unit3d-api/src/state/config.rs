use std::env;

use anyhow::{Context, Result};

#[derive(Clone)]
pub struct Config {
    /// The base url of the app.
    pub app_url: String,
}

impl Config {
    pub fn new() -> Result<Config> {
        let app_url: String = env::var("APP_URL").context("APP_URL not found in .env file.")?;

        Ok(Config { app_url })
    }
}
