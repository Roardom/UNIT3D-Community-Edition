<li class="form__group form__group--short-horizontal">
    <form
        action="{{ route('requests.destroy', ['torrentRequest' => $torrentRequest]) }}"
        method="POST"
        x-data
        style="display: contents"
    >
        @csrf
        @method('DELETE')
        <button
            x-on:click.prevent="confirm('Are you sure you want to delete this torrent request and lose the BON?') && $root.submit()"
            class="form__button form__button--outlined form__button--centered"
        >
            {{ __('common.delete') }}
        </button>
    </form>
</li>
