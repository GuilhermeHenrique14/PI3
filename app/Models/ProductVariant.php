<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'sku',
        'stock',
    ];

    // Relacionamento de volta para o produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}