<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relation to Order Table
    public function orders()
    {
        // This Client has Many Orders
        return $this->hasMany(Order::class);
    }
}
