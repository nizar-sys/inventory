<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'code',
        'name',
        'stock',
        'image',
    ];
    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault();
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image);
    }

    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class);
    }
}
