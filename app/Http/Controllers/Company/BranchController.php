<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        
        // শুধুমাত্র বর্তমান কোম্পানির ব্রাঞ্চগুলো আনা
        $branches = Branch::where('company_id', $companyId)
            ->with('manager') // ম্যানেজারের তথ্য লোড করা (যদি User মডেলে relationship থাকে)
            ->latest()
            ->paginate(10);
        
        return view('company.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;
        
        // ড্রপডাউনের জন্য শুধুমাত্র এই কোম্পানির ইউজারদের আনা
        $managers = User::where('company_id', $companyId)->get();
        
        return view('company.branches.create', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_id' => [
                'nullable', 
                // সিকিউরিটি: ম্যানেজার অবশ্যই বর্তমান কোম্পানির ইউজার হতে হবে
                Rule::exists('users', 'id')->where('company_id', Auth::user()->company_id)
            ],
        ]);

        Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'manager_id' => $request->manager_id,
            'company_id' => Auth::user()->company_id, // ✅ এই লাইনটি থাকা জরুরি
            'status' => 'active',
        ]);

        return redirect()->route('company.branches.index')
            ->with('success', 'Branch created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // সিকিউরিটি: নিশ্চিত করা যে ব্রাঞ্চটি বর্তমান কোম্পানির অধীনে
        $branch = Branch::where('company_id', Auth::user()->company_id)->findOrFail($id);
        
        return view('company.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = Branch::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $managers = User::where('company_id', Auth::user()->company_id)->get();
        
        return view('company.branches.edit', compact('branch', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $branch = Branch::where('company_id', Auth::user()->company_id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_id' => [
                'nullable', 
                Rule::exists('users', 'id')->where('company_id', Auth::user()->company_id)
            ],
            'status' => 'required|in:active,inactive',
        ]);

        $branch->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'manager_id' => $request->manager_id,
            'status' => $request->status,
        ]);

        return redirect()->route('company.branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = Branch::where('company_id', Auth::user()->company_id)->findOrFail($id);
        
        // (Optional) আপনি চাইলে ডিলিট করার আগে চেক করতে পারেন যে এই ব্রাঞ্চে কোনো ইউজার বা প্রোডাক্ট আছে কিনা
        // if ($branch->users()->count() > 0) {
        //     return back()->with('error', 'Cannot delete a branch that has assigned users.');
        // }

        $branch->delete();

        return redirect()->route('company.branches.index')
            ->with('success', 'Branch deleted successfully!');
    }
}