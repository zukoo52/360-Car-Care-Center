<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'username',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAllPermissionsAttribute()
    {

        $permissions = [];
        $role_name = $this->getRoleNames()[0];

        if ($role_name == "Super Admin") {
            $permission_array = Permission::all('name');
            foreach ($permission_array as $per) {
                array_push($permissions, $per->name);
            }

            return $permissions;
        }

        $role = Role::whereName($role_name)->first();

        $permissions_list = $role->permissions()->get(['name']);
        foreach ($permissions_list as $per) {
            array_push($permissions, $per->name);
        }

        return $permissions;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function image() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function notifications() : MorphMany
    {
        return $this->morphMany(UserNotifications::class, 'notifiable');
    }

}
