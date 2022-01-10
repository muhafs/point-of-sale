<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relation to Product Table
    public function products()
    {
        // This Category Has Many Products
        return $this->hasMany(Product::class);
    }
}
