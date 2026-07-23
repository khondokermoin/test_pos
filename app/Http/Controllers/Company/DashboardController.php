<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_branches' => class_exists(Branch::class) ? Branch::count() : 0,
            'total_products' => class_exists(Product::class) ? Product::count() : 0,
            'total_sales' => class_exists(Sale::class) ? Sale::count() : 0,
        ];

        return Inertia::render('Company/Dashboard', [
            'stats' => $stats
        ]);
    }
}

