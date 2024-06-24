use maud::{html, Render};

use crate::{
    database::{models::Page, schema::pages},
    state::{db_pool::DbConn, AppState},
};

#[derive(Clone)]
pub struct Footer {
    pages: Vec<Page>,
}

impl Footer {
    pub async fn from_db(mut conn: &mut DbConn) -> anyhow::Result<Self> {
        use diesel::prelude::*;
        use diesel_async::RunQueryDsl;

        Ok(Self {
            pages: pages::table
                .select(Page::as_select())
                .load(&mut conn)
                .await?,
        })
    }
}

impl Render for Footer {
    fn render(&self) -> maud::Markup {
        html! {
            footer.footer {
                .footer__wrapper {
                    section.footer__section {
                        h2.footer__section-title {
                            b {
                                "{{ config('other.title') }}"
                            }
                        }
                        p {
                            "{{ config('other.meta_description') }}"
                        }
                        p.footer__icons {
                            "@if (! empty(config('unit3d.chat-link-url')))"
                                a href="{{ config('unit3d.chat-link-url') }}" {
                                    i class="{{ config('unit3d.chat-link-icon') }}" {}
                                    "{{ config('unit3d.chat-link-name') ?: __('common.chat') }}"
                                }
                            "@endif"
                        }
                    }
                    section.footer__section {
                        h2 class="footer__section-title" {
                            "{{ __('common.account') }}"
                        }
                        ul class="footer__section-list" {
                            li {
                                a href="{{ route('users.show', ['user' => auth()->user()]) }}" {
                                    "{{ __('user.my-profile') }}"
                                }
                            }
                            li {
                                form action="{{ route('logout') }}" method="POST" style="display: contents" {
                                    "@csrf"
                                    button style="display: contents" {
                                        "{{ __('common.logout') }}"
                                    }
                                }
                            }
                        }
                    }
                    section.footer__section {
                        h2 class="footer__section-title" {
                            "{{ __('common.community') }}"
                        }
                        ul class="footer__section-list" {
                            li {
                                a href="{{ route('forums.index') }}" {
                                    "{{ __('forum.forums') }}"
                                }
                            }
                            li {
                                a href="{{ route('articles.index') }}" {
                                    "{{ __('common.news') }}"
                                }
                            }
                            li {
                                a href="{{ route('wikis.index') }}" {
                                    "Wikis"
                                }
                            }
                        }
                    }
                    @if !&self.pages.is_empty() {
                        section.footer__section {
                            h2 class="footer__section-title" {
                                "{{ __('common.pages') }}"
                            }
                            ul class="footer__section-list" {
                                @for page in &self.pages {
                                    @if let Some(name) = &page.name {
                                        li {
                                            a href="{{ route('pages.show', ['page' => $page]) }}" {
                                                (name)
                                            }
                                        }
                                    }
                                }

                                li {
                                    a href="{{ route('pages.index') }}" {
                                        "[View All]"
                                    }
                                }
                            }
                        }
                    }

                    section.footer__section {
                        h2.footer__section-title {
                            "{{ __('common.info') }}"
                        }
                        ul.footer__section-list {
                            li {
                                a href="{{ route('staff') }}" {
                                    "{{ __('common.staff') }}"
                                }
                            }
                            li {
                                a href="{{ route('internal') }}" {
                                    "{{ __('common.internal') }}"
                                }
                            }
                            li {
                                a href="{{ route('client_blacklist') }}" {
                                    "{{ __('common.blacklist') }}"
                                }
                            }
                            li {
                                a href="{{ route('about') }}" {
                                    "{{ __('common.about') }}"
                                }
                            }
                            li {
                                a href="https://github.com/HDInnovations/UNIT3D-Community-Edition/wiki/Torrent-API-(UNIT3D-v8.x.x)" {
                                    "API Documentation"
                                }
                            }
                        }
                    }
                }
                .footer__sub-footer {
                    p.footer__icons {
                        "Built using:"
                        a href="https://laravel.com" target="_blank" {
                            "icon"
                        }
                        a href="https://livewire.laravel.com" target="_blank" {
                            "icon"
                        }
                        a href="https://alpinejs.dev" target="_blank" {
                            "icon"
                        }
                        a href="https://rust-lang.org" target="_blank" {
                            "icon"
                        }
                    }
                    p.footer__stats {
                        strong {
                            "Time:"
                        }
                        span {
                            "{{ number_format((microtime(true) - (defined('LARAVEL_START') ? LARAVEL_START : request()->server('REQUEST_TIME_FLOAT'))) * 1000, 5) }}"
                            "ms"
                        }
                        strong {
                            "Used:"
                        }
                        span {
                            "{{ number_format(memory_get_peak_usage(true) / 1024 / 1024, 2) }} MiB"
                        }
                        strong { "Load:" }
                        span {
                            "{{ implode(' ', array_map(fn ($n) => number_format($n, 2), sys_getloadavg())) }}"
                        }
                        strong { "Date:" }
                        span {
                            "now()"
                        }
                    }
                    p.footer__copyright {
                        "Site and design &copy;"
                        "{{ date('Y', strtotime(config('other.birthdate'))) }}-{{ date('Y') }}"
                        "{{ config('other.title') }} | "
                        a href="https://github.com/HDInnovations/UNIT3D-Community-Edition" {
                            "UNIT3D"
                        }
                        "@if (config('announce.external_tracker.is_enabled'))"
                            "+"
                            a href="https://github.com/HDInnovations/UNIT3D-Announce" {
                                "UNIT3D-Announce"
                            }
                        "@endif"
                    }
                }
            }

        }
    }
}
