@php
    echo \Inertia\Inertia::render('Auth/ConfirmPassword')->toResponse(request())->getContent();
@endphp
