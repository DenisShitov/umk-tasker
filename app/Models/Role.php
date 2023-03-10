<?php

namespace App\Models;

use App\Support\Optionable;
use App\Http\Filters\RoleFilters;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Optionable;

    /**
     * The users that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The permissions that belong to the role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
