<x-nav class="{{ $nav }}">
    <x-nav.tab class="bon-nav__bon-item" href="{{ route('bonus') }}">
        {{ __('bon.bon') }}
    </x-nav.tab>
    <x-nav.tab class="bon-nav__store-item" href="{{ route('bonus_store') }}">
        {{ __('bon.store') }}
    </x-nav.tab>
    <x-nav.tab class="bon-nav__gifts-item" href="{{ route('bonus_gifts') }}">
        {{ __('bon.gifts') }}
    </x-nav.tab>
    <x-nav.tab class="bon-nav__tips-item" href="{{ route('bonus_tips') }}">
        {{ __('bon.tips') }}
    </x-nav.tab>
    <x-nav.tab class="bon-nav__send-gift-item" href="{{ route('bonus_gift') }}">
        {{ __('bon.send-gift') }}
    </x-nav.tab>
</x-nav>