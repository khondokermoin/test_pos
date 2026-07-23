@php
    echo \Inertia\Inertia::render('Auth/ResetPassword', [
        'email' => request()->email,
        'token' => request()->route('token'),
    ])->toResponse(request())->getContent();
@endphp
