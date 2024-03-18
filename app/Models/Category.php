<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'image',
        'description',
    ];

    public function getCreatedAtAttribute($value)
    {
        return $value != '' ? date('Y-m-d', strtotime($value)) : '';
    }
}
