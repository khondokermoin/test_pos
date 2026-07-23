<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        // বর্তমান কোম্পানির সব ব্রাঞ্চ লোড করা
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        
        return view('company.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => auth()->user()->company_id, // ✅ অটোমেটিক বর্তমান কোম্পানির আইডি
            'branch_id' => $request->branch_id,         // ✅ UI থেকে সিলেক্ট করা ব্রাঞ্চ আইডি
        ]);

        // Spatie Permission ব্যবহার করলে রোল অ্যাসাইন
        $user->assignRole($request->role);

        return redirect()->route('company.users.index')
            ->with('success', 'User created and assigned to branch successfully!');
    }
}