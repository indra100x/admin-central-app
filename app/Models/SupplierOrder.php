<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierOrder extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'supermarket_id', 'quantity', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}

