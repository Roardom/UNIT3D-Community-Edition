@props([
    'class' => '',
    'heading' => '',
    'footer',
    'centeredHeading' => false,
    'collapsible' => false,
    'condensible' => false,
    'padded',
    'open' => false,
])

@if ($collapsible)
    <section {{ $attributes->merge(['class' => 'panel2 '.$class]) }}>
        <details class="panel--collapsible" {{ $open ? 'open' : '' }}>
            <summary class="panel2__heading {{ $centeredHeading ? 'panel2__heading--centered' : '' }}">
                {{ $heading }}
            </summary>
            @isset ($padded)
                <div class="panel2__body">{{ $slot }}</div>
            @else
                {{ $slot }}
            @endif
            @isset($footer)
                <footer class="panel2__footer">{{ $footer }}</footer>
            @endif
        </details>
    </section>
@elseif ($condensible)
    <section {{ $attributes->merge(['class' => 'panel2 panel--condensible'.$class]) }} x-data="{ open: {{ $open ? 'true' : 'false'}}}">
        <h4 class="panel2__heading {{ $centeredHeading ? 'panel2__heading--centered' : '' }}" x-on:click="open = ! open">
            {{ $heading }}
        </h4>
        @isset ($padded)
            <div class="panel2__body panel2__body--condensed" x-show="!open">{{ $condensed }}</div>
            <div class="panel2__body panel2__body--expanded" x-show="open">{{ $slot }}</div>
        @else
            <div class="panel2__body--condensed" x-show="!open">{{ $condensed }}</div>
            <div class="panel2__body--expanded" x-show="open">{{ $slot }}</div>
        @endif
        @isset($footer)
            <footer class="panel2__footer">{{ $footer }}</footer>
        @endif
    </section>
@else
    <section {{ $attributes->merge(['class' => 'panel2 '.$class]) }}>
        <h4 class="panel2__heading {{ $centeredHeading ? 'panel2__heading--centered' : '' }}">
            {{ $heading }}
        </h4>
        @isset ($padded)
            <div class="panel2__body">{{ $slot }}</div>
        @else
            {{ $slot }}
        @endif
        @isset($footer)
            <footer class="panel2__footer">{{ $footer }}</footer>
        @endif
    </section>
@endif