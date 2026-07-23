<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales()
    {
        // আপনার ফোল্ডার স্ট্রাকচার অনুযায়ী daily-sales.blade.php আছে
        return view('company.reports.daily-sales');
    }

    public function stock()
    {
        // স্টক রিপোর্টের জন্য ভিউ (যদি না থাকে, ধাপ ২ দেখুন)
        return view('company.reports.stock');
    }
}
