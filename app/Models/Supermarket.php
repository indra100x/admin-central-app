<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supermarket extends Model
{
    use HasFactory;

    protected $table = 'supermarkets';
    protected $fillable = [
        'name',
        'ip_address',
    ];
    public function location(): HasOne
    {
        return $this->hasOne(location::class, 'supermarket_id');
    }

    public function products(): HasMany
    {
       return $this->hasMany(Product::class);
    }
}
