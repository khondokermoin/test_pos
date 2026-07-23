<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // শুধুমাত্র এই কলামগুলোই ডাটাবেসে আছে
    protected $fillable = [
        'company_id',
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}