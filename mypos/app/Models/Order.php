<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relation to Client Table
    public function client()
    {
        // This Order Belongs to One Client
        return $this->belongsTo(Client::class);
    }

    // Relation to Product Table
    public function products()
    {
        // This Order Belongs to Many Product
        return $this->belongsToMany(Product::class, 'product_order');
    }
}
