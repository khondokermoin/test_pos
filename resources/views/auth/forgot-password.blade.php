@php
    echo \Inertia\Inertia::render('Auth/ForgotPassword', [
        'status' => session('status'),
    ])->toResponse(request())->getContent();
@endphp
