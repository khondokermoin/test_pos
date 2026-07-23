<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // ১. ক্যাশে রিসেট করা (নতুন পারমিশন লোড করার জন্য)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ২. পারমিশনগুলোর তালিকা (আপনার প্রয়োজন অনুযায়ী বাড়াতে বা কমাতে পারেন)
        $permissions = [
            // User & Role Management
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',

            // SaaS Management (Super Admin Only)
            'view companies', 'create companies', 'edit companies', 'delete companies',
            'view plans', 'create plans', 'edit plans', 'delete plans',
            'view subscriptions', 'manage subscriptions',
            'view transactions',

            // POS & Inventory (Company/Branch)
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view sales', 'create sales', 'edit sales', 'delete sales',
            'view purchases', 'create purchases', 'edit purchases', 'delete purchases',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view suppliers', 'create suppliers', 'edit suppliers', 'delete suppliers',
            
            // Reports & Settings
            'view reports', 'view settings', 'manage settings',
        ];

        // ৩. পারমিশনগুলো ডেটাবেসে ইনসার্ট করা (firstOrCreate ব্যবহার করায় ডুপ্লিকেট এড়ানো যাবে)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // ৪. রোল তৈরি এবং পারমিশন অ্যাসাইন করা
        
        // Super Admin (সব পারমিশন পাবে)
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Company Admin (কোম্পানির মালিক, ইনভেন্টরি ও সেলস ম্যানেজ করবে)
        $companyAdmin = Role::firstOrCreate(['name' => 'Company Admin', 'guard_name' => 'web']);
        $companyAdmin->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories',
            'view sales', 'create sales', 'edit sales', 'delete sales',
            'view purchases', 'create purchases',
            'view customers', 'create customers',
            'view suppliers', 'create suppliers',
            'view reports', 'view settings', 'manage settings'
        ]);

        // Manager (ব্রাঞ্চ ম্যানেজার, সেলস এবং রিপোর্ট দেখবে)
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'view products', 'view sales', 'create sales', 'edit sales',
            'view purchases', 'create purchases', 'view reports'
        ]);

        // Salesman (শুধু সেলস করতে পারবে)
        $salesman = Role::firstOrCreate(['name' => 'Salesman', 'guard_name' => 'web']);
        $salesman->givePermissionTo([
            'view products', 'create sales', 'view customers', 'create customers'
        ]);
    }
}