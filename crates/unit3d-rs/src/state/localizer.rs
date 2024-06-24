use anyhow::{Context, Result};

use axum::extract::{FromRef, FromRequestParts};
use http::request::Parts;
use http::StatusCode;
use include_dir::{include_dir, Dir};
use std::{borrow::Cow, collections::HashMap, sync::Arc};

use unic_langid::{langid, LanguageIdentifier};

static LANG_FILES: Dir<'_> = include_dir!("$CARGO_MANIFEST_DIR/i18n");

use fluent::{concurrent::FluentBundle, FluentArgs, FluentResource, FluentValue};

// TODO Remove Arc's
#[derive(Clone)]
pub struct Localizer(Arc<HashMap<LanguageIdentifier, Translations>>);

#[derive(Clone)]
pub struct Translations(Arc<FluentBundle<FluentResource>>);

impl Translations {
    pub fn get(&self, key: &str) -> Cow<str> {
        // TODO: Better handle these checks;
        if let Some(msg) = self.0.get_message(key) {
            let mut errors = vec![];

            let pattern = msg.value().expect("No translation message found.");

            return self.0.format_pattern(pattern, None, &mut errors);
        }

        "No translation message found".into()
    }
}

impl Localizer {
    pub fn new() -> anyhow::Result<Self> {
        let mut locales = HashMap::new();

        for directory in LANG_FILES.dirs() {
            let langid = directory
                .path()
                .file_name()
                .context("File not found")?
                .to_str()
                .context("Invalid file name.")?
                .parse::<LanguageIdentifier>()
                .context("Invalid language indentifier.")?;
            let mut bundle = FluentBundle::new_concurrent(vec![langid.clone()]);

            for file in directory.files() {
                let ftl_string = file.contents_utf8().expect("FTL file must be UTF-8.");
                let resource = FluentResource::try_new(ftl_string.to_string())
                    .expect("Could not parse an FTL string.");
                bundle.add_resource(resource);
            }

            locales.insert(langid, Translations(Arc::new(bundle)));
        }

        Ok(Self(Arc::new(locales)))
    }

    fn translations(&self, locale: LanguageIdentifier) -> &Translations {
        let fallback_langid = "en"
            .parse::<LanguageIdentifier>()
            .expect("english fallback should always exist.");

        self.0
            .get(&locale)
            .unwrap_or(self.0.get(&fallback_langid).unwrap())
    }
}

pub struct Locale(pub Translations);

// pub struct LocaleLookup(LanguageIdentifier);

#[async_trait::async_trait]
impl<S> FromRequestParts<S> for Locale
where
    S: Send + Sync,
    Localizer: FromRef<S>,
{
    type Rejection = (StatusCode, String);

    async fn from_request_parts(_parts: &mut Parts, state: &S) -> Result<Self, Self::Rejection> {
        let localizer = Localizer::from_ref(state);

        let fallback_langid = "en"
            .parse::<LanguageIdentifier>()
            .expect("english fallback should always exist.");

        // TODO: extract locale from requests instead of using fallback locale
        let translations = localizer.translations(fallback_langid);

        Ok(Locale(translations.to_owned()))
    }
}
