<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['category_id', 'name', 'brand', 'model', 'image'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function issues()
    {
        return $this->belongsToMany(DeviceIssue::class, 'device_issue_device')
                ->withPivot('cost')
                ->withTimestamps();
    }

    // Add relationship to ServiceRequest
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

}
