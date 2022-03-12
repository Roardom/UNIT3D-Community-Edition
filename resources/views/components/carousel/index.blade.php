@props([
    'class' => '',
    'carouselId',
])
<div x-data>
    <ul
        {{ $attributes->merge(['class' => 'carousel2 '.$class]) }}
        x-ref="{{ $carouselId }}"
        x-init="setInterval(function () {$el.parentNode.matches(':not(:hover)') ? (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth) ? $el.scrollLeft = 0 : $el.scrollLeft += ($el.getElementsByTagName('li')[0].offsetWidth)) : null }, 5000)"
    >
        {{ $slot }}
    </ul>
    <nav class="carousel__nav">
        <button class="carousel__previous" x-on:click="$refs.{{ $carouselId }}.scrollLeft == 0 ? $refs.{{ $carouselId }}.scrollLeft = $refs.{{ $carouselId }}.scrollWidth : $refs.{{ $carouselId }}.scrollLeft -= ($refs.{{ $carouselId }}.getElementsByTagName('li')[0].offsetWidth)">
            <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
        </button>
        <button class="carousel__next" x-on:click="$refs.{{ $carouselId }}.scrollLeft == ($refs.{{ $carouselId }}.scrollWidth - $refs.{{ $carouselId }}.offsetWidth) ? $refs.{{ $carouselId }}.scrollLeft = 0 : $refs.{{ $carouselId }}.scrollLeft += ($refs.{{ $carouselId }}.getElementsByTagName('li')[0].offsetWidth)">
            <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
        </button>
    </nav>
</div>
<style>
    .carousel2::-webkit-scrollbar {
        display: none;
    }

    .carousel2 {
        overflow-x: scroll;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        display: flex;
        flex: 1 1 0;
        list-style-type: none;
        padding: 0;
        margin: 0;
        /*scrollbar-width: none;*/
    }

    .carousel__nav {
        display: flex;
    }

    .carousel__next,
    .carousel__previous {
        flex-grow: 1;
        background-color: var(--panel-head-bg);
        padding: 0.5rem;
    }

    .carousel__next:hover,
    .carousel__previous:hover {
        background-color: #777;
    }
</style>