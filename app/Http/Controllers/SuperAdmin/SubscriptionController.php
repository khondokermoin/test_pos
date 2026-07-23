<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['company', 'plan']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by company name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('company', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats for dashboard cards
        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'trial' => Subscription::where('status', 'trial')->count(),
            'expired' => Subscription::where('ends_at', '<', now())->count(),
        ];

        return view('super-admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function show(string $id)
    {
        $subscription = Subscription::with(['company', 'plan'])->findOrFail($id);
        return view('super-admin.subscriptions.show', compact('subscription'));
    }

    public function cancel(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        return back()->with('success', 'Subscription cancelled successfully.');
    }

    public function suspend(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'suspended']);
        return back()->with('success', 'Subscription suspended successfully.');
    }

    public function reactivate(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update([
            'status' => 'active',
            'cancelled_at' => null,
        ]);
        return back()->with('success', 'Subscription reactivated successfully.');
    }

    public function extend(Request $request, string $id)
    {
        $request->validate(['extend_days' => 'required|integer|min:1|max:365']);

        $subscription = Subscription::findOrFail($id);
        $currentEnd = $subscription->ends_at ? Carbon::parse($subscription->ends_at) : now();
        $newEndDate = $currentEnd->addDays($request->extend_days);

        $subscription->update(['ends_at' => $newEndDate]);

        return back()->with('success', "Subscription extended by {$request->extend_days} days. New end date: {$newEndDate->format('Y-m-d')}");
    }
}