<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function lowStock()
    {
        // পরে এখানে লো-স্টক প্রোডাক্টের ডাটা আনবেন
        return view('company.inventory.low-stock');
    }

    public function stockAdjust()
    {
        return view('company.inventory.stock_adjust');
    }
}
