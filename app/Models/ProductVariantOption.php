<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantOption extends Model
{
    use HasFactory;


    protected $table = 'product_variant_options';

    protected $fillable = [

        'product_id',
        'product_variant_id',
        'variant_option',
        'description',

    ];


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function variants()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id','id');
    }


}
