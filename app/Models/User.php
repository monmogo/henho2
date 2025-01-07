<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{  
    /** @use HasFactory<\Database\Factories\UserFactory> */

    use HasFactory, Notifiable;
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'name', 'email', 'password', 'role', 'username', 'phone', 'avatar',
        'score', 'trust_score', 'gender', 'bank_account_number', 'bank_name', 'account_holder_name'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
