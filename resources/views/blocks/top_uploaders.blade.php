<x-panel.tabbed class="block--top-uploaders">
    <x-slot name="heading">
        <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
        {{ __('user.top-uploaders-count') }}
    </x-slot>
    <x-panel.tabbed.tab tabId="allTime">
        <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
        {{ __('stat.all-time') }}
    </x-panel.tabbed.tab>
    <x-panel.tabbed.tab tabId="30days" active>
        <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
        {{ __('stat.last30days')}}
    </x-panel.tabbed.tab>
    <x-panel.tabbed.pane tabId="allTime">
        <table class="data-table">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('common.user') }}</th>
                    <th>{{ __('user.total-uploads') }}</th>
                    <th>{{ __('stat.place') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uploaders as $key => $uploader)
                    <tr>
                        <td>
                            <i class="{{ config('other.font-awesome') }} fa-trophy-alt"></i>
                        </td>
                        <td>
                            <x-chip.user
                                :anon="$uploader->user->private_profile == 1"
                                :userId="$uploader->user->id"
                                :username="$uploader->user->username"
                                :href="route('users.show', ['username' => $uploader->user->username])"
                                :icon="$uploader->user->group->icon"
                                :color="$uploader->user->group->color"
                                :group="$uploader->user->group->name"
                            />
                        </td>
                        <td>{{ $uploader->user->getUploads() }}</td>
                        <td>
                            <i class="{{ config('other.font-awesome') }} fa-ribbon"></i>
                            {{ App\Helpers\StringHelper::ordinal(++$key) }} {{ __('stat.place') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel.tabbed.pane>
    <x-panel.tabbed.pane tabId="30days">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="torrents-icon"></th>
                    <th>{{ __('common.user') }}</th>
                    <th>{{ __('user.total-uploads') }}</th>
                    <th>{{ __('stat.place') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($past_uploaders as $key => $uploader)
                    <tr>
                        <td>
                            <i class="{{ config('other.font-awesome') }} fa-trophy text-success torrent-icon"></i>
                        </td>
                        <td>
                            <x-chip.user
                                :anon="$uploader->user->private_profile == 1"
                                :userId="$uploader->user->id"
                                :username="$uploader->user->username"
                                :href="route('users.show', ['username' => $uploader->user->username])"
                                :icon="$uploader->user->group->icon"
                                :color="$uploader->user->group->color"
                                :group="$uploader->user->group->name"
                            />
                        </td>
                        <td>{{ $uploader->user->getLast30Uploads() }}</td>
                        <td>
                            <i class="{{ config('other.font-awesome') }} fa-ribbon"></i>
                            {{ App\Helpers\StringHelper::ordinal(++$key) }} {{ __('stat.place') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel.tabbed.pane>
</x-panel.tabbed>
