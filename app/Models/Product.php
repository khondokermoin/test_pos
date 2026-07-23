<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // ==========================================
    // 1. Mass Assignment Protection
    // ==========================================

    /**
     * The attributes that are mass assignable.
     * Matches the columns added by the products migration + patch migration.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'category_id',
        'brand_id',
        'name',
        'description',
        'has_variants',
        'is_active',
        'is_bulk',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'has_variants' => 'boolean',
            'is_active'    => 'boolean',
            'is_bulk'      => 'boolean',
        ];
    }

    // ==========================================
    // 2. Eloquent Relationships
    // ==========================================

    /**
     * A product belongs to a Company (Tenant).
     * Used for multi-tenant scoping.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * A product belongs to a Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A product belongs to a Brand (optional).
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * A product has many ProductVariants.
     * Even a "simple" product (no variants) has exactly one variant row.
     * This is the standard POS pattern for unified stock tracking.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * A product has many active ProductVariants.
     * Useful for POS search and display.
     */
    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    /**
     * A product's stock across all branches, accessed through its variants.
     * Uses HasManyThrough: Product -> ProductVariant -> Stock
     * Usage: $product->stocks returns a collection of Stock rows.
     */
    public function stocks(): HasManyThrough
    {
        return $this->hasManyThrough(
            Stock::class,           // Final model
            ProductVariant::class,  // Intermediate model
            'product_id',           // FK on product_variants pointing to products
            'variant_id',           // FK on stocks pointing to product_variants
            'id',                   // Local key on products
            'id'                    // Local key on product_variants
        );
    }

    // ==========================================
    // 3. Query Scopes (For cleaner controllers)
    // ==========================================

    /**
     * Scope: Filter products by company (tenant isolation).
     * Usage: Product::ofCompany($companyId)->get()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $companyId
     */
    public function scopeOfCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope: Only return active products.
     * Usage: Product::active()->get()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Search products by name (for POS search bar).
     * Usage: Product::search('rice')->get()
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where('name', 'LIKE', '%' . $term . '%');
    }
}
