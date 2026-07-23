<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'contact_person',
        'website',
        'address',
        'city',
        'country',
        'zip_code',
        'logo',
        'subdomain',
        'custom_domain',
        'currency',
        'timezone',
        'settings',
        'status',
        'trial_ends_at',
        'plan_id',
        'user_id',
        'business_type_id'
    ];

    protected $casts = [
        'settings' => 'array',
        'trial_ends_at' => 'datetime',
    ];

    // ==========================================
    // Relationships (রিলেশনশিপ সমূহ)
    // ==========================================

    // ১. কোম্পানির মালিক (Owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ২. কোম্পানির অ্যাডমিন (Alias)
    public function admin()
    {
        return $this->owner();
    }

    // ৩. কোম্পানির অধীনে থাকা সব ইউজার (users relationship)
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    // ৪. কোম্পানির বর্তমান সাবস্ক্রিপশন প্ল্যান
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // ৫. কোম্পানির সাবস্ক্রিপশন হিস্টরি (সর্বশেষ সাবস্ক্রিপশন)
    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    // ৬. কোম্পানির সব পেমেন্ট ট্রানজেকশন হিস্টরি
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ৭. কোম্পানির অধীনে থাকা সব ব্রাঞ্চ
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
