<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;


    protected $table = 'product_variants';

    protected $fillable = [

        'product_id',
        'variant_name',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantOptions()
    {
        return $this->hasmany(ProductVariantOption::class);
    }


}
