<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'wallet',
        'nbPurchasedProducts'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
