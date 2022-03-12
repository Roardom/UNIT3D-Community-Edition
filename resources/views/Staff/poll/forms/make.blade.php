<form method="POST" action="{{ route('staff.polls.store') }}">
    @csrf
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <label>
        {{ __('common.title') }}
        <input type="text" name="title" value="" required>
    </label>
    <label>
        {{ __('poll.option') }} 1:
        <input type="text" name="options[]" value="">
    </label>
    <label>
        {{ __('poll.option') }} 2:
        <input type="text" name="options[]" value="">
    </label>
    <div class="more-options"></div>
    <button id="add">{{ __('poll.add-option') }}</button>
    <button id="del">{{ __('poll.delete-option') }}</button>
    <label>
        <input type="checkbox" name="multiple_choice" value="1">{{ __('poll.multiple-choice') }}
    </label>
    <button type="submit">{{ __('poll.create-poll') }}</button>
</form>

<template>
    <label
</template>

@section('javascripts')
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">
      let options = 2
      const langOption = "<?php echo __('poll.option') ?>"

      $('#add').on('click', function (e) {
        e.preventDefault()
        options += 1
        const optionHTML = '<div class="extra-option"><label for="option' + options + '">' + langOption
          + options
          + ':</label><input type="text" name="options[]" value="" required></div>'
        $('.more-options').append(optionHTML)
      })

      $('#del').on('click', function (e) {
        e.preventDefault()
        options = (options > 2) ? options - 1 : 2
        $('.extra-option').last().remove()
      })

    </script>
@endsection
