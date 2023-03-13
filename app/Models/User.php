<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'web';

    protected function getDefaultGuardName(): string
    {
        $default = config('auth.defaults.guard');

        return $this->getGuardNames()->first() ?: $default;
    }

    public function agent()
    {
        return $this->hasOne(\App\Models\Agent::class, 'id', 'agent_id');
    }

    public function isSuperAdmin()
    {
        if ($this->role == 'super_admin') {
            return true;
        }
        return false;
    }
    public function isUser()
    {
        if ($this->role == 'user') {
            return true;
        }
        return false;
    }
        public function User_id()
    {
            return $this->agent_id;
    }
    public function isAdmin()
    {
        if ($this->role == 'admin' || $this->role == 'super_admin') {
            return true;
        }
        return false;
    }

    public function isAgent()
    {
        if ($this->role == 'agent') {
            return true;
        }
        return false;
    }
        public function isAgenthappy()
    {
        if ($this->agent_id == '9') {
            return true;
        }
        return false;
    }
}
