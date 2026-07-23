@php
    echo \Inertia\Inertia::render('Auth/Login', [
        'canResetPassword' => \Illuminate\Support\Facades\Route::has('password.request'),
        'status' => session('status'),
    ])->toResponse(request())->getContent();
@endphp
