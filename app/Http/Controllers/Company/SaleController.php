<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // পরে এখানে ডাটাবেস থেকে সেলস ডাটা আনবেন
        return view('company.sales.index'); 
    }
}
