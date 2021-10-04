<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_CANCELED = 0;
    const STATUS_NEW = 1;
    const STATUS_COMPLETED = 2;

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
