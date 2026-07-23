<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use App\Models\User;
use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index()
    {
        // ✅ 'owner' রিলেশনশিপ ব্যবহার করা হয়েছে (আপনার মডেল অনুযায়ী)
        $companies = Company::with(['plan', 'owner', 'businessType'])
            ->withCount(['users', 'branches'])
            ->latest()
            ->get();

        $stats = [
            'total'     => $companies->count(),
            'active'    => $companies->where('status', 'active')->count(),
            'trial'     => $companies->where('status', 'trial')->count(),
            'suspended' => $companies->where('status', 'suspended')->count(),
        ];

        return view('super-admin.companies.index', compact('companies', 'stats'));
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        $plans          = Plan::where('status', 'active')->get();
        $users          = User::all();
        $business_types = BusinessType::where('is_active', true)->get();

        return view('super-admin.companies.create', compact('plans', 'users', 'business_types'));
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:companies,slug',
            'email'            => 'required|email|unique:companies,email',
            'contact_person'   => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:50',
            'website'          => 'nullable|url|max:255',
            'address'          => 'nullable|string',
            'city'             => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'zip_code'         => 'nullable|string|max:20',
            'subdomain'        => 'nullable|string|unique:companies,subdomain',
            'custom_domain'    => 'nullable|string|unique:companies,custom_domain',
            'currency'         => 'nullable|string|max:10',
            'timezone'         => 'nullable|string|max:50',
            'status'           => 'required|in:active,inactive,suspended,trial',
            'plan_id'          => 'required|exists:plans,id',
            'user_id'          => 'required|exists:users,id',
            'business_type_id' => 'required|exists:business_types,id',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'settings'         => 'nullable|array',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        // Trial End Date অটোমেটিক ক্যালকুলেশন
        $trialEndsAt = null;
        if ($validated['status'] === 'trial') {
            $plan = Plan::find($validated['plan_id']);
            $trialDays = $plan ? ($plan->trial_days ?? 14) : 14;
            $trialEndsAt = now()->addDays($trialDays);
        }

        DB::beginTransaction();
        try {
            Company::create([
                'name'             => $validated['name'],
                'slug'             => $validated['slug'],
                'email'            => $validated['email'],
                'contact_person'   => $validated['contact_person'] ?? null,
                'phone'            => $validated['phone'] ?? null,
                'website'          => $validated['website'] ?? null,
                'address'          => $validated['address'] ?? null,
                'city'             => $validated['city'] ?? null,
                'country'          => $validated['country'] ?? null,
                'zip_code'         => $validated['zip_code'] ?? null,
                'subdomain'        => $validated['subdomain'] ?? null,
                'custom_domain'    => $validated['custom_domain'] ?? null,
                'currency'         => $validated['currency'] ?? 'BDT',
                'timezone'         => $validated['timezone'] ?? 'Asia/Dhaka',
                'status'           => $validated['status'],
                'plan_id'          => $validated['plan_id'],
                'user_id'          => $validated['user_id'],
                'business_type_id' => $validated['business_type_id'],
                'trial_ends_at'    => $trialEndsAt,
                // ✅ Laravel Model Cast ('array') অটোমেটিক JSON এ কনভার্ট করবে
                'settings'         => $validated['settings'] ?? null, 
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'message'  => 'Company saved successfully!',
                    'redirect' => route('superadmin.companies.index')
                ]);
            }

            return redirect()->route('superadmin.companies.index')
                ->with('success', 'Company created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified company.
     */
    public function show($id)
    {
        $company = Company::with(['plan', 'owner', 'businessType'])
            ->withCount(['users', 'branches'])
            ->findOrFail($id);

        return view('super-admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit($id)
    {
        $company        = Company::findOrFail($id);
        $plans          = Plan::where('status', 'active')->get();
        $users          = User::all();
        $business_types = BusinessType::where('is_active', true)->get();

        return view('super-admin.companies.edit', compact('company', 'plans', 'users', 'business_types'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'slug'             => 'nullable|string|unique:companies,slug,' . $company->id,
            'email'            => 'required|email|unique:companies,email,' . $company->id,
            'contact_person'   => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:50',
            'website'          => 'nullable|url|max:255',
            'address'          => 'nullable|string',
            'city'             => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'zip_code'         => 'nullable|string|max:20',
            'subdomain'        => 'nullable|string|unique:companies,subdomain,' . $company->id,
            'custom_domain'    => 'nullable|string|unique:companies,custom_domain,' . $company->id,
            'currency'         => 'nullable|string|max:10',
            'timezone'         => 'nullable|string|max:50',
            'status'           => 'required|in:active,inactive,suspended,trial',
            'plan_id'          => 'required|exists:plans,id',
            'user_id'          => 'required|exists:users,id',
            'business_type_id' => 'required|exists:business_types,id',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'settings'         => 'nullable|array',
            'trial_ends_at'    => 'nullable|date', // ✅ Expired স্ট্যাটাস ফিক্স করার জন্য
        ]);

        // লোগো আপলোড হ্যান্ডলিং
        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('companies/logos', 'public');
        } else {
            // নতুন লোগো না থাকলে পুরনোটা মুছে যাবে না তাই এটি আনসেট করা হলো
            unset($validated['logo']);
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        // Trial Ends At লজিক
        $trialEndsAt = $request->filled('trial_ends_at') ? $request->trial_ends_at : $company->trial_ends_at;
        
        if ($validated['status'] === 'trial' && empty($trialEndsAt)) {
            $plan = Plan::find($validated['plan_id']);
            $trialDays = $plan ? ($plan->trial_days ?? 14) : 14;
            $trialEndsAt = now()->addDays($trialDays);
        }

        // ✅ ডাটাবেস আপডেট (Model Cast অটোমেটিক settings অ্যারে হ্যান্ডেল করবে)
        $company->update([
            'name'             => $validated['name'],
            'slug'             => $validated['slug'],
            'email'            => $validated['email'],
            'contact_person'   => $validated['contact_person'] ?? null,
            'phone'            => $validated['phone'] ?? null,
            'website'          => $validated['website'] ?? null,
            'address'          => $validated['address'] ?? null,
            'city'             => $validated['city'] ?? null,
            'country'          => $validated['country'] ?? null,
            'zip_code'         => $validated['zip_code'] ?? null,
            'subdomain'        => $validated['subdomain'] ?? null,
            'custom_domain'    => $validated['custom_domain'] ?? null,
            'currency'         => $validated['currency'] ?? 'BDT',
            'timezone'         => $validated['timezone'] ?? 'Asia/Dhaka',
            'status'           => $validated['status'],
            'plan_id'          => $validated['plan_id'],
            'user_id'          => $validated['user_id'], // ✅ সঠিক কলাম নাম
            'business_type_id' => $validated['business_type_id'],
            'trial_ends_at'    => $trialEndsAt,          // ✅ আপডেট হচ্ছে
            'settings'         => $request->has('settings') ? $request->settings : $company->settings,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message'  => 'Company updated successfully!',
                'redirect' => route('superadmin.companies.index')
            ]);
        }

        return redirect()->route('superadmin.companies.index')
            ->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message'  => 'Company deleted successfully!',
                'redirect' => route('superadmin.companies.index')
            ]);
        }

        return redirect()->route('superadmin.companies.index')
            ->with('success', 'Company deleted successfully!');
    }
}