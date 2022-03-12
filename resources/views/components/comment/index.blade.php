@props([
    'id' => 1,
    'avatar' => '',
    'username' => '',
    'userId' => 1,
    'anonymous' => True,
    'groupIcon' => '',
    'groupColor' => 'inherit',
    'group' => '',
    'datetime' => '',
    'datetimeHuman' => '',
])

<article id="comment-{{ $id }}" class="comment">
    <header class="comment__header">
        <img
            class="comment__avatar"
            src="{{ url($anonymous ? $avatar : '/img/profile.png') }}"
            alt="{{ $anonymous ? __('common.anonymous') : $username }}"
        />
        <address>
            <x-chip.user
                :anon="$anonymous"
                :userId="$id"
                :username="$username"
                :href="route('users.show', ['username' => $username])"
                :icon="$groupIcon"
                :color="$groupColor"
                :group="$group"
            />
        </address>
        <time
            class="comment__timestamp"
            datetime="{{ $datetime }}"
            title="{{ $datetime }}"
        >
            {{ $datetimeHuman }}
        </time>
        @if (auth()->user()->id == $userId || auth()->user()->group->is_modo)
            <button
                class="comment__edit"
                data-toggle="modal"
                data-target="#modal-comment-edit-{{ $id }}"
            >
                <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
            </button>
            <form
                class="comment__delete"
                action="{{ route('comment_delete', ['comment_id' => $id]) }}"
                method="POST"
            >
                @csrf
                @method('DELETE')
                <button type="submit">
                    <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                </button>
            </form>
        @endif
    </header>
    <section class="comment__content">
        {{ $slot }}
    </section>
</article>
