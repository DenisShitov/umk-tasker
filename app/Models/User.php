<?php

namespace App\Models;

use App\Http\Filters\UserFilters;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Support\Authorization\Authorizable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Authorizable, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * Get user permissions
     *
     * @return array
     */
    public function allPermissions()
    {
        if ($this->id == 1) {
            return Permission::pluck('name');
        }

        return $this->roles->first()->permissions->pluck('name');
    }

    /**
     * Get the user's avatar.
     *
     * @param  string  $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ? '/' . $value : null;
    }

    /**
     * Determine if user has admin role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    /**
     * Determine if user has user role.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->hasRole('User');
    }

    /**
     * Get the user's favorite projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(FavoriteProject::class);
    }

    /**
     * Apply all relevant filters.
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  App\Http\Filters\UserFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, UserFilters $filters)
    {
        return $filters->apply($query);
    }
}
