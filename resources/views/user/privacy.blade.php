@extends('layout.default')

@section('title')
    <title>{{ $user->username }} - Privacy - {{ __('common.members') }} - {{ config('other.title') }}</title>
@endsection

@section('breadcrumb')
    <li>
        <a href="{{ route('users.show', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('user_privacy', ['username' => $user->username]) }}" itemprop="url"
           class="l-breadcrumb-item-link">
            <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $user->username }} {{ __('user.privacy') }}
                {{ __('user.settings') }}</span>
        </a>
    </li>
@endsection

@section('secondary-nav')
    <x-nav>
        <x-nav.tab href="{{ route('users.show', ['username' => $user->username]) }}">
            {{ __('user.profile') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('user_settings', ['username' => $user->username]) }}">
            {{ __('user.general') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('user_security', ['username' => $user->username]) }}">
            {{ __('user.security') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('user_privacy', ['username' => $user->username]) }}">
            {{ __('user.privacy') }}
        </x-nav.tab>
        <x-nav.tab href="{{ route('user_notification', ['username' => $user->username]) }}">
            {{ __('user.notification') }}
        </x-nav.tab>
    </x-nav>

@endsection

@section('content')
    <x-panel.tabbed :padded="true" class="container-fluid p-0 some-padding">
        <x-panel.tabbed.tab tabId="profile" active>Profile</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="achievements">Achievements</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="followers">Followers</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="forums">Forums</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="requests">Requests</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="torrents">Torrents</x-panel.tabbed.tab>
        <x-panel.tabbed.tab tabId="other">Other</x-panel.tabbed.tab>
        <x-panel.tabbed.pane tabId="other">
            <form
                method="POST"
                action="{{ route('privacy_other', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.other-privacy') }}</h3>
                        {!! __('user.other-help') !!}.
                    </legend>
                    <label>
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_online == 1))
                            <input type="checkbox" name="show_online" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_online" value="1"/>
                        @endif
                        {{ __('user.other-privacy-online') }}.
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>__('user.visible-to-other')"</h3>
                        {!! __('user.visible-to-other-help') !!}.
                    </legend>
                        @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                            <label>
                                @if (
                                    !$user->privacy
                                    || !$user->privacy->json_other_groups
                                    || $group->isAllowed($user->privacy->json_other_groups,$group->id)
                                )
                                    <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                                @else
                                    <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                                @endif
                                {{ $group->name }}
                            </label>
                        @endforeach
                </fieldset>
                <button type="submit">{{ __('common.save') }} {{ __('user.other-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="requests">
            <form
                method="POST"
                action="{{ route('privacy_request', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.request-privacy') }}</h3>
                        {!! __('user.request-help') !!}.
                    </legend>
                    <label>
                        {{ __('user.request-privacy-requested') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_requested == 1))
                            <input type="checkbox" name="show_requested" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_requested" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-request') }}</h3>
                        {!! __('user.visible-to-request-help') !!}
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if(
                                !$user->privacy
                                || !$user->privacy->json_request_groups
                                || $group->isAllowed($user->privacy->json_request_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                </fieldset>
                <button type="submit">{{ __('common.save') }} {{ __('user.request-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="torrents">
            <form role="form" method="POST"
                  action="{{ route('privacy_torrent', ['username' => $user->username]) }}"
                  enctype="multipart/form-data">
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.torrent-privacy') }}:</h3>
                        {!! __('user.torrent-help') !!}
                    </legend>
                    <label>
                        {{ __('user.torrent-privacy-upload') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_upload == 1))
                            <input type="checkbox" name="show_upload" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_upload" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.torrent-privacy-download') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_download == 1))
                            <input type="checkbox" name="show_download" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_download" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.torrent-privacy-peer') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_peer == 1))
                            <input type="checkbox" name="show_peer" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_peer" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-torrent') }}:</h3>
                        {!! __('user.visible-to-torrent-help') !!}
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if(
                                !$user->privacy
                                || !$user->privacy->json_torrent_groups
                                || $group->isAllowed($user->privacy->json_torrent_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                </fieldset>
                <button type="submit">{{ __('common.save') }} {{ __('user.torrent-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="profile">
            <form
                method="POST"
                action="{{ route('privacy_profile', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.profile-privacy') }}:</h3>
                        {{ __('user.profile-privacy-help') }}.
                    </legend>
                    <label>
                        {{ __('user.profile-privacy-torrent-count') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_torrent_count == 1))
                            <input type="checkbox" name="show_profile_torrent_count" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_torrent_count" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-title') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_title == 1))
                            <input type="checkbox" name="show_profile_title" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_title" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-about') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_about == 1))
                            <input type="checkbox" name="show_profile_about" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_about" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-torrent-ratio') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_torrent_ratio == 1))
                            <input type="checkbox" name="show_profile_torrent_ratio" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_torrent_ratio" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-torrent-seed') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_torrent_seed == 1))
                            <input type="checkbox" name="show_profile_torrent_seed" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_torrent_seed" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-bon-extra') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_bon_extra == 1))
                            <input type="checkbox" name="show_profile_bon_extra" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_bon_extra" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-torrent-extra') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_torrent_extra == 1))
                            <input type="checkbox" name="show_profile_torrent_extra" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_torrent_extra" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-comment-extra') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_comment_extra == 1))
                            <input type="checkbox" name="show_profile_comment_extra" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_comment_extra" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-request-extra') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_request_extra == 1))
                            <input type="checkbox" name="show_profile_request_extra" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_request_extra" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-forum-extra') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_forum_extra == 1))
                            <input type="checkbox" name="show_profile_forum_extra" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_forum_extra" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-warning') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_warning == 1))
                            <input type="checkbox" name="show_profile_warning" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_warning" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-badge') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_badge == 1))
                            <input type="checkbox" name="show_profile_badge" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_badge" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-achievement') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_achievement == 1))
                            <input type="checkbox" name="show_profile_achievement" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_achievement" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.profile-privacy-follower') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_profile_follower == 1))
                            <input type="checkbox" name="show_profile_follower" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_profile_follower" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-profile') }}:</h3>
                        {!! __('user.visible-to-profile-help') !!}
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if(
                                !$user->privacy
                                || !$user->privacy->json_profile_groups
                                || $group->isAllowed($user->privacy->json_profile_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                </fieldset>
                <button type="submit">{{ __('common.save') }} {{ __('user.profile-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="forums">
            <form
                method="POST"
                action="{{ route('privacy_forum', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.forum-privacy') }}:</h3>
                        {!! __('user.forum-help') !!}
                    </legend>
                    <label>
                        {{ __('user.forum-privacy-topic') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_topic == 1))
                            <input type="checkbox" name="show_topic" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_topic" value="1"/>
                        @endif
                    </label>
                    <label>
                        {{ __('user.forum-privacy-post') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_post == 1))
                            <input type="checkbox" name="show_post" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_post" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-forum') }}:</h3>
                        {!! __('user.visible-to-forum-help') !!}
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if(
                                !$user->privacy
                                || !$user->privacy->json_forum_groups
                                || $group->isAllowed($user->privacy->json_forum_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                </fieldset>
                <button type="submit">{{ __('common.save') }} {{ __('user.forum-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="followers">
            <form
                method="POST"
                action="{{ route('privacy_follower', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.follower-privacy') }}:</h3>
                        {!! __('user.follower-help') !!}
                    </legend>
                    <label>
                        {{ __('user.follower-privacy-list') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_follower == 1))
                            <input type="checkbox" name="show_follower" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_follower" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-follower') }}:</h3>
                        {!! __('user.visible-to-follower-help') !!}.
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if (
                                !$user->privacy
                                || !$user->privacy->json_follower_groups
                                || $group->isAllowed($user->privacy->json_follower_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                    <button type="submit">{{ __('common.save') }} {{ __('user.follower-privacy') }}</button>
                </fieldset>
            </form>
        </x-panel.tabbed.pane>
        <x-panel.tabbed.pane tabId="achievements">
            <form
                method="POST"
                action="{{ route('privacy_achievement', ['username' => $user->username]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <fieldset>
                    <legend>
                        <h3>{{ __('user.achievement-privacy') }}:</h3>
                        {!! __('user.achievement-help') !!}.
                    </legend>
                    <label>
                        {{ __('user.achievement-privacy-list') }}.
                        @if(!$user->privacy || ($user->privacy && $user->privacy->show_achievement == 1))
                            <input type="checkbox" name="show_achievement" value="1" CHECKED/>
                        @else
                            <input type="checkbox" name="show_achievement" value="1"/>
                        @endif
                    </label>
                </fieldset>
                <fieldset>
                    <legend>
                        <h3>{{ __('user.visible-to-achievement') }}:</h3>
                        {!! __('user.visible-to-achievement-help') !!}.
                    </legend>
                    @foreach($groups->filter(fn ($group) => ! ($group->is_modo || $group->is_admin)) as $group)
                        <label>
                            {{ $group->name }}
                            @if(
                                !$user->privacy
                                || !$user->privacy->json_achievement_groups
                                || $group->isAllowed($user->privacy->json_achievement_groups,$group->id)
                            )
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}" CHECKED/>
                            @else
                                <input type="checkbox" name="approved[]" value="{{ $group->id }}"/>
                            @endif
                        </label>
                    @endforeach
                </fieldset>
                <button type="submit" >{{ __('common.save') }} {{ __('user.achievement-privacy') }}</button>
            </form>
        </x-panel.tabbed.pane>
    </x-panel.tabbed>
@endsection

@section('javascripts')
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">
      $(window).on('load', function () {
        loadTab()
      })

      function loadTab () {
        if (window.location.hash && window.location.hash == '#visible_tab') {
          $('#basetabs a[href="#visible_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#torrent_tab') {
          $('#basetabs a[href="#torrent_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#forum_tab') {
          $('#basetabs a[href="#forum_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#profile_tab') {
          $('#basetabs a[href="#profile_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#follower_tab') {
          $('#basetabs a[href="#follower_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#achievement_tab') {
          $('#basetabs a[href="#achievement_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#request_tab') {
          $('#basetabs a[href="#request_tab"]').tab('show')
        }
        if (window.location.hash && window.location.hash == '#other_tab') {
          $('#basetabs a[href="#other_tab"]').tab('show')
        }
      }

    </script>
@endsection
