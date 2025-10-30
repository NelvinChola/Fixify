<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceIssue extends Model
{
    protected $fillable = ['issue', 'description','issue_category_id'];


    public function issueCategory()
    {
        return $this->belongsTo(issueCategory::class, 'issue_category_id');
    }

    // ✅ If you have devices <-> issues pivot table
    public function devices()
    {
        return $this->belongsToMany(Device::class)
        ->withPivot('cost')
        ->withTimestamps();
    }
}

