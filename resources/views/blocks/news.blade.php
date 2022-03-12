<x-panel :padded="true" :collapsible="true" class="block--news" :open="$articles->first->newNews" :centered-heading="true">
    <x-slot name="heading">
        @joypixels(':rotating_light:')
        {{ __('blocks.new-news') }}
        {{ $articles->first()->created_at->diffForHumans() }}
        @joypixels(':rotating_light:')
    </x-slot>
    @foreach ($articles as $article)
        <x-article.card
            :id="$article->id"
            :title="$article->title"
            :datetime="$article->created_at"
            :datetime-human="$article->created_at->diffForHumans()"
            :image="$article->image ? 'files/img/'.$article->image : 'img/missing-image.png'"
            :content="$article->content"
        />
    @endforeach
    <x-slot name="footer">
        <a href="{{ route('articles.index') }}">
            {{ __('common.view-all') }}
        </a>
    </x-slot>
</x-panel>