@props([
    'class'         => '',
    'anon'          => true,
    'userId'        => null,
    'username'      => __('common.anonymous'),
    'href'          => '#',
    'icon'          => '',
    'color'         => 'inherit',
    'group'         => '',
    'effect'        => 'none',
    'appendedIcons' => ''
])

@if ($anon)
    @if (auth()->user()->id === $userId || auth()->user()->group->is_modo)
        <span
            {{ $attributes->merge(['class' => 'chip--user fas fa-eye-slash '.$class]) }}
            {{ $attributes->merge(['class' => 'background-image '.$effect.';'.$class]) }}
            style=""
        >
            (
            <a
                class="chip--user__link chip--anonymous__link {{ $icon }}"
                href="{{ $href }}"
                style="color: {{ $color }}"
                title="{{ $group }}"
            >
                {{ $username }}
            </a>
            {{ $appendedIcons }}
            )
        </span>
    @else
        <span
            {{ $attributes->merge(['class' => 'chip--user fas fa-eye-slash '.$class]) }}
        >
            ({{ __('common.anonymous') }})
        </span>
    @endif
@else
    <span
        {{ $attributes->merge(['class' => 'chip--user '.$class]) }}
        {{ $attributes->merge(['class' => 'background-image '.$effect.';'.$class]) }}
    >
        <a
            class="chip--user__link {{ $icon }}"
            href="{{ $href }}"
            style="color: {{ $color }}"
            title="{{ $group }}"
        >
            {{ $username }}
        </a>
        {{ $appendedIcons }}
    </span>
@endif