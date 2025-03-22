<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'barcode',
        'price',
        'category_id',
        'supplier_id',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(ProductsCategory::class, 'category_id');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(supplier::class, 'supplier_id');
    }

    public function supermarket(): BelongsToMany
    {
        return $this->belongsToMany(supermarket::class, 'stocks', 'product_id', 'supermarket_id')->withPivot('quantity');
    }


}
