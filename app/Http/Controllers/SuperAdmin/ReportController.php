<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'revenue');

        if ($type === 'tenant-usage') {
            $data = Company::withCount(['branches', 'users'])
                ->latest()
                ->paginate(20);
        } else {
            // ডিফল্ট: revenue রিপোর্ট
            $type = 'revenue';
            $data = Transaction::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('SUM(amount) as total')
                )
                ->groupBy('month')
                ->orderByDesc('month')
                ->limit(12)
                ->get();
        }

        return view('super-admin.reports.index', compact('type', 'data'));
    }
}