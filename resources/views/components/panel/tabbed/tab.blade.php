@props([
    'active' => false,
    'tabId'
])

<input class="tab__input" type="radio" name="tabs" id="tab-{{ $tabId }}" {{ $active ? 'checked' : '' }} />
<label class="tab__label" for="tab-{{ $tabId }}">{{ $slot }}</label>
<style>
    #tab-{{ $tabId }}:checked ~ .tab-pane-{{ $tabId }} {
        display: block;
    }
</style>