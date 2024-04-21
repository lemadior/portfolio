
@error($error)
    <div class="validation__error">
        @foreach($errors->get($error) as $msg)
        <p>{{ $msg }}</p>
        @endforeach
    </div>
@enderror
