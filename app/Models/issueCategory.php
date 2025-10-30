<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class issueCategory extends Model
{
    //
        protected $fillable = [
        'name',
        'description'
    ];


    public function deviceIssues()
   {
    return $this->hasMany(DeviceIssue::class);
    }

    
}
