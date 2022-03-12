@extends('layout.default')

@section('title')
    <title>{{ $user->username }} - {{ __('common.members') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description"
          content="{{ __('user.profile-desc', ['user' => $user->username, 'title' => config('other.title')]) }}">
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', [ 'username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
            <x-nav.tab href="{{ route('torrents') }}?bookmarked=1">
                {{ __('user.bookmarks') }}
            </x-nav.tab>
            <x-nav.tab href="{{ route('wishes.index', ['username' => $user->username]) }}">
                {{ __('user.wishlist') }}
            </x-nav.tab>
            <x-nav.tab href="{{ route('seedboxes.index', ['username' => $user->username]) }}">
                {{ __('user.seedboxes') }}
            </x-nav.tab>
        @endif
        <x-slot name="right">
            @if(auth()->user()->id == $user->id)
                <x-nav.tab href="{{ route('user_settings', ['username' => $user->username]) }}">
                    {{ __('user.settings') }}
                </x-nav.tab>
                <x-nav.tab href="{{ route('user_edit_profile_form', ['username' => $user->username]) }}">
                    {{ __('user.edit-profile') }}
                </x-nav.tab>
            @else
                <x-nav.tab>
                    @if (auth()->user()->isFollowing($user->id))
                        <form action="{{ route('follow.destroy', ['username' => $user->username]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="delete-follow-{{ $user->target_id }}">
                                <i class="{{ config('other.font-awesome') }} fa-user"></i>
                                {{ __('user.unfollow') }}
                            </button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', ['username' => $user->username]) }}" method="POST">
                            @csrf
                            <button type="submit" id="follow-user-{{ $user->id }}">
                                <i class="{{ config('other.font-awesome') }} fa-user"></i>
                                {{ __('user.follow') }}
                            </button>
                        </form>
                    @endif
                </x-nav.tab>
                <x-nav.tab data-toggle="modal" data-target="#modal_user_report">
                    <i class="{{ config('other.font-awesome') }} fa-eye"></i>
                    {{ __('user.report') }}
                </x-nav.tab>
            @endif
        </x-slot>
    </x-nav>
@endsection

@section('content')
    @if (!auth()->user()->isAllowed($user))
        <x-panel :padded="true" :heading="__('user.private-profile')">
            {{ __('user.not-authorized') }}
        </x-panel>
    @else
        @if (auth()->user()->isAllowed($user,'profile','show_profile_badge'))
            <x-panel :padded="true">
                <x-slot name="heading">
                    <i class="{{ config('other.font-awesome') }} fa-badge"></i>
                    {{ __('user.badges') }}
                </x-slot>
                    @if (
                        $user->getSeeding() >= '150'
                        || $history->where('actual_downloaded', '>', 0)->count() >= '100'
                        || $user->seedbonus >= 50_000
                    )
                        @if ($user->getSeeding() >= '150')
                            <span class="chip" title="{{ __('user.certified-seeder-desc') }}">
                                <i class="{{ config('other.font-awesome') }} fa-upload"></i>
                                {{ __('user.certified-seeder') }}!
                            </span>
                        @endif
                        @if ($history->where('actual_downloaded', '>', 0)->count() >= '100')
                            <span class="chip" title="{{ __('user.certified-downloader-desc') }}">
                                <i class="{{ config('other.font-awesome') }} fa-download"></i>
                                {{ __('user.certified-downloader') }}!
                            </span>
                        @endif
                        @if ($user->seedbonus >= 50_000)
                            <span class="chip" title="{{ __('user.certified-banker-desc') }}">
                                <i class="{{ config('other.font-awesome') }} fa-coins"></i>
                                {{ __('user.certified-banker') }}!
                            </span>
                        @endif
                    @else
                        No badges
                    @endif
            </x-panel>
        @endif
        @if (auth()->user()->isAllowed($user,'profile','show_profile_achievement'))
            <x-panel :padded="true">
                <x-slot name="heading">
                    @if (auth()->user()->isAllowed($user,'achievement','show_achievement'))
                        @if(auth()->user()->id == $user->id)
                            <a href="{{ route('achievements.index') }}">
                                <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                                {{ __('user.achievements') }}
                            </a>
                        @else
                            <a href="{{ route('achievements.show', ['username' => $user->username]) }}">
                                <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                                {{ __('user.achievements') }}
                            </a>
                        @endif
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-trophy"></i>
                        {{ __('user.achievements') }}
                    @endif
                </x-slot>
                @forelse ($user->unlockedAchievements()->take(25) as $achievement)
                    <img
                        src="/img/badges/{{ $achievement->details->name }}.png"
                        style="height: 50px;"
                        title="{{ $achievement->details->name }}"
                        alt="{{ $achievement->details->name }}"
                    >
                @empty
                    No achievements
                @endforelse
            </x-panel>
        @endif
        @if (auth()->user()->isAllowed($user,'profile','show_profile_follower'))
            <x-panel :padded="true">
                <x-slot name="heading">
                    @if (auth()->user()->isAllowed($user,'follower','show_follower'))
                        <a href="{{ route('user_followers', ['username' => $user->username]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-users"></i>
                            {{ __('user.followers') }}
                        </a>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-users"></i>
                        {{ __('user.followers') }}
                    @endif
                </x-slot>
                    @forelse ($followers as $follower)
                        <a href="{{ route('users.show', ['username' => $follower->user->username]) }}">
                            <img
                                src="{{ url($follower->user->image ? 'files/img/'.$follower->user->image : 'img/profile.png') }}"
                                title="{{ $follower->user->username }}"
                                style="height: 50px;"
                                alt="{{ $follower->user->username }}: {{ __('user.avatar') }}"
                            >
                        </a>
                    @empty
                        No followers
                    @endforelse
            </x-panel>
        @endif
        @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
            <x-panel>
                <x-slot name="heading">
                    <i class="{{ config('other.font-awesome') }} fa-broadcast-tower"></i>
                    {{ __('user.client-list') }}
                </x-slot>
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>{{ __('torrent.client') }}</th>
                        <th>{{ __('common.ip') }}</th>
                        <th>{{ __('common.port') }}</th>
                        <th>{{ __('torrent.started') }}</th>
                        <th>{{ __('torrent.last-update') }}</th>
                        <th>{{ __('torrent.torrents') }}</th>
                        @if (\config('announce.connectable_check') == true)
                            <th>Connectable</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @php $peer_array = []; @endphp
                    @foreach ($peers as $peer)
                        @if (!in_array([$peer->ip, $peer->port], $peer_array))
                            @php
                                $count = App\Models\Peer::where('user_id', '=', $user->id)
                                    ->where('ip', '=', $peer->ip)
                                    ->where('port', '=', $peer->port)
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $peer->agent }}</td>
                                <td>{{ $peer->ip }}</td>
                                <td>{{ $peer->port }}</td>
                                <td>{{ $peer->created_at ? $peer->created_at->diffForHumans() : 'N/A' }}</td>
                                <td>{{ $peer->updated_at ? $peer->updated_at->diffForHumans() : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('user_active_by_client', ['username' => $user->username, 'ip' => $peer->ip, 'port' => $peer->port]) }}">
                                        {{ $count }}
                                    </a>
                                </td>
                                @if (\config('announce.connectable_check') == true)
                                    @php
                                        $connectable = false;
                                        if (cache()->has('peers:connectable:'.$peer->ip.'-'.$peer->port.'-'.$peer->agent)) {
                                            $connectable = cache()->get('peers:connectable:'.$peer->ip.'-'.$peer->port.'-'.$peer->agent);
                                        }
                                    @endphp
                                    <td>@choice('user.client-connectable-state', $connectable)</td>
                                @endif
                            </tr>
                            @php $peer_array[] = [$peer->ip, $peer->port] @endphp
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </x-panel>
            <x-panel>
                <x-slot name="heading">
                    <i class="{{ config('other.font-awesome') }} fa-bell"></i>
                    Hit & Runs
                </x-slot>
                <table class="data-table">
                    <thead>
                        <th>{{ __('torrent.torrent') }}</th>
                        <th>{{ __('user.warned-on') }}</th>
                        <th>{{ __('user.expires-on') }}</th>
                        <th>{{ __('user.active') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($hitrun as $hr)
                            <tr>
                                <td>
                                    <a href="{{ route('torrent', ['id' => $hr->torrenttitle->id]) }}">
                                        {{ $hr->torrenttitle->name }}
                                    </a>
                                </td>
                                <td>{{ $hr->created_at }}</td>
                                <td>{{ $hr->expires_on }}</td>
                                <td>{{ $hr->active ? __('common.yes') : __('user.expired') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $hitrun->links() }}
            </x-panel>
        @endif
    @endif
    @include('user.user_modals', ['user' => $user])
@endsection

@section('sidebar')
    @if(auth()->user()->isAllowed($user))
        <x-panel>
            <x-slot name="heading">
                <x-chip.user
                    :anon="false"
                    :userId="$user->id"
                    :username="$user->username"
                    :href="route('users.show', ['username' => $user->username])"
                    :icon="$user->group->icon"
                    :color="$user->group->color"
                    :group="$user->group->name"
                    :effect="$user->group->effect"
                />
                @if ($user->isOnline())
                    <i
                        class="{{ config('other.font-awesome') }} fa-circle text-green"
                        title="{{ __('user.online') }}"
                    ></i>
                @else
                    <i
                        class="{{ config('other.font-awesome') }} fa-circle text-red"
                        title="{{ __('user.offline') }}"
                    ></i>
                @endif
                <a href="{{ route('create', ['receiver_id' => $user->id, 'username' => $user->username]) }}">
                    <i class="{{ config('other.font-awesome') }} fa-envelope text-info"></i>
                </a>
                <a
                    href="#modal_user_gift"
                    data-toggle="modal"
                    data-target="#modal_user_gift"
                >
                    <i class="{{ config('other.font-awesome') }} fa-gift text-info"></i>
                </a>
                @if ($user->getWarning() > 0)
                    <i
                        class="{{ config('other.font-awesome') }} fa-exclamation-circle text-orange"
                        title="{{ __('user.active-warning') }}"
                    ></i>
                @endif
                @if ($user->notes->count() > 0 && auth()->user()->group->is_modo)
                    <a href="{{ route('user_setting', ['username' => $user->username]) }}" class="edit">
                        <i
                            class="{{ config('other.font-awesome') }} fa-comment fa-beat text-danger"
                            title="{{ __('user.staff-noted') }}"
                        ></i>
                    </a>
                @endif
                @php $watched = App\Models\Watchlist::whereUserId($user->id)->first(); @endphp
                @if ($watched && auth()->user()->group->is_modo)
                    <i
                        class="{{ config('other.font-awesome') }} fa-eye fa-beat text-danger"
                        title="User is being watched!"
                    >
                    </i>
                @endif
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('user.avatar') }}</dt>
                <dd>
                    <img
                        src="{{ url($user->image ? 'files/img/'.$user->image : 'img/profile.png') }}"
                        alt="{{ $user->username }}: {{ __('user.avatar') }}"
                        class="img-circle"
                    >
                </dd>
                <dt>{{ __('user.registration-date') }}</dt>
                <dd>
                    <date datetime="{{ $user->created_at }}" title="{{ $user->created_at }}">
                        {{ $user->created_at === null ? "N/A" : date('M d Y', $user->created_at->getTimestamp()) }}
                    </date>
                </dd>
                @if (auth()->user()->isAllowed($user,'profile','show_profile_title'))
                    <dt>{{ __('user.title') }}</dt>
                    <dd>{{ $user->title }}</dd>
                @endif
                @if (auth()->user()->isAllowed($user,'profile','show_profile_about'))
                    <dt>{{ __('user.about') }}</dt>
                    <dd>@joypixels($user->getAboutHtml())</dd>
                @endif
            </dl>
        </x-panel>
    @endif
    @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
        <x-panel heading="{{ __('user.user') }}{{ __('common.actions') }}">
            <ul class="profile__user-actions">
                @if(auth()->user()->id == $user->id)
                    <li>
                        @if(auth()->user()->hidden)
                            <form method="POST" action="{{ route('user_visible', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-eye'></i>
                                    {{ __('user.become-visible') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('user_hidden', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-eye-slash'></i>
                                    {{ __('user.become-hidden') }}
                                </button>
                            </form>
                        @endif
                    </li>
                    <li>
                        @if(auth()->user()->private_profile)
                            <form method="POST" action="{{ route('user_public', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-lock-open'></i>
                                    {{ __('user.go-public') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('user_private', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-lock'></i>
                                    {{ __('user.go-private') }}
                                </button>
                            </form>
                        @endif
                    </li>
                    <li>
                        @if(auth()->user()->block_notifications)
                            <form method="POST" action="{{ route('notification_enable', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-bell'></i>
                                    {{ __('user.enable-notifications') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('notification_disable', ['username' => $user->username]) }}">
                                @csrf
                                <button type="submit">
                                    <i class='{{ config('other.font-awesome') }} fa-bell-slash'></i>
                                    {{ __('user.disable-notifications') }}
                                </button>
                            </form>
                        @endif
                    </li>
                @endif
                @if (auth()->user()->group->is_modo)
                    <li>
                        <button data-toggle="modal" data-target="#modal_warn_user">
                            <i class="{{ config('other.font-awesome') }} fa-radiation-alt"></i>
                            Warn User
                        </button>
                    </li>
                    <li>
                        <button data-toggle="modal" data-target="#modal_user_note">
                            <i class="{{ config('other.font-awesome') }} fa-sticky-note"></i>
                            {{ __('user.note') }}
                        </button>
                    </li>
                    @if(! $watched)
                        <li>
                            <button data-toggle="modal" data-target="#modal_user_watch">
                                <i class="{{ config('other.font-awesome') }} fa-eye"></i>
                                Watch
                            </button>
                        </li>
                    @else
                        <li>
                            <form
                                action="{{ route('staff.watchlist.destroy', ['id' => $watched->id]) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-warning" type="submit">
                                    <i class="{{ config('other.font-awesome') }} fa-eye-slash"></i>
                                    Unwatch
                                </button>
                            </form>
                        </li>
                    @endif
                    @if ($user->group->id == 5)
                        <li>
                            <button data-toggle="modal" data-target="#modal_user_unban">
                                <i class="{{ config('other.font-awesome') }} fa-undo"></i>
                                {{ __('user.unban') }}
                            </button>
                        </li>
                    @else
                        <li>
                            <button data-toggle="modal" data-target="#modal_user_ban">
                                <i class="{{ config('other.font-awesome') }} fa-ban"></i>
                                {{ __('user.ban') }}
                            </button>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('user_setting', ['username' => $user->username]) }}">
                            <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                            {{ __('user.edit') }}
                        </a>
                    </li>
                    <li>
                        <button data-toggle="modal" data-target="#modal_user_delete">
                            <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                            {{ __('user.delete') }}
                        </button>
                    </li>
                    <li>
                        <a href="{{ route('banlog', ['username' => $user->username]) }}">
                            {{ __('user.ban-log') }}
                        </a>
                    </li>
                @endif
            </ul>
        </x-panel>
    @endif
    @if (auth()->user()->isAllowed($user,'profile','show_profile_warning'))
        <x-panel heading="{{ __('common.warnings') }}">
            <x-slot name="heading">
                @if (auth()->user()->group->is_modo)
                    <a href="{{ route('warnings.show', ['username' => $user->username]) }}">
                        {{ __('common.warnings') }}
                    </a>
                @else
                    {{ __('common.warnings') }}
                @endif
            </x-slot>
                <dl class="key-value">
                    <dt>{{ __('user.active-warnings') }}</dt>
                    <dd>{{ $warnings->count() }} / {!! config('hitrun.max_warnings') !!}</dd>
                    <dt>{{ __('user.hit-n-runs-count') }}</dt>
                    @if ($user->hitandruns > 0)
                        <dd style="color: red">{{ $user->hitandruns }}</dd>
                    @else
                        <dd style="color: green">{{ $user->hitandruns }}</dd>
                    @endif
                </dl>
        </x-panel>
    @endif
    @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_count'))
        <x-panel>
            <x-slot name="heading">
                @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
                    <a href="{{ route('user_torrents', ['username' => $user->username]) }}">
                        {{ __('stat.total-torrents') }}
                    </a>
                    @if(!$user->group || !$user->group->is_immune)
                        <a href="{{ route('user_unsatisfieds', ['username' => $user->username]) }}" style="float: right">
                            {{ __('user.unsatisfieds') }}
                        </a>
                    @endif
                @else
                    {{ __('stat.total-torrents') }}
                @endif
            </x-slot>
            <dl class="key-value">
                <dt>
                    @if (auth()->user()->isAllowed($user,'torrent','show_upload'))
                        <a href="{{ route('user_uploads', ['username' => $user->username]) }}">
                            {{ __('user.total-uploads') }}
                        </a>
                    @else
                        {{ __('user.total-uploads') }}
                    @endif
                </dt>
                <dd>{{ $user->torrents_count }}</dd>
                <dt>
                    @if (auth()->user()->isAllowed($user,'torrent','show_download'))
                        <a href="{{ route('user_downloads', ['username' => $user->username]) }}">
                            {{ __('user.total-downloads') }}
                        </a>
                    @else
                        {{ __('user.total-downloads') }}
                    @endif
                </dt>
                <dd>{{ $history->where('actual_downloaded', '>', 0)->count() }}</dd>
                <dt>
                    @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
                        <a href="{{ route('user_active', ['username' => $user->username]) }}">
                            {{ __('user.total-seeding') }}
                        </a>
                    @else
                        {{ __('user.total-seeding') }}
                    @endif
                </dt>
                <dd>{{ $user->getSeeding() }}</dd>
                <dt>
                    @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
                        <a href="{{ route('user_active', ['username' => $user->username]) }}">
                            {{ __('user.total-leeching') }}
                        </a>
                    @else
                        {{ __('user.total-leeching') }}
                    @endif
                </dt>
                <dd>{{ $user->getLeeching() }}</dd>
            </dl>
        </x-panel>
    @endif
    @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_ratio'))
        <x-panel heading="{{ __('common.download') }} {{ __('torrent.statistics') }}" :condensible="true">
            <x-slot name="condensed">
                <dl class="key-value">
                    <dt>{{ $realdownload }}</dt>
                    <dd>
                        = {{ App\Helpers\StringHelper::formatBytes($def_download , 2) }}
                        + {{ App\Helpers\StringHelper::formatBytes($his_down , 2) }}
                        - {{ App\Helpers\StringHelper::formatBytes($free_down , 2) }}
                    </dd>
                </dl>
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('user.download-recorded') }}</dt>
                <dd>{{ $realdownload }}</dd>
                <dt>Default Starter Download</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($def_download , 2) }}</dd>
                <dt>{{ __('user.download-true') }}</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($his_down , 2) }}</dd>
                <dt>Freeleech Downloads</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($free_down , 2) }}</dd>
            </dl>
        </x-panel>
        <x-panel heading="{{ __('common.upload') }} {{ __('torrent.statistics') }}" :condensible="true">
            <x-slot name="condensed">
                <dl class="key-value">
                    <dt>{{ $user->getUploaded() }}</dt>
                    <dd>
                        = {{ App\Helpers\StringHelper::formatBytes($def_upload , 2) }}
                        + {{ App\Helpers\StringHelper::formatBytes($his_upl , 2) }}
                        + {{ App\Helpers\StringHelper::formatBytes($multi_upload , 2) }}
                        + {{ App\Helpers\StringHelper::formatBytes($bonupload , 2) }}
                        + {{ App\Helpers\StringHelper::formatBytes($man_upload , 2) }}
                    </dd>
                </dl>
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('user.upload-recorded') }}</dt>
                <dd>{{ $user->getUploaded() }}</dd>
                <dt>Default Starter Upload</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($def_upload , 2) }}</dd>
                <dt>{{ __('user.upload-true') }}</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($his_upl , 2) }}</dd>
                <dt>Upload from Multipliers</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($multi_upload , 2) }}</dd>
                <dt>{{ __('user.upload-bon') }}</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($bonupload , 2) }}</dd>
                <dt>Manually Added or Misc</dt>
                <dd>{{ App\Helpers\StringHelper::formatBytes($man_upload , 2) }}</dd>
            </dl>
        </x-panel>
    @endif
    @if (
        auth()->user()->isAllowed($user,'profile','show_profile_torrent_ratio')
        || auth()->user()->isAllowed($user,'profile','show_profile_torrent_seed')
    )
        <x-panel heading="Contribution">
            <dl class="key-value">
                @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_ratio'))
                    <dt>{{ __('common.ratio') }}</dt>
                    <dd>{{ $user->getRatioString() }}</dd>
                    <dt>{{ __('common.buffer') }}</dt>
                    <dd>{{ $user->untilRatio(config('other.ratio')) }}</dd>
                @endif
                @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_seed'))
                    <dt title="{{ __('user.all-torrents') }}">{{ __('user.total-seedtime') }}</dt>
                    <dd>{{ App\Helpers\StringHelper::timeElapsed($history->sum('seedtime')) }}</dd>
                    <dt title="{{ __('user.per-torrent') }}">{{ __('user.avg-seedtime') }}</dt>
                    <dd>{{ App\Helpers\StringHelper::timeElapsed(round($history->sum('seedtime') / max(1, $history->count()))) }}</dd>
                    <dt>{{ __('user.seeding-size') }}</dt>
                    <dd>{{ App\Helpers\StringHelper::formatBytes($user->getTotalSeedSize() , 2) }}</dd>
                @endif
            </dl>
        </x-panel>
    @endif
    @if (auth()->user()->isAllowed($user,'profile','show_profile_bon_extra'))
        <x-panel>
            <x-slot name="heading">
                @if(auth()->user()->id == $user->id)
                    <a href="{{ route('bonus') }}">{{ __('bon.bonus') }} {{ __('bon.points') }}</a>
                @else
                    {{ __('bon.bonus') }} {{ __('bon.points') }}
                @endif
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('bon.bon') }}</dt>
                <dd>{{ $user->getSeedbonus() }}</dd>
                <dt>{{ __('user.tips-received') }}</dt>
                <dd>{{ \number_format($user->bonReceived()->where('name', '=', 'tip')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('user.tips-given') }}</dt>
                <dd>{{ \number_format($user->bonGiven()->where('name', '=', 'tip')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('user.gift-received') }}</dt>
                <dd>{{ \number_format($user->bonReceived()->where('name', '=', 'gift')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('user.gift-given') }}</dt>
                <dd>{{ \number_format($user->bonGiven()->where('name', '=', 'gift')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('user.bounty-received') }}</dt>
                <dd>{{ \number_format($user->bonReceived()->where('name', '=', 'request')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('user.bounty-given') }}</dt>
                <dd>{{ \number_format($user->bonGiven()->where('name', '=', 'request')->sum('cost'), 0, '.', ' ') }}</dd>
                <dt>{{ __('common.fl_tokens') }}</dt>
                <dd>{{ $user->fl_tokens }}</dd>
            </dl>
        </x-panel>
    @endif
    @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_extra'))
        <x-panel>
            <x-slot name="heading">
                @if(auth()->user()->id == $user->id || auth()->user()->group->is_modo)
                    <a href="{{ route('user_resurrections', ['username' => $user->username]) }}">
                        {{ __('user.resurrections') }}
                    </a>
                @else
                    {{ __('user.resurrections') }}
                @endif
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('common.fl_tokens') }}</dt>
                <dd>{{ $user->fl_tokens }}</dd>
            </dl>
        </x-panel>
    @endif
    @if (
        auth()->user()->isAllowed($user,'profile','show_profile_comment_extra')
        || auth()->user()->isAllowed($user,'profile','show_profile_forum_extra')
        || auth()->user()->isAllowed($user,'profile','show_profile_torrent_extra')
        || auth()->user()->isAllowed($user,'profile','show_profile_request_extra')
    )
        <x-panel heading="{{ __('common.community') }} {{ __('forum.activity') }}">
            <dl class="key-value">
                @if (auth()->user()->isAllowed($user,'profile','show_profile_comment_extra'))
                    <dt>{{ __('user.article-comments') }}</dt>
                    <dd>{{ $user->comments()->where('article_id', '>', 0)->count() }}</dd>
                    <dt>{{ __('user.torrent-comments') }}</dt>
                    <dd>{{ $user->comments()->where('torrent_id', '>', 0)->count() }}</dd>
                    <dt>{{ __('user.request-comments') }}</dt>
                    <dd>{{ $user->comments()->where('requests_id', '>', 0)->count() }}</dd>
                @endif
                @if (auth()->user()->isAllowed($user,'profile','show_profile_forum_extra'))
                    <dt>
                        @if (auth()->user()->isAllowed($user,'forum','show_topic'))
                            <a href="{{ route('user_topics', ['username' => $user->username]) }}">
                                {{ __('user.topics-started') }}
                            </a>
                        @else
                            {{ __('user.topics-started') }}
                        @endif
                    </dt>
                    <dd>{{ $user->topics->count() }}</dd>
                    <dt>
                        @if (auth()->user()->isAllowed($user,'forum','show_post'))
                            <a href="{{ route('user_posts', ['username' => $user->username]) }}">
                                {{ __('user.posts-posted') }}
                            </a>
                        @else
                            {{ __('user.posts-posted') }}
                        @endif
                    </dt>
                    <dd>{{ $user->posts->count() }}</dd>
                @endif
                @if (auth()->user()->isAllowed($user,'profile','show_profile_torrent_extra'))
                    <dt>{{ __('user.thanks-received') }}</dt>
                    <dd>{{ $user->thanksReceived()->count() }}</dd>
                    <dt>{{ __('user.thanks-given') }}</dt>
                    <dd> {{ $user->thanksGiven()->count() }}</dd>
                @endif
                @if (auth()->user()->isAllowed($user,'profile','show_profile_request_extra'))
                    <dt>
                        @if (auth()->user()->isAllowed($user,'forum','show_requested'))
                            <a href="{{ route('user_requested', ['username' => $user->username]) }}">
                                {{ __('user.requested') }}
                            </a>
                        @else
                            {{ __('user.requested') }}
                        @endif
                    </dt>
                    <dd>{{ $requested }}</dd>
                    <dt>{{ __('user.filled-request') }}</dt>
                    <dd>{{ $filled }}</dd>
                @endif
            </dl>
        </x-panel>
    @endif
    @if (auth()->user()->id == $user->id || auth()->user()->group->is_modo)
        <x-panel>
            <x-slot name="heading">
                <i class="{{ config('other.font-awesome') }} fa-lock"></i>
                {{ __('user.private-info') }}
            </x-slot>
            <dl class="key-value">
                <dt>{{ __('user.invited-by') }}</dt>
                <dd>
                    @if ($invitedBy)
                        <x-chip.user
                            :anon="false"
                            :userId="$invitedBy->sender->id"
                            :username="$invitedBy->sender->username"
                            :href="route('users.show', ['username' => $invitedBy->sender->username])"
                            :icon="$invitedBy->sender->group->icon"
                            :color="$invitedBy->sender->group->color"
                            :group="$invitedBy->sender->group->name"
                            :effect="$invitedBy->sender->group->effect"
                        />
                    @else
                        {{ __('user.open-registration') }}
                    @endif
                </dd>
                <dt>{{ __('user.passkey') }}</dt>
                <dd>
                    <details>
                        <summary style="cursor: pointer">
                            <span>{{ __('user.show-passkey') }}</span>
                        </summary>
                        {{ $user->passkey }}
                        <span>{{ __('user.passkey-warning') }}</span>
                    </details>
                </dd>
                <dt>{{ __('user.user-id') }}</dt>
                <dd>{{ $user->id }}</dd>
                <dt>{{ __('common.email') }}</dt>
                <dd>{{ $user->email }}</dd>
                <dt>{{ __('user.last-login') }}</dt>
                <dd>
                    @if ($user->last_login != null)
                        {{ $user->last_login->toDayDateTimeString() }}<br>
                        ({{ $user->last_login->diffForHumans() }})
                    @else
                        N/A
                    @endif
                </dd>
                <dt>{{ __('user.can-upload') }}</dt>
                <dd>
                    @if ($user->can_upload == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red;"></i>
                    @endif
                </dd>
                <dt>{{ __('user.can-download') }}</dt>
                <dd>
                    @if ($user->can_download == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                    @endif
                </dd>
                <dt>{{ __('user.can-comment') }}</dt>
                <dd>
                    @if ($user->can_comment == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                    @endif
                </dd>
                <dt>{{ __('user.can-request') }}</dt>
                <dd>
                    @if ($user->can_request == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                    @endif
                </dd>
                <dt>{{ __('user.can-chat') }}</dt>
                <dd>
                    @if ($user->can_chat == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                    @endif
                </dd>
                <dt>{{ __('user.can-invite') }}</dt>
                <dd>
                    @if ($user->can_invite == 1)
                        <i class="{{ config('other.font-awesome') }} fa-check" style="color: green;"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times" style="color: red"></i>
                    @endif
                </dd>
                <dt>
                    <a href="{{ route('invites.index', ['username' => $user->username]) }}">
                        {{ __('user.invites') }}
                    </a>
                </dt>
                <dd>{{ $user->invites }}</dd>
            </dl>
        </x-panel>
    @endif
@endsection
