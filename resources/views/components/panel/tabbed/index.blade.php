@props([
'class' => '',
'heading' => '',
'footer'
])

<section {{ $attributes->merge(['class' => 'panel2 panel--tabbed '.$class]) }}>
    <h4 class="panel2__heading">{{ $heading }}</h4>
    {{ $slot }}
    @isset ($footer)
        <footer class="panel2__footer">
            {{ $footer }}
        </footer>
    @endif
</section>