<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('company')
            ->latest()
            ->paginate(20);

        return view('super-admin.transactions.index', compact('transactions'));
    }
}