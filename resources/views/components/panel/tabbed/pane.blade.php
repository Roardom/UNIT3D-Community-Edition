@props([
    'tabId',
])

<section class="tab-pane tab-pane-{{ $tabId }}">
    {{ $slot }}
</section>