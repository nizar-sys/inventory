<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'contact',
        'address',
    ];

    public function branch()
    {
        return $this->belongsTo(Warehouse::class, 'branch_id', 'id');
    }
}
