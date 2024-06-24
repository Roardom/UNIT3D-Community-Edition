use chrono::NaiveDateTime;
use maud::{html, Markup, Render};

pub struct DateTimeComponent(pub Option<NaiveDateTime>);

impl Render for DateTimeComponent {
    fn render(&self) -> Markup {
        html! {
            time datetime=[self.0] title=[self.0] {
                @if let Some(time) = self.0 {
                    (time)
                } @else {
                    "Unknown"
                }
            }
        }
    }
}
