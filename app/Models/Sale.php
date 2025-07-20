<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Sale.php
class Sale extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
