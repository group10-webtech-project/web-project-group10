<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 *
 * @property string username
 * @property string name
 * @property string email
 * @property string password
 * @property string role
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'two_factor_auth_code',
        'two_factor_auth_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'last_login',
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
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function generateTwoFactorAuthCode()
    {
        $this -> timestamps = false;
        $this -> two_factor_auth_code = rand(10000, 99999);
        $this -> two_factor_auth_expires_at = now()->addMinutes(20);
        $this -> save();
    }

    public function resetTwoFactorAuthCode()
    {
        $this -> timestamps = false;
        $this -> two_factor_auth_code = null;
        $this -> two_factor_auth_expires_at = null;
        $this -> save();
    }
}
