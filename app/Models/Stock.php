<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['company_id', 'branch_id', 'variant_id', 'quantity', 'reorder_level'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
