<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'phone_number',
        'latitude',
        'longitude',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(product::class, 'supplier_id');
    }
}
