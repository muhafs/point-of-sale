<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['image_path', 'profit_percent'];

    public function getImagePathAttribute()
    {
        return asset('uploads/products/' . $this->image);
    }

    public function getProfitPercentAttribute()
    {
        //? 100 - 80 = 20$
        $profit = $this->sale_price - $this->purchase_price;
        //? 20 x 100 / 80 = 25%
        $profit_percent = $profit * 100 / $this->purchase_price;

        return number_format($profit_percent, 2);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
