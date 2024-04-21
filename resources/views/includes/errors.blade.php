<div>
    @if(session()->has('error'))
    <div class="info error show">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    @if(session()->has('success'))
    <div class="info success show">
        <p>{{ session('success') }}</p>
    </div>
    @endif
</div>
