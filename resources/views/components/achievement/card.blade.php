@props([
    'currentPoints' => 0,
    'totalPoints' => 0,
    'name' => '',
    'description' => ''
])

<article class="achievement" title="{{ $currentPoints }}/{{ $totalPoints }}">
    <figure class="achievement__badge">
        <img
            src="/img/badges/{{ $name }}.png"
            alt="{{ $name }}"
            title="{{ $name }}"
        >
        <figcaption class="achievement__description">
            {{ $description }}
        </figcaption>
    </figure>
    <progress
        class="achievement__progress"
        max="{{ $totalPoints }}"
        value="{{ $currentPoints }}"
    >
    </progress>
</article>