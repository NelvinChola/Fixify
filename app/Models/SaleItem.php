<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/SaleItem.php
class SaleItem extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
