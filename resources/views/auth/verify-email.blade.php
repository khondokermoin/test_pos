@php
    echo \Inertia\Inertia::render('Auth/VerifyEmail', [
        'status' => session('status'),
    ])->toResponse(request())->getContent();
@endphp
