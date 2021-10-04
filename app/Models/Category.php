<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'parent_id', 'enabled'];

    public function parentCategory()
    {
        return $this->hasOne(self::class, 'user_id', 'id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($category) {
            Cache::forget('enabled_categories');
        });

        static::updated(function ($category) {
            Cache::forget('enabled_categories');
        });

        static::deleted(function ($category) {
            Cache::forget('enabled_categories');
        });
    }
}
