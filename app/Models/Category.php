<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return "{$this->code} - {$this->name}";
    }
}
