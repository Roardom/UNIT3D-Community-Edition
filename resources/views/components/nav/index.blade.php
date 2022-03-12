@props([
    'class' => '',
])

<nav {{ $attributes->merge(['class' => 'nav2 '.$class]) }}>
    <ul class="nav__left">
        {{ $slot }}
    </ul>
    @isset($right)
        <ul class="nav__right">
            {{ $right }}
        </ul>
    @endisset
</nav>