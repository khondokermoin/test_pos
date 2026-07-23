<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function profile()
    {
        return view('company.settings.profile');
    }

    public function invoice()
    {
        return view('company.settings.invoice');
    }
}
