<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'phone',
        'email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'branch_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
