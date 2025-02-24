@if (session('status'))
    <div class="alert alert-{{ session('status') }} mx-4" role="alert">
        {{ session('message') }}
    </div>
@endif
