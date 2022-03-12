<x-panel :padded="true" class="block--online">
    <x-slot name="heading">
        <i class="{{ config('other.font-awesome') }} fa-users"></i>
        {{ __('blocks.users-online') }}
        ({{ $users->count() }})
    </x-slot>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem 1rem;">
        @foreach ($users as $user)
            <x-chip.user
                :anon="$user->hidden == 1 || !$user->isVisible($user, 'other', 'show_online')"
                :userId="$user->id"
                :username="$user->username"
                :href="route('users.show', ['username' => $user->username])"
                :icon="$user->group->icon"
                :color="$user->group->color"
                :group="$user->group->name"
            />
        @endforeach
    </div>
    <x-slot name="footer">
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem 1rem; padding: 0.5rem;">
            <x-chip.user
                :anon="false"
                :username="__('common.hidden')"
                icon="fa-eye-slash"
                :group="__('common.hidden')"
            />
            @foreach ($groups as $group)
                <x-chip.user
                    :anon="false"
                    :username="$group->name"
                    :icon="$group->icon"
                    :color="$group->color"
                    :group="$group->name"
                    :effect="$group->effect"
                />
            @endforeach
        </div>
    </x-slot>
</x-panel>
