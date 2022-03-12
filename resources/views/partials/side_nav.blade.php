<nav>
    <ul>
        <li>{{ __('common.navigation') }}</li>
        <li>
            <a href="{{ route('home.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-home" style=" font-size: 18px; color: #ffffff;"></i>
                {{ __('common.home') }}
            </a>
        </li>
        <li>
            <a>
                <i class="{{ config('other.font-awesome') }} fa-download" style=" font-size: 18px; color: #ffffff;"></i>
                {{ __('torrent.torrents') }}
            </a>
            <ul>
                <li>
                    <a href="{{ route('torrents') }}">
                        {{ __('torrent.torrents') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('requests.index') }}">
                        {{ __('request.requests') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('mediahub.index') }}">
                        MediaHub
                    </a>
                </li>
                <li>
                    <a href="{{ route('subtitles.index') }}">
                        {{ __('common.subtitles') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('graveyard.index') }}">
                        {{ __('graveyard.graveyard') }}
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('upload_form', ['category_id' => App\Models\Category::first()->id]) }}">
                <i class="{{ config('other.font-awesome') }} fa-upload" style=" font-size: 18px; color: #ffffff;"></i>
                {{ __('common.publish') }}
            </a>
        </li>
        <li>
            <a>
                <i class="{{ config('other.font-awesome') }} fa-user" style=" font-size: 18px; color: #ffffff;"></i>
                {{ __('common.other') }}
            </a>
            <ul>

                <li>
                    <a href="{{ route('playlists.index') }}">
                        {{ __('playlist.playlists') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('stats') }}">
                        {{ __('common.extra-stats') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('polls') }}">
                        {{ __('poll.polls') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('forums.index') }}">
                        {{ __('forum.forums') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('rss.index') }}">
                        {{ __('rss.rss') }}
                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{ config('other.rules_url') }}">
                <i class="{{ config('other.font-awesome') }} fa-info-square"></i>
                {{ __('common.rules') }}
            </a>
        </li>
        <li>
            <a href="{{ config('other.faq_url') }}">
                <i class="{{ config('other.font-awesome') }} fa-question-square"></i>
                {{ __('common.faq') }}
            </a>
        </li>
        @if (auth()->user()->group->is_modo)
            <li>
                <a href="{{ route('staff.dashboard.index') }}">
                    <i class="{{ config('other.font-awesome') }} fa-cogs"></i>
                    {{ __('staff.staff-dashboard') }}
                </a>
            </li>
        @endif
    </ul>
</nav>
