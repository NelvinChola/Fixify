<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','contact','nrc','address', 'role_id', 'email_verified_at',
        'verification_token', 'temp_password', 'is_temp_password'

    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_token', 'temp_password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_temp_password' => 'boolean'
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role->name === 'Admin';
    }


    /**
     * This section deals with emails, verications, and temp passwords. 
     */
    
    //Generate verification token 
    public function generateVerificationToken()
    {
        $this->verification_token = Str::random(60);
        $this->save();
        
        return $this->verification_token;
    }

    
     //Generate temporary password
    public function generateTempPassword()
    {
        $tempPassword = Str::random(12); // Generate a strong temporary password
        $this->temp_password = $tempPassword;
        $this->is_temp_password = true;
        $this->save();
        
        return $tempPassword;
    }

    
     //Mark email as verified
    public function markEmailAsVerified()
    {
        $this->email_verified_at = $this->freshTimestamp();
        $this->verification_token = null;
        $this->save();
    }

     //Check if user has temporary password
    public function hasTempPassword()
    {
        return $this->is_temp_password;
    }
}
