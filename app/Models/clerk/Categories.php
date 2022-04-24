<?php

namespace App\Models\clerk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected  $table = 'categories';
    public $timestamps = false;
    protected $fillable = [
        'id', 'category_name', 'category_name_ar', 'description', 'description_ar', 'img'
    ];
    
}

