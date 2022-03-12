@props([
    'class' => '',
])

<li {{ $attributes->merge(['class' => 'carousel__slide '.$class]) }}>
    {{ $slot }}
</li>
<style>
    .carousel__slide {
        scroll-snap-align: center;
    }
</style>