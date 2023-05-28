<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicines()
    {
        return $this->belongsTo(Medicine::class);
    }
}



