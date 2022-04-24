<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;
    protected $table = 'stores';
    public $timestamps = false;
    protected $guard = 'admin';
    protected $fillable = [
        'id', 'ar_name', 'city', 'en_name', 'category_id', 'location', 'region', 'phone', 'status' ,'delivery_price','logo'
    ];








}
