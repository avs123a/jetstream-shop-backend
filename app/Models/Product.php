<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'category_id', 'image_path', 'image_url', 'price', 'enabled'];

    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
