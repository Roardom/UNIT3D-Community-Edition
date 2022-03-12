<x-panel :heading="__('forum.stats')">
    <dl class="key-value">
        <dt>{{ __('forum.forums') }}:</dt>
        <dd>{{ $num_forums }}</dd>
        <dt>{{ __('forum.topics') }}:</dt>
        <dd>{{ $num_topics }}</dd>
        <dt>{{ __('forum.posts') }}:</dt>
        <dd>{{ $num_posts }}</dd>
    </dl>
</x-panel>
