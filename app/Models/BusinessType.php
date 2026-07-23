<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    // ✅ Mass Assignment এর জন্য এই কলামগুলো অনুমোদন করা হলো
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    // যদি is_active কলামটি বুলিয়ান হিসেবে কাজ করে, তবে এটি যোগ করা ভালো
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
