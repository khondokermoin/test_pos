<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\User;
use App\Models\Subscription;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_companies' => class_exists(Company::class) ? Company::count() : 0,
            'active_companies' => class_exists(Company::class) ? Company::where('status', 'active')->count() : 0,
            'total_users' => class_exists(User::class) ? User::count() : 0,
            'total_subscriptions' => class_exists(Subscription::class) ? Subscription::count() : 0,
        ];

        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => $stats
        ]);
    }
}

