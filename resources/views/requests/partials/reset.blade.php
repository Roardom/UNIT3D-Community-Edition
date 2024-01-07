<li class="form__group form__group--short-horizontal">
    <form
        method="POST"
        action="{{ route('requests.approved_fills.destroy', ['torrentRequest' => $torrentRequest]) }}"
        x-data
        style="display: contents"
    >
        @csrf
        @method('DELETE')
        <button
            x-on:click.prevent="
                confirm(
                    'Are you sure you want to revoke the torrent request fill\'s approval and revert the filler\'s bon reward'
                ) && $root.submit()
            "
            class="form__button form__button--outlined form__button--centered"
        >
            Revoke Approval
        </button>
    </form>
</li>
