@props([
    'class' => '',
    'href' => '',
])

<li {{ $attributes->merge(['class' => 'nav-item '.$class]) }}>
    <a class="nav-item__link" href="{{ $href }}">
        {{ $slot }}
    </a>
</li>