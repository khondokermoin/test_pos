<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ১. প্ল্যান সিডার কল করা
        $this->call(PlanSeeder::class);

        // ২. রোল তৈরি
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $companyAdminRole = Role::firstOrCreate(['name' => 'Company Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $salesmanRole = Role::firstOrCreate(['name' => 'Salesman']);

        // ৩. Super Admin (SaaS এর মালিক - এর company_id NULL থাকবে)
        $superAdmin = User::create([
            'name' => 'Khondoker Moin Hossain',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // ==========================================
        // ✅ সংশোধিত লজিক: প্রথমে ইউজার, তারপর কোম্পানি
        // ==========================================
        
        // ৪. প্রথমে Company Admin (Shop Owner) ইউজার তৈরি করা (company_id আপাতত ফাঁকা)
        $companyAdmin = User::create([
            'name' => 'Shop Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $companyAdmin->assignRole($companyAdminRole);

        // ৫. এখন কোম্পানি তৈরি করা, এবং উপরের ইউজারের ID কে user_id হিসেবে পাস করা
        $freeTrialPlan = Plan::where('slug', 'free-trial')->first();
        
        $company = Company::create([
            'name' => 'Demo Super Shop',
            'email' => 'demo@shop.com',
            'user_id' => $companyAdmin->id, // ✅ এখানে user_id পাস করা হচ্ছে
            'plan_id' => $freeTrialPlan ? $freeTrialPlan->id : 1, 
            'status' => 'trial',
            'trial_ends_at' => now()->addDays(14),
        ]);

        // ৬. এখন ইউজারের company_id আপডেট করা
        $companyAdmin->update(['company_id' => $company->id]);

        // ৭. Manager এবং Salesman তৈরি (এখন company_id রেডি আছে)
        $manager = User::create([
            'name' => 'Branch Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'company_id' => $company->id,
        ]);
        $manager->assignRole($managerRole);

        $salesman = User::create([
            'name' => 'Cashier',
            'email' => 'salesman@gmail.com',
            'password' => Hash::make('password'),
            'company_id' => $company->id,
        ]);
        $salesman->assignRole($salesmanRole);

        // ৮. কোম্পানির জন্য সাবস্ক্রিপশন তৈরি
        if ($freeTrialPlan) {
            Subscription::create([
                'company_id' => $company->id,
                'plan_id' => $freeTrialPlan->id,
                'status' => 'trial',
                'started_at' => now(),
                'trial_ends_at' => now()->addDays(14),
                'ends_at' => now()->addDays(14),
            ]);
        }

        // ৯. কোম্পানির জন্য ডিফল্ট মাস্টার ডাটা (Category) সিড করা
        $this->call([
            CategorySeeder::class,
        ]);
        
        $this->command->info('Database seeding completed successfully!');
    }
}