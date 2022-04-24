<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    public $timestamps = false;
    protected $fillable = [
        'id', 'sub_category_name', 'sub_category_name_ar', 'sub_description', 'en_category', 'sub_description_ar', 'category_id', 'img'
    ];
}
