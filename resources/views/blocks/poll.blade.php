@if ($poll && $poll->voters->where('user_id', '=', auth()->user()->id)->isEmpty())
    <x-panel :padded="true">
        <x-slot name="heading">
            <i class="{{ config('other.font-awesome') }} fa-chart-pie"></i>
            {{ __('poll.poll') }} - {{ $poll->title }}
        </x-slot>
        <form method="POST" action="/polls/vote">
            @csrf
            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            {!! csrf_field() !!}
            @if ($poll->multiple_choice)
                @foreach ($poll->options as $option)
                    <label>
                        <input type="checkbox" name="option[]" value="{{ $option->id }}">
                        <span class="badge-user">{{ $option->name }}</span>
                    </label>
                @endforeach
            @else
                @foreach ($poll->options as $option)
                    <label>
                        <input type="radio" name="option[]" value="{{ $option->id }}" required>
                        <span class="badge-user">{{ $option->name }}</span>
                    </label>
                @endforeach
            @endif
            <button type="submit" class="btn btn-primary">{{ __('poll.vote') }}</button>
        </form>
        @if ($poll->multiple_choice)
            <span>{{ __('poll.multiple-choice') }}</span>
        @endif
    </x-panel>
@endif
