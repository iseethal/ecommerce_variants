<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity',
        'variant_ids',
    ];

    public function variantOptions()
    {
        return $this->hasMany(ProductVariantOption::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

}
