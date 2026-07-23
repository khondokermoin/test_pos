<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'unit_id',
        'tax_id',
        'cost_price',
        'selling_price',
        'reorder_level',
        'attributes',    // JSON ডেটা সেভ করার জন্য যোগ করা হয়েছে
        'is_active',
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active'     => 'boolean',
        'attributes'    => 'array', // Laravel অটোমেটিক JSON কে Array তে এবং Array কে JSON এ কনভার্ট করবে
    ];

    /**
     * রিলেশনশিপ: একটি ভেরিয়েন্ট একটি প্রোডাক্টের অন্তর্ভুক্ত
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * রিলেশনশিপ: ভেরিয়েন্টের ইউনিট
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * রিলেশনশিপ: ভেরিয়েন্টের ট্যাক্স
     */
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * রিলেশনশিপ: ভেরিয়েন্টের বর্তমান স্টক (Stock মডেলের সাথে)
     */
    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class, 'variant_id', 'id')
                    ->where('company_id', $this->product->company_id ?? null);
    }
}