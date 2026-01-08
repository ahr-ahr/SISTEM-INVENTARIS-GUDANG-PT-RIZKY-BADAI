<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'role_id',
        'employee_id',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'is_active'     => 'boolean',
        'last_login_at'=> 'datetime',
    ];

    /* =====================================================
     | RELATIONSHIPS
     |=====================================================*/

    /**
     * User belongs to Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User belongs to Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /* =====================================================
     | AUTHORIZATION HELPERS (RBAC)
     |=====================================================*/

    /**
     * Check user permission
     */
    public function hasPermission(string $permission): bool
    {
        if (! $this->role) {
            return false;
        }

        return $this->role
            ->permissions
            ->contains('name', $permission);
    }

    /**
     * Shortcut for policy / gate
     */
    public function canDo(string $permission): bool
    {
        return $this->hasPermission($permission);
    }

    /* =====================================================
     | SCOPES (OPTIONAL BUT CLEAN)
     |=====================================================*/

    /**
     * Scope active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
