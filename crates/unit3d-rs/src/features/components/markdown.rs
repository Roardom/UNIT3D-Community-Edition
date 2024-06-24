use ammonia;
use maud::{Markup, PreEscaped, Render};
use pulldown_cmark::{html, Parser};

/// Renders a block of Markdown using `pulldown-cmark`.
pub struct Markdown<T>(pub T);

impl<T: AsRef<str>> Render for Markdown<T> {
    fn render(&self) -> Markup {
        // Generate raw HTML
        let mut unsafe_html = String::new();
        let parser = Parser::new(self.0.as_ref());
        html::push_html(&mut unsafe_html, parser);

        // Sanitize it with ammonia
        let safe_html = ammonia::clean(&unsafe_html);

        PreEscaped(safe_html)
    }
}
