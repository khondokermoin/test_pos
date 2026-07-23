<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first(); // প্রথম কোম্পানিটি ধরলাম

        Branch::create([
            'company_id' => $company->id,
            'name' => 'Dhanmondi Branch',
            'address' => 'Satmasjid Road, Dhanmondi',
        ]);

        Branch::create([
            'company_id' => $company->id,
            'name' => 'Banani Branch',
            'address' => 'Road 11, Banani',
        ]);
    }
}